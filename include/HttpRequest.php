<?php

//
// HttpRequest.php
//
// HTTP リクエストを行う（ライブラリ未使用）
// PEAR等のライブラリがある場合は、ライブラリの使用を推奨する
//
// PHP 5.x only
//
// Sample:
// $http = new HttpRequest('http://wwww.hoge.com', HttpRequest::REQ_HTTP_GET);
// $http->sendRequest();
// echo $http->getResponseBody();
//
define("REQ_CRLF", "\r\n");
class HttpRequest {
    // 定数定義 -----------------------------------------------------
    
    /**
     * （内部用）リクエストヘッダの改行コード
     *
     * @var string
     */
    const REQ_CRLF = "\r\n";
    
    /**
     * リクエストメソッドGET
     *
     * @var string
     */
    const REQ_HTTP_GET = "GET";
    
    /**
     * リクエストメソッドPOST
     *
     * @var string
     */
    const REQ_HTTP_POST = "POST";
    
    /**
     * リクエストHTTPバージョン(1.0)
     *
     * @var string
     */
    const REQ_HTTP_1_0 = "HTTP/1.0";
    
    /**
     * リクエストHTTPバージョン(1.1)
     *
     * @var string
     */
    const REQ_HTTP_1_1 = "HTTP/1.1";
    private $_debug = array();
    
    /**
     * ログクラス
     */
    private $log = null;
    
    /**
     * リクエストURL
     *
     * @var array
     */
    protected $_url = array(
            'URL' => "", // url string(http://user:pass@www.hoge.com)
            'SCHEME' => "", // http/https
            'HOST' => "", // hostname(hoge.com)
            'PORT' => 0, // port no
            'SOC_PORT' => 80, // Socket port no
            'USER' => "", // user
            'PASS' => "", // pass
            'PATH' => "", // path(/hello/helloworld.html)
            'QUERY' => array() 
    ); // get parametars
    
    /**
     * リクエストメソッド
     *
     * @var string
     */
    protected $_method = "";
    
    /**
     * リクエストHTTPプロトコルバージョン
     *
     * @var string
     */
    protected $_http = self::REQ_HTTP_1_1;
    
    /**
     * リクエス文字列
     *
     * @var string
     */
    protected $_request = "";
    
    /**
     * POSTで送信するデータ
     *
     * @var array
     */
    protected $_postData = array();
    
    /**
     * POSTで送信するデータのエンコード
     *
     * @var array
     */
    protected $_postCharset = null;
    
    /**
     * レスポンスヘッダ
     *
     * @var array
     */
    protected $_responseStatus = array(
            'Status' => '',
            'Version' => '',
            'Code' => 0,
            'Message' => '' 
    );
    
    /**
     * レスポンスヘッダ
     *
     * @var array
     */
    protected $_responseHeaders = array();
    
    /**
     * レスポンスデータ
     *
     * @var sting
     */
    protected $_responseBody = "";
    
    /**
     * HTTP1.1でのチャンクサイズ
     *
     * @var int
     */
    protected $_chunkLength = 0;
    
    /**
     * Proxy接続情報
     *
     * @var array
     */
    protected $_proxy = array(
            'HOST' => "", // hostname(hoge.com)
            'PORT' => 8080, // port no
            'USER' => "", // user
            'PASS' => "" 
    ); // pass
    
    /**
     * Proxy接続指定フラグ
     *
     * @var bool
     */
    protected $_useProxy = false;
    
    /**
     * コンストラクタ
     *
     * @param
     *            リクエストURL
     * @param
     *            リクエストメソッド（GET/POST 省略時：GET）
     */
    public function __construct($url, $method = self::REQ_HTTP_GET){
        // URLを解析して登録
        $this->parseURL($url);
        // リクエストメソッド
        $this->_method = $method;
        $this->log = new Logger(__CLASS__);
    }
    
