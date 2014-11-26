<?php

// 共通インクルードファイル
require_once ('common.php');
/*
 * orderIdをキーに個別データ管理を行うクラス
 * DataStoreHelperでファイルとのやり取りを行う
 */
class DataStore {
    
    /**
     * 取引ID
     *
     * @var String
     */
    private $orderId = null;
    
    /**
     * マーチャント暗号鍵
     *
     * @var String
     */
    private $merchantEncKey = null;
    
    /**
     * 決済結果のステータス
     *
     * @var String
     */
    private $mStatus = null;
    
    /**
     * エラーメッセージ
     *
     * @var String
     */
    private $mErrMsg = null;
    
    /**
     * 結果コード
     *
     * @var String
     */
    private $vResultCode = null;
    
    /**
     * セッションID
     */
    private $sessionId = null;
    
    /**
     * 漢字氏名
     */
    private $userName = null;
    
    /**
     * カナ氏名
     */
    private $userNameKana = null;
    
    /**
     * メールアドレス
     */
    private $mailAddress = null;
    
    /**
     * 住所
     */
    private $address = null;
    
    /**
     * 性別
     */
    private $sex = null;
    
    /**
     * 電話番号
     */
    private $telephoneno = null;
    
    /**
     * 郵便番号
     */
    private $zipcode = null;
    
    /**
     * 誕生日
     */
    private $birthday = null;
    
    /**
     * データファイルの登録キーとプロパティの対応マップ
     */
    private $paramMap = array(
            'MERCHANTENCKEY' => 'merchantEncKey',
            'MSTATUS' => 'mStatus',
            'MERRMSG' => 'mErrMsg',
            'VRESULTCODE' => 'vResultCode',
            'SESSIONID' => 'sessionId',
            'USERNAME' => 'userName',
            'USERNAMEKANA' => 'userNameKana',
            'MAILADDRESS' => 'mailAddress',
            'ADDRESS' => 'address',
            'SEX' => 'sex',
            'TELEPHONENO' => 'telephoneno',
            'ZIPCODE' => 'zipcode',
            'BIRTHDAY' => 'birthday' 
    );
    
    /**
     * ログクラス
     */
    private $log = null;
    
    /**
     * コンストラクタ
     */
    public function __construct($orderId = null, $dataStore = null){
        $this->log = new Logger(__CLASS__);
        $log = $this->log->getMethodLog(__METHOD__);
        if (!is_null($orderId) && !is_null($dataStore)) {
            $this->setDataStore($orderId, $dataStore);
            $log->debug('orderId:' . $orderId);
        }
    }
    
    /**
     * 取引IDの設定
     *
     * @return $orderId
     */
    public function getOrderId(){
        return $this->orderId;
    }
    
    /**
     * 取引IDの設定
     *
     * @param $orderId String            
     */
    public function setOrderId($orderId){
        $this->orderId = $orderId;
    }
    
    /**
     * マーチャント暗号鍵の取得
     *
     * @return $merchantEncKey
     */
    public function getMerchantEncKey(){
        return $this->merchantEncKey;
    }
    
    /**
     * マーチャント暗号鍵の設定
     *
     * @param $merchantEncKey String            
     */
    public function setMerchantEncKey($merchantEncKey){
        $this->merchantEncKey = $merchantEncKey;
    }
    
    /**
     * 決済結果のステータスの設定
     *
     * @return String mStatus
     */
    public function getMStatus(){
        return $this->mStatus;
    }
    
    /**
     * 決済結果のステータスの設定
     *
     * @param String $mStatus            
     */
    public function setMStatus($mStatus){
        $this->mStatus = $mStatus;
    }
    
    /**
     * エラーメッセージの取得
     *
     * @return String mErrMsg
     */
    public function getMErrMsg(){
        return $this->mErrMsg;
    }
    
    /**
     * エラーメッセージの設定
     *
     * @param String $mErrMsg            
     */
    public function setMErrMsg($mErrMsg){
        $this->mErrMsg = $mErrMsg;
    }
    
    /**
     * 結果コードの取得
     *
     * @return String vResultCode
     */
    public function getvResultCode(){
        return $this->vResultCode;
    }
    
    /**
     * 結果コードの設定
     *
     * @param String $vResultCode            
     */
    public function setvResultCode($vResultCode){
        $this->vResultCode = $vResultCode;
    }
    
