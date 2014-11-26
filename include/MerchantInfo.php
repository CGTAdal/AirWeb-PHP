<?php

// 共通インクルードファイル
require_once ('common.php');
/*
 * class MerchantInfo
 * マーチャント情報保持クラス
 * マーチャント固有の設定値（マーチャントID等）はこのパラメータに初期値として登録する
 */
class MerchantInfo {
    
    /**
     * マーチャントID
     *
     * @var String
     */
    private $merchantID = AW_MERCHANT_ID;
    
    /**
     * 取引ID
     *
     * @var String
     */
    private $orderID = null;
    
    /**
     * ブラウザ側暗号鍵
     *
     * @var String
     */
    private $browserEncKey = null;
    
    /**
     * マーチャント側暗号鍵
     *
     * @var String
     */
    private $merchantEncKey = null;
    
    /**
     * セッションID
     *
     * @var String
     */
    private $sessionId = null;
    
    /**
     * マーチャントIDの取得
     *
     * @return マーチャントID
     */
    public function getMerchantID(){
        return $this->merchantID;
    }
    
    /**
     * 取引IDの取得
     *
     * @return 取引ID
     */
    public function getOrderID(){
        return $this->orderID;
    }
    
    /**
     * ブラウザ側暗号鍵の設定
     *
     * @param $browserEncKey ブラウザ側暗号鍵            
     */
    public function setBrowserEncKey($browserEncKey){
        $this->browserEncKey = $browserEncKey;
    }
    
    /**
     * ブラウザ暗号鍵の取得
     *
     * @return ブラウザ側暗号鍵
     */
    public function getBrowserEncKey(){
        return $this->browserEncKey;
    }
    
    /**
     * マーチャント側暗号鍵の設定
     *
     * @param $merchantEncKey マーチャント側暗号鍵            
     */
    public function setMerchantEncKey($merchantEncKey){
        $this->merchantEncKey = $merchantEncKey;
    }
    
    /**
     * マーチャント側暗号鍵の取得
     *
     * @return マーチャント側暗号鍵
     */
    public function getMerchantEncKey(){
        return $this->merchantEncKey;
    }
    
    /**
     * セッションIDの取得
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
     * 取引IDを自動生成する
     * 現在日時＋ユニークIDで取引IDを自動生成する
     *
     * @return 生成した取引ID
     */
    public function createOrderID(){
        // 取引IDアルゴリズムは必要に応じて修正
        $this->orderID = uniqid(date('YmdHis'));
        return $this->orderID;
    }
}

?>