    /**
     * URLを解析する
     *
     * @param
     *            URL文字列
     * @access private
     */
    private function parseURL($url){
        $this->_url['URL'] = $url;
        
        if (preg_match('/^https?:\/\//i', $url)) {
            // URLを分解
            $URL = parse_url($url);
            
            // スキーム
            if (isset($URL['scheme'])) {
                $this->_url['SCHEME'] = $URL['scheme'];
            }
            
            // ホスト
            if (isset($URL['host'])) {
                $this->_url['HOST'] = $URL['host'];
            }
            
            // ポート（:xxで指定されている場合は優先）
            if (isset($URL['port'])) {
                $this->_url['PORT'] = $URL['port'];
                $this->_url['SOC_PORT'] = $URL['port'];
            } // ポート省略時、http -> 80
elseif (strcasecmp($this->_url['SCHEME'], "http") == 0) {
                $this->_url['SOC_PORT'] = 80;
            } // ポート省略時、https -> 443
elseif (strcasecmp($this->_url['SCHEME'], "https") == 0) {
                $this->_url['SOC_PORT'] = 443;
            }
            
            // Basic認証ユーザ
            if (isset($URL['user'])) {
                $this->_url['USER'] = $URL['user'];
            }
            
            // Basic認証パスワード
            if (isset($URL['pass'])) {
                $this->_url['PASS'] = $URL['pass'];
            }
            
            // リクエストパス
            if (isset($URL['path'])) {
                $this->_url['PATH'] = $URL['path'];
            }
            // リクエストパラメータ
            if (isset($URL['query'])) {
                $this->_url['QUERY'] = parseQuerystring($URL['query']);
            }
        }
    }
    
    /**
     * リクエストパラメータを解析して配列化する
     *
     * @return パラメータ配列（[名前] => [値]のハッシュ）
     * @access private
     */
    private function parseQuerystring($querystring){
        // パラメータ区切り子で分解
        $parts = preg_split('/[' . preg_quote(ini_get('arg_separator.input'), '/') . ']/', $querystring, -1, PREG_SPLIT_NO_EMPTY);
        $query = array();
        foreach($parts as $part) {
            // パラメータが「[Key]=[Value]の構成か」
            if (strpos($part, '=') !== false) {
                $value = substr($part, strpos($part, '=') + 1);
                $key = substr($part, 0, strpos($part, '='));
            } else {
                $value = null;
                $key = $part;
            }
            // 配列パラメータ
            if (substr($key, -2) == '[]') {
                $key = substr($key, 0, -2);
                if (@!is_array($query[$key])) {
                    $query[$key] = array();
                    $query[$key][] = $value;
                } else {
                    $query[$key][] = $value;
                }
            } else {
                $query[$key] = $value;
            }
        }
        return $query;
    }
    
    /**
     * POSTのパラメータを登録する
     *
     * @param
     *            パラメータ配列（[名前] => [値]のハッシュ）
     * @param
     *            文字エンコード
     * @access public
     */
    public function setPostData($key, $charset = null){
        if (is_array($key)) {
            $this->_postData = array_merge($this->_postData, $key);
        }
        if (!is_null($charset)) {
            $this->_postCharset = $charset;
        }
    }
    
    /**
     * POSTのパラメータを登録する
     *
     * @param
     *            パラメータ配列（[名前] => [値]のハッシュ）
     * @access public
     */
    public function setProxy($host, $port = 80, $user = '', $pass = ''){
        $this->_proxy['HOST'] = $host;
        $this->_proxy['PORT'] = $port;
        $this->_proxy['USER'] = $user;
        $this->_proxy['PASS'] = $pass;
        $this->_useProxy = true;
    }
    
    /**
     * HTTPリクエストを実行する
     *
     * @return HTTPレスポンスコード
     */
    public function sendRequest(){
        $log = $this->log->getMethodLog(__METHOD__);
        $code = "0"; // レスポンスコード（接続失敗時）
                     // リクエストヘッダを生成
        $this->makeRequest();
        
        $this->_debug[] = $this->_url['SCHEME'] . "/" . $this->_url['HOST'] . "/" . $this->_url['PORT'];
        // リクエスト先に接続
        if ($this->_useProxy) {
            $socket['HOST'] = $this->_proxy['HOST'];
            $socket['PORT'] = $this->_proxy['PORT'];
        } else {
            $socket['HOST'] = $this->_url['HOST'];
            $socket['PORT'] = $this->_url['SOC_PORT'];
        }
        // Proxyを使用せずにHTTPS接続を行う場合のみ
        if (!$this->_useProxy && strcasecmp($this->_url['SCHEME'], 'https') == 0) {
            $socket['HOST'] = 'ssl://' . $socket['HOST'];
        }
        $con = @fsockopen($socket['HOST'], $socket['PORT']);
        $this->_debug[] = "Connect: " . $socket['HOST'] . ":" . $socket['PORT'];
        
        // 接続できたか
        if ($con) {
            $this->_debug[] = "Connect OK:";
            if ($this->_useProxy && strcasecmp($this->_url['SCHEME'], 'https') == 0) {
                $testReq = "CONNECT " . $this->_url['HOST'] . ":" . $this->_url['SOC_PORT'] . " " . $this->_http . self::REQ_CRLF . self::REQ_CRLF;
                $this->_debug[] = "Request: " . $testReq;
                $ret = fwrite($con, $testReq);
                $line = $this->readLine($con);
                if (preg_match('/^(HTTP\/1\.[0-9x]+)\s+([0-9]+)\s+(.+)/i', $line, $match) == 0) {
                    $this->_debug[] = "Request NG: " . $line;
                    fclose($con);
                    return;
                }
                
                $this->_debug[] = "Request OK: " . $line;
                $this->_debug[] = "Response:";
                while(!feof($con)) {
                    $line = $this->readLine($con);
                    $this->_debug[] = $line;
                    if ($line == "") {
                        break;
                    }
                }
            } else {
                $log->info("送信内容：" . $this->_request);
                $this->_debug[] = "Request: " . $this->_request;
                // リクエストを送信
                $ret = fwrite($con, $this->_request);
                
                if ($ret == strlen($this->_request)) {
                    $this->_debug[] = 'Write OK: Sent:' . strlen($this->_request) . ' Send:' . $ret;
                    $this->readResponse($con);
                    $code = $this->_responseStatus['Code'];
                } else {
                    $this->_debug[] = 'Write NG: Sent:' . strlen($this->_request) . ' Send:' . $ret;
                }
            }
            // 接続をクローズ
            fclose($con);
        } else {
            $this->_debug[] = "Connect NG: " . $socket['HOST'] . ":" . $socket['PORT'];
        }
        return $code;
    }
    
