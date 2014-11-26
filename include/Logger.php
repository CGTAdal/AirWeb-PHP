<?php

/**
 * class Logger
 * PHPのerror_log()への出力フォーマットを行う
 * 出力先等の設定はphp.iniで行う
 */
class Logger {
    
    /**
     * ログ出力レベル
     */
    protected $priority;
    
    /**
     * ログ接頭子（クラス名、ファイル名等）
     */
    protected $facility;
    
    /**
     * ログレベルからログファイルに出力する名称への変換テーブル
     */
    protected $levelstring = array(
            E_USER_ERROR => 'ERROR',
            E_USER_WARNING => 'WARN',
            E_USER_NOTICE => 'INFO',
            E_USER_DEBUG => 'DEBUG' 
    );
    
    /**
     * コンストラクタ
     *
     * @param
     *            string facility ログ接頭子（クラス名、ファイル名等）
     * @param
     *            int priority ログ出力レベル（共通設定と違うログレベルを指定したいとき）
     */
    public function __construct($facility, $priority = LOGGER_LEVEL){
        $this->facility = $facility;
        $this->priority = $priority;
        $this->debug('Start');
    }
    
    /**
     * デストラクタ
     */
    public function __destruct(){
        $this->debug('Finish');
    }
    
    /**
     * メソッドログを生成
     *
     * @param
     *            string method メソッド（関数）名
     *            通常__METHOD__を指定する
     */
    public function getMethodLog($method){
        return new Logger($method . '()', $this->priority);
    }
    
    /**
     * 関数ログを生成
     *
     * @param
     *            string method メソッド（関数）名
     *            [File]->[Func1]->[Func2]など、階層構造をログに出力する場合に使用
     */
    public function getFunctionLog($function){
        return new Logger($this->facility . '->' . $function . '()', $this->priority);
    }
    
    /**
     * errorログを出力
     *
     * @param
     *            string message ログメッセージ
     */
    public function error($message){
        if ($this->priority & E_USER_ERROR) {
            error_log($this->getMessage($message, E_USER_ERROR));
        }
    }
    
    /**
     * warnログを出力
     *
     * @param
     *            string message ログメッセージ
     */
    public function warn($message){
        if ($this->priority & E_USER_WARNING) {
            error_log($this->getMessage($message, E_USER_WARNING));
        }
    }
    
    /**
     * infoログを出力
     *
     * @param
     *            string message ログメッセージ
     */
    public function info($message){
        if ($this->priority & E_USER_NOTICE) {
            error_log($this->getMessage($message, E_USER_NOTICE));
        }
    }
    
    /**
     * debugログを出力
     *
     * @param
     *            string message ログメッセージ
     */
    public function debug($message){
        if ($this->priority & E_USER_DEBUG) {
            error_log($this->getMessage($message, E_USER_DEBUG));
        }
    }
    
    /**
     * ログメッセージをフォーマットする
     *
     * @param
     *            string message ログメッセージ
     */
    protected function getMessage($message, $priority){
        return $this->facility . ' ' . $this->levelstring[$priority] . ' ' . $message;
    }
}

?>