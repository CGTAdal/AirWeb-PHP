<?php

// 共通インクルードファイル
require_once ('common.php');

/**
 * orderIdをキーにデータ管理を行うヘルパークラス
 * ファイルには配列で格納するが、外部とはDataStoreクラスでアクセスする
 *
 * 注意：
 * 複数のorderIdからの同時アクセスには対応していません。
 */
class DataStoreHelper {
    
    /**
     * 読み込んだDataStore
     * 処理毎に再読み込みを行う
     */
    private $dataStoreArr = array();
    
    /**
     * ログクラス
     */
    private $log = null;
    
    /**
     * コンストラクタ
     */
    public function __construct(){
        $this->log = new Logger(__CLASS__);
    }
    
    /**
     * DataStoreをファイルに書き出す
     */
    public function setKey(DataStore $dataStore){
        $log = $this->log->getMethodLog(__METHOD__);
        $this->loadDataStore();
        $orderId = $dataStore->getOrderId();
        $this->dataStoreArr[$orderId] = $dataStore->getDataStore();
        $this->saveDataStore();
    }
    
    /**
     * 指定OrderIdのDataStoreをファイルから読み込む
     */
    public function getKey($orderId){
        $log = $this->log->getMethodLog(__METHOD__);
        $dataStore = new DataStore();
        $dataStore->setOrderId($orderId);
        if ($this->loadDataStore()) {
            if (array_key_exists($orderId, $this->dataStoreArr)) {
                $dataStore->setDataStore($orderId, $this->dataStoreArr[$orderId]);
            }
        }
        return $dataStore;
    }
    
    /**
     * DataStore全体をファイルから読み込む
     */
    public function getKeyArray(){
        $keyArray = array();
        if ($this->loadDataStore()) {
            foreach($this->dataStoreArr as $orderId => $dataStore) {
                $keyArray[$orderId] = new DataStore($orderId, $dataStore);
            }
        }
        return $keyArray;
    }
    
    /**
     * DataStoreの読み込み処理
     */
    private function loadDataStore(){
        $log = $this->log->getMethodLog(__METHOD__);
        try {
            if (file_exists(AW_DATASTORE_FILE)) {
                $ser_dataStore = @file_get_contents(AW_DATASTORE_FILE);
                $this->dataStoreArr = unserialize($ser_dataStore);
                return true;
            }
        } catch(Exception $e) {
            $log->error('データファイル読み込み失敗：' . $e->getMessage());
        }
        return false;
    }
    
    /**
     * DataStoreの書き出し処理
     */
    private function saveDataStore(){
        $log = $this->log->getMethodLog(__METHOD__);
        try {
            $ser_dataStore = serialize($this->dataStoreArr);
            @ file_put_contents(AW_DATASTORE_FILE, $ser_dataStore, LOCK_EX);
            return true;
        } catch(Exception $e) {
            $log->error('データファイル書き出し失敗：' . $e->getMessage());
        }
        return false;
    }
}

?>