    /**
     * HTTPリクエストメッセージを生成する
     *
     * @access private
     */
    private function makeRequest(){
        $this->_request = "";
        $path = "";
        
        // リクエストパス
        // Proxyの場合、アドレスにURLを指定する
        if ($this->_useProxy) {
            $path .= $this->_url['SCHEME'] . '://' . $this->_url['HOST'];
            if ($this->_url['PORT'] > 0) {
                $path .= ':' . $this->_url['PORT'];
            }
        }
        $path .= empty($this->_url['PATH']) ? '/' : $this->_url['PATH'];
        $path .= $this->getQueryString();
        
        $this->_request = $this->_method . ' ' . $path . ' ' . $this->_http . self::REQ_CRLF;
        if ($this->_useProxy) {
            $this->_request .= 'Accept: */*' . self::REQ_CRLF;
            $this->_request .= "Host: " . $this->_url['HOST'] . self::REQ_CRLF;
        } else {
            $this->_request .= "Host: " . $this->_url['HOST'] . self::REQ_CRLF;
            $this->_request .= 'User-Agent: HttpRequest Powered by ' . phpversion() . self::REQ_CRLF;
            $this->_request .= "Connection: close" . self::REQ_CRLF;
            $this->_request .= "Accept-Language: ja" . self::REQ_CRLF;
            if (!empty($this->_url['USER'])) {
                $this->_request .= "Authorization: Basic " . base64_encode($this->_url['USER'] . ':' . $this->_url['PASS']) . self::REQ_CRLF;
            }
        }
        
        // Proxy認証
        if ($this->_useProxy && !empty($this->_proxy['USER'])) {
            $this->_request .= 'Proxy-Authorization: Basic ' . base64_encode($this->_proxy['USER'] . ':' . $this->_proxy['PASS']);
        }
        
        // POSTリクエストの場合、パラメータを登録する
        if (strtoupper($this->_method) == self::REQ_HTTP_POST && count($this->_postData) > 0) {
            // パラメータリストを生成
            foreach($this->_postData as $name => $value) {
                // パラメータが配列の場合
                if (is_array($value)) {
                    foreach($value as $subvalue) {
                        // URLエンコード不要
                        // $post[] = urlencode($name).'='.urlencode($subvalue);
                        $post[] = $name . '=' . $subvalue;
                    }
                } else {
                    // URLエンコード不要
                    // $post[] = urlencode($name).'='.urlencode($value);
                    $post[] = $name . '=' . $value;
                }
            }
            $postdata = implode("&", $post);
            $postlength = strlen($postdata);
            
            $this->_request .= "Content-Type: application/x-www-form-urlencoded";
            if (!is_null($this->_postCharset)) {
                $this->_request .= "; charset=" . $this->_postCharset;
            }
            $this->_request .= self::REQ_CRLF;
            // POSTデータサイズ
            $this->_request .= 'Content-Length: ' . $postlength . self::REQ_CRLF . self::REQ_CRLF;
            // POSTデータ
            $this->_request .= $postdata;
        } else {
            $this->_request .= self::REQ_CRLF;
        }
    }
    
