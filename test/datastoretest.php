<?php
// 共通インクルードファイル
require_once ('common.php');

/*
 * Created on 2013/11/16
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class DataStore extends ActionForm {
    
    /**
     * ログクラス
     */
    private $log = null;
    private $orderId = null;
    private $merchantEncKey = null;
    private $vtwComplete = null;
    private $dataStore = array(
            'VTW_COMPLETE' => null,
            'MERCHANTENCKEY' => null 
    );
    
    /**
     * コンストラクタ
     */
    public function __construct($orderId = null, $dataStore = null){
        parent::__construct();
        $this->log = new Logger(__CLASS__);
        if (!is_null($orderId) && !is_null($dataStore)) {
            $this->setDataStore($orderId, $dataStore);
        }
    }
    public function getOrderId(){
        return $this->orderId;
    }
    public function getMerchantEncKey(){
        return $this->merchantEncKey;
    }
    public function getVtwComplete(){
        return $this->vtwComplete;
    }
    public function getDataStore(){
        if (!is_null($this->getVtwComplete()) && $this->getVtwComplete() != '') {
            $vtwComplete = $this->getVtwComplete();
        }
        if (!is_null($this->getMerchantEncKey()) && $this->getMerchantEncKey() != '') {
            $merchantEncKey = $this->getMerchantEncKey();
        }
        
        return array(
                'VTW_COMPLETE' => $vtwComplete,
                'MERCHANTENCKEY' => $merchantEncKey 
        );
    }
    public function setOrderId($orderId){
        $this->orderId = $orderId;
    }
    public function setMerchantEncKey($merchantEncKey){
        $this->merchantEncKey = $merchantEncKey;
    }
    public function setVtwComplete($vtwComplete){
        $this->vtwComplete = $vtwComplete;
    }
    public function setDataStore($orderId, $dataStore){
        $this->setOrderId($orderId);
        if (is_array($dataStore)) {
            if (isset($dataStore['VTW_COMPLETE'])) {
                $this->setVtwComplete($dataStore['VTW_COMPLETE']);
            }
            if (isset($dataStore['MERCHANTENCKEY'])) {
                $this->setMerchantEncKey($dataStore['MERCHANTENCKEY']);
            }
        }
    }
    
    /**
     * ActionFormのabstruct method
     */
    protected function setValue($name, $value){
        $setMthod = 'set' . ucfirst($name);
        if (method_exists($this, $setMthod)) {
            $this->$setMthod($value);
        }
    }
    
    /**
     * ActionFormのabstruct method
     */
    protected function getValue($name){
        $getMthod = 'get' . ucfirst($name);
        if (method_exists($this, $getMthod)) {
            return $this->$getMthod();
        } else {
            return null;
        }
    }
    public function validate(){
        $log = $this->log->getMethodLog(__METHOD__);
        $errors = array();
        return $errors;
    }
}
class DataStoreHelper {
    private $dataStore = array();
    public function setKey(DataStore $dataStore){
        $this->loadDataStore();
        $orderId = $dataStore->getOrderId();
        $this->dataStore[$orderId] = $dataStore->getDataStore();
        $this->saveDataStore();
    }
    public function getKey($orderId){
        $dataStore = new DataStore();
        $dataStore->setOrderId($orderId);
        if ($this->loadDataStore()) {
            if (array_key_exists($orderId, $this->dataStore)) {
                $dataStore->setDataStore($orderId, $this->dataStore[$orderId]);
            }
        }
        return $dataStore;
    }
    public function getKeyArray(){
        $keyArray = array();
        if ($this->loadDataStore()) {
            foreach($this->dataStore as $orderId => $dataStore) {
                $keyArray[$orderId] = new DataStore($orderId, $dataStore);
            }
        }
        return $keyArray;
    }
    private function loadDataStore(){
        try {
            if (file_exists(AW_DATASTORE_FILE)) {
                $ser_dataStore = @ file_get_contents(AW_DATASTORE_FILE);
                $this->dataStore = unserialize($ser_dataStore);
                return true;
            }
        } catch(Exception $e) {
            $e->getMessage();
        }
        return false;
    }
    private function saveDataStore(){
        try {
            $ser_dataStore = serialize($this->dataStore);
            @ file_put_contents(AW_DATASTORE_FILE, $ser_dataStore, LOCK_EX);
            return true;
        } catch(Exception $e) {
            $e->getMessage();
        }
        return false;
    }
}

$dataStore = new DataStore();
$dataStoreHelper = new DataStoreHelper();

if (isset($_POST['submit'])) {
    $dataStore->setRequestArray($_POST);
    $dataStoreHelper->setKey($dataStore);
}
$keyArray = $dataStoreHelper->getKeyArray();
print_r($keyArray);
print_r($dataStoreHelper);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="ja">
<head>
<meta http-equiv="content-type" content="text/html; charset=EUC-JP">
<meta http-equiv="content-style-type" content="text/css">
<meta http-equiv="content-script-type" content="text/javascript">
<title>Data Store</title>
<style type="text/css">
body, table {
	margin-left: auto;
	margin-right: auto;
	text-align: center;
}
</style>
</head>
<body bgcolor="#DDDDFF">
	<form method="post" action="<?= $_SERVER['PHP_SELF'] ?>" name="Form">
		<table border="0" bgcolor="">
			<tr>
				<td>Order ID</td>
				<td>Key</td>
				<td>Comp</td>
				<td>
			
			</tr>
<?php
foreach($keyArray as $order => $dataStore) {
    ?>
  <tr>
				<td><?= $dataStore->getFormValue('orderId')?></td>
				<td><?= $dataStore->getFormValue('merchantEncKey')?></td>
				<td><?= $dataStore->getFormValue('vtwComplete')?></td>
			</tr>
<?php
} // foreach
?>
  <tr>
				<td><input type="text" size="10" name="orderId" value=""></td>
				<td><input type="text" size="10" name="merchantEncKey" value=""></td>
				<td><input type="text" size="10" name="vtwComplete" value=""></td>
			</tr>
		</table>
		<br> <input type="submit" name="submit" value="追加">
	</form>
</body>
</html>