    /**
     * セッションIDの設定
     *
     * @return String sessionId
     */
    public function getSessionId(){
        return $this->sessionId;
    }
    
    /**
     * セッションIDの設定
     *
     * @param String $sessionId            
     */
    public function setSessionId($sessionId){
        $this->sessionId = $sessionId;
    }
    
    /**
     * 漢字氏名の取得
     *
     * @return String userName
     */
    public function getUserName(){
        return $this->userName;
    }
    
    /**
     * 漢字氏名の設定
     *
     * @param String $userName            
     */
    public function setUserName($userName){
        $this->userName = $userName;
    }
    
    /**
     * カナ氏名の取得
     *
     * @return String userNameKana
     */
    public function getUserNameKana(){
        return $this->userNameKana;
    }
    
    /**
     * カナ氏名の設定
     *
     * @param String $userNameKana            
     */
    public function setUserNameKana($userNameKana){
        $this->userNameKana = $userNameKana;
    }
    
    /**
     * メールアドレスの取得
     *
     * @return String mailAddress
     */
    public function getMailAddress(){
        return $this->mailAddress;
    }
    
    /**
     * メールアドレスの設定
     *
     * @param String $mailAddress            
     */
    public function setMailAddress($mailAddress){
        $this->mailAddress = $mailAddress;
    }
    
    /**
     * 住所の取得
     *
     * @return String address
     */
    public function getAddress(){
        return $this->address;
    }
    
    /**
     * 住所の設定
     *
     * @param String $address            
     */
    public function setAddress($address){
        $this->address = $address;
    }
    
    /**
     * 性別の取得
     *
     * @return String sex
     */
    public function getSex(){
        return $this->sex;
    }
    
    /**
     * 性別の設定
     *
     * @param String $sex            
     */
    public function setSex($sex){
        $this->sex = $sex;
    }
    
    /**
     * 電話番号の取得
     *
     * @return String telephoneno
     */
    public function getTelephoneno(){
        return $this->telephoneno;
    }
    
    /**
     * 電話番号の設定
     *
     * @param String $telephoneno            
     */
    public function setTelephoneno($telephoneno){
        $this->telephoneno = $telephoneno;
    }
    
    /**
     * 郵便番号の取得
     *
     * @return String zipcode
     */
    public function getZipcode(){
        return $this->zipcode;
    }
    
    /**
     * 郵便番号の設定
     *
     * @param String $zipcode            
     */
    public function setZipcode($zipcode){
        $this->zipcode = $zipcode;
    }
    
    /**
     * 誕生日の取得
     *
     * @return String birthday
     */
    public function getBirthday(){
        return $this->birthday;
    }
    
    /**
     * 誕生日の設定
     *
     * @param String $birthday            
     */
    public function setBirthday($birthday){
        $this->birthday = $birthday;
    }
    
    /**
     * データ情報を配列化する
     *
     * @return array
     */
    public function getDataStore(){
        $log = $this->log->getMethodLog(__METHOD__);
        $dataStore = array();
        // マップからプロパティ名を取得
        foreach($this->paramMap as $keyName => $paramName) {
            // getterから値を取得
            $getMthod = 'get' . ucfirst($paramName);
            if (method_exists($this, $getMthod)) {
                $value = $this->$getMthod();
            } else {
                $value = null;
            }
            // 値があれば配列に登録
            if (!is_null($value) && $value != '') {
                $dataStore[$keyName] = $value;
            }
        }
        return $dataStore;
    }
    
    /**
     * 配列からデータ情報を登録する
     *
     * @param $orderId String            
     * @param $dataStore ダータ            
     */
    public function setDataStore($orderId, $dataStore){
        $log = $this->log->getMethodLog(__METHOD__);
        $this->setOrderId($orderId);
        if (!is_array($dataStore)) {
            return;
        }
        foreach($dataStore as $keyName => $keyValue) {
            // マップからプロパティ名を取得
            if (array_key_exists($keyName, $this->paramMap)) {
                // setterで値をセット
                $setMthod = 'set' . ucfirst($this->paramMap[$keyName]);
                if (method_exists($this, $setMthod)) {
                    $this->$setMthod($keyValue);
                }
            }
        }
    }
}

?>