    /**
     * リクエストパラメータを連結してURLパラメータにする
     *
     * @return リクエストパラメータ文字列
     * @access private
     */
    private function getQueryString(){
        $query = array();
        foreach($this->_url['QUERY'] as $key => $value) {
            if (is_array($value)) {
                foreach($value as $subkey => $subvalue) {
                    $query[] = sprintf('%s[%s]=%s', $key, $subkey, $subvalue);
                }
            } elseif (!is_null($value)) {
                $query[] = $key . '=' . $value;
            } else {
                $query[] = $key;
            }
        }
        if (count($query) > 0) {
            $querystring = '?' . implode(ini_get('arg_separator.output'), $query);
        } else {
            $querystring = "";
        }
        return $querystring;
    }
    
    /**
     * レスポンスデータを読み込む
     *
     * @param
     *            ファイルポインタ
     * @access private
     */
    private function readResponse($fp){
        // HTTPステータスの読み込み
        $line = $this->readLine($fp);
        if (preg_match('/^(HTTP\/1\.[0-9x]+)\s+([0-9]+)\s+(.+)/i', $line, $match) == 0) {
            return;
        }
        $this->_responseStatus['Status'] = $line;
        $this->_responseStatus['Version'] = $match[1];
        $this->_responseStatus['Code'] = $match[2];
        $this->_responseStatus['Message'] = $match[3];
        
        // レスポンスヘッダの読み込み
        while(!feof($fp)) {
            $line = $this->readLine($fp);
            if ($line != '') {
                list($hname, $hvalue) = explode(':', $line, 2);
                $this->_responseHeaders[strtolower($hname)] = ltrim($hvalue);
            } else {
                break;
            }
        }
        // Content-lengthが存在しないか、存在してサイズが0以上か
        if (!isset($this->_responseHeaders['content-length']) || 0 != $this->_responseHeaders['content-length']) {
            // チャンク転送であるか
            $chunked = isset($this->_responseHeaders['transfer-encoding']) && ('chunked' == $this->_responseHeaders['transfer-encoding']);
            // レスポンスデータの読み込み
            while(!feof($fp)) {
                if ($chunked) {
                    $data = $this->readChunk($fp);
                } else {
                    $data = $this->readLine($fp) . "\n";
                }
                if ('' == $data) {
                    break;
                }
                $this->_responseBody .= $data;
            }
        }
    }
    
    /**
     * Chunk転送方式の受信
     *
     * @param
     *            ファイルポインタ
     * @return 受信したデータ
     * @access private
     */
    private function readChunk($fp){
        if (!$fp) {
            return '';
        }
        // チャンクのサイズ情報を受信
        if (0 == $this->_chunkLength) {
            $line = $this->readLine($fp);
            if (preg_match('/^([0-9a-f]+)/i', $line, $matches)) {
                // チャンクサイズをセット（16進→10進）
                $this->_chunkLength = hexdec($matches[1]);
                if (0 == $this->_chunkLength) {
                    $this->readLine($fp); // 改行文字まで読み出しておく
                    return '';
                }
            }
        }
        // チャンクのサイズ分受信する
        $data = fread($fp, $this->_chunkLength);
        // 残サイズを算出
        $this->_chunkLength -= strlen($data);
        if (0 == $this->_chunkLength) {
            $this->readLine($fp); // 改行文字まで読み出しておく
        }
        return $data;
    }
    
    /**
     * 行単位で受信
     *
     * @param
     *            ファイルポインタ
     * @return 受信したデータ
     * @access private
     */
    private function readLine($fp){
        if (!$fp) {
            return '';
        }
        // レスポンスデータを受信
        $line = null;
        while(!feof($fp)) {
            $line .= @ fgets($fp, 4096);
            if (substr($line, -1) == "\n") {
                return rtrim($line, "\r\n");
            }
        }
        return $line;
    }
    public function getRequest(){
        return $this->_request;
    }
    public function getResponse(){
        $data = $this->_responseStatus['Status'] . "\n";
        foreach($this->_responseHeaders as $name => $value) {
            $data .= ucfirst($name) . ': ' . $value . "\n";
        }
        return $data;
    }
    public function getResponseBody(){
        return $this->_responseBody;
    }
    public function getEncode(){
        $charset = "";
        if (preg_match('/charset=([^\">]+)/i', $this->_responseBody, $match) > 0) {
            $charset = $match[1];
            $this->_debug[] = "Match Body:" . $match[0];
        } elseif (array_key_exists(strtolower("Content-Type"), $this->_responseHeaders)) {
            if (preg_match('/charset=([^\">]+)/i', $this->_responseHeaders[strtolower("Content-Type")], $match) > 0) {
                $charset = $match[1];
                $this->_debug[] = "Match Header:" . $match[0];
            }
        }
        return trim($charset);
    }
    public function getDebug(){
        return $this->_debug;
    }
}

?>