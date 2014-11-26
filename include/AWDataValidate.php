<?php

// 共通インクルードファイル
require_once ('common.php');

/**
 * class AWDataValidate
 * AWからのリクエストパラメータのチェックと、データの更新を行う
 */
class AWDataValidate {
    
    /**
     * ログクラス
     */
    private $log = null;
    private $resultForm = null;
    
    /*
     * コンストラクタ
     * @param $awPost AWからのリクエストパラメータ
     */
    public function __construct($awPost){
        $this->log = new Logger(__CLASS__);
        $log = $this->log->getMethodLog(__METHOD__);
        // リクエストパラメータを登録する
        $this->resultForm = new ResultForm();
        $this->resultForm->setRequestArray($awPost);
        $log->debug("POSTデータ登録 取引ID：" . $this->resultForm->getOrderId());
        $log->debug("POSTデータ登録 ステータス：" . $this->resultForm->getMStatus());
        $log->debug("POSTデータ登録 エラーメッセージ：" . $this->resultForm->getMErrMsg());
        $log->debug("POSTデータ登録 結果コード：" . $this->resultForm->getvResultCode());
        $log->debug("POSTデータ登録 漢字氏名：" . $this->resultForm->getUserName());
        $log->debug("POSTデータ登録 カナ氏名：" . $this->resultForm->getUserNameKana());
        $log->debug("POSTデータ登録 メールアドレス：" . $this->resultForm->getMailAddress());
        $log->debug("POSTデータ登録 住所：" . $this->resultForm->getAddress());
        $log->debug("POSTデータ登録 性別：" . $this->resultForm->getSex());
        $log->debug("POSTデータ登録 電話番号：" . $this->resultForm->getTelephoneno());
        $log->debug("POSTデータ登録 郵便番号：" . $this->resultForm->getZipcode());
        $log->debug("POSTデータ登録 誕生日：" . $this->resultForm->getBirthday());
    }
    
    /**
     * AWからのRequestの内容確認
     */
    public function resultCheck(){
        $log = $this->log->getMethodLog(__METHOD__);
        $log->debug("チェック開始");
        
        $validate = $this->resultForm->validate();
        // NULLチェック
        if (count($validate) > 0) {
            $log->info("チェックNG");
            return false;
        }
        
        // 登録されているマーチャント側暗号鍵情報を取得
        $dataStoreHelper = new DataStoreHelper();
        $dataStore = $dataStoreHelper->getKey($this->resultForm->getOrderId());
        // 個人情報送信時に取得したマーチャントキーがあるか
        $merchantEncKey = $dataStore->getMerchantEncKey();
        if (is_null($merchantEncKey) || $merchantEncKey == '') {
            // キーが無い＝未登録の取引ID
            $log->warn("取引ID未登録, 取引ID=" . $this->resultForm->getOrderId());
            return false;
        } else {
            $mstatus = $dataStore->getMStatus();
            if (!is_null($mstatus) && $mstatus != '') {
                // ステータス登録済み
                $log->warn("ステータス登録済, 取引ID=" . $this->resultForm->getOrderId());
                return false;
            }
        }
        
        $log->info("チェックOK");
        return true;
    }
    
    /**
     * クライアントから送信されてきたデータと、AWから送信されてきたデータが一致するかをチェック
     */
    public function resultCrossCheck(){
        $log = $this->log->getMethodLog(__METHOD__);
        $log->debug("データ照合開始");
        if (is_null($this->resultForm->getOrderId())) {
            $log->info("取引IDが空");
            return false;
        }
        // 登録されているマーチャント側暗号鍵情報を取得
        $dataStoreHelper = new DataStoreHelper();
        $dataStore = $dataStoreHelper->getKey($this->resultForm->getOrderId());
        
        // 個人情報送信時に取得したマーチャントキーがあるか
        $merchantEncKey = $dataStore->getMerchantEncKey();
        if (is_null($merchantEncKey) || $merchantEncKey == '') {
            // キーが無い＝未登録の取引ID
            $log->info("取引ID未登録");
            return false;
        }
        
        $log->info("dataStore->getMStatus()=" . $dataStore->getMStatus());
        $log->info("dataStore->getvResultCode()=" . $dataStore->getvResultCode());
        $log->info("dataStore->getSessionId()=" . $dataStore->getSessionId());
        $log->info("this->resultForm->getMStatus()=" . $this->resultForm->getMStatus());
        $log->info("this->resultForm->getvResultCode()=" . $this->resultForm->getvResultCode());
        $log->info("this->resultForm->getSessionId()=" . $this->resultForm->getSessionId());
        
        // 取得したパラメータとクライアントからのデータを照合
        $result = 0;
        $result += ((strcmp($dataStore->getMStatus(), $this->resultForm->getMStatus()) == 0) ? 1 : 0);
        $result += ((strcmp($dataStore->getvResultCode(), $this->resultForm->getvResultCode()) == 0) ? 1 : 0);
        $result += ((strcmp($dataStore->getSessionId(), $this->resultForm->getSessionId()) == 0) ? 1 : 0);
        
        if ($result == 3) {
            $log->info("照合OK");
            return true;
        } else {
            $log->info("照合NG");
            return false;
        }
    }
    
    /**
     * マーチャント側暗号鍵情報を更新
     */
    public function updateDataStore(){
        $log = $this->log->getMethodLog(__METHOD__);
        $log->debug("データ更新開始");
        if (is_null($this->resultForm->getOrderId())) {
            $log->debug("取引ID未登録");
            return;
        }
        // 登録されているマーチャント側暗号鍵情報を取得
        $dataStoreHelper = new DataStoreHelper();
        $dataStore = $dataStoreHelper->getKey($this->resultForm->getOrderId());
        // 取得したパラメータを登録
        $dataStore->setMStatus($this->resultForm->getMStatus());
        $dataStore->setMErrMsg($this->resultForm->getMErrMsg());
        $dataStore->setvResultCode($this->resultForm->getvResultCode());
        $dataStore->setUserName($this->resultForm->getUserName());
        $dataStore->setUserNameKana($this->resultForm->getUserNameKana());
        $dataStore->setMailAddress($this->resultForm->getMailAddress());
        $dataStore->setAddress($this->resultForm->getAddress());
        $dataStore->setSex($this->resultForm->getSex());
        $dataStore->setTelephoneno($this->resultForm->getTelephoneno());
        $dataStore->setZipcode($this->resultForm->getZipcode());
        $dataStore->setBirthday($this->resultForm->getBirthday());
        
        // マーチャント側暗号鍵情報を更新
        $dataStoreHelper->setKey($dataStore);
        $log->info("dataStore->getMStatus()=" . $dataStore->getMStatus());
        $log->info("dataStore->getMErrMsg()=" . $dataStore->getMErrMsg());
        $log->info("dataStore->getvResultCode()=" . $dataStore->getvResultCode());
        $log->info("dataStore->getUserName()=" . $dataStore->getUserName());
        $log->info("dataStore->getUserNameKana()=" . $dataStore->getUserNameKana());
        $log->info("dataStore->getMailAddress()=" . $dataStore->getMailAddress());
        $log->info("dataStore->getAddress()=" . $dataStore->getAddress());
        $log->info("dataStore->getSex()=" . $dataStore->getSex());
        $log->info("dataStore->getTelephoneno()=" . $dataStore->getTelephoneno());
        $log->info("dataStore->getZipcode()=" . $dataStore->getZipcode());
        $log->info("dataStore->getBirthday()=" . $dataStore->getBirthday());
        
        $log->info("データ更新完了");
    }
}

?>