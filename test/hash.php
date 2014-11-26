<?php
require_once ('common.php');
class HashForm extends ActionForm {
    private $merchantID = '';
    private $settlementmethod = '';
    private $orderID = '';
    private $amount = '';
    
    /**
     * ログクラス
     */
    private $log = null;
    public function __construct(){
        parent::__construct();
        $this->log = new Logger(__CLASS__);
    }
    public function getMerchantID(){
        return $this->merchantID;
    }
    public function setMerchantID($merchantID){
        $this->merchantID = $merchantID;
    }
    public function getSettlementmethod(){
        return $this->settlementmethod;
    }
    public function setSettlementmethod($settlementmethod){
        $this->settlementmethod = $settlementmethod;
    }
    public function getOrderID(){
        return $this->orderID;
    }
    public function setOrderID($orderID){
        $this->orderID = $orderID;
    }
    public function getAmount(){
        return $this->amount;
    }
    public function setAmount($amount){
        $this->amount = $amount;
    }
    
    /**
     * POSTされたデータを登録する
     */
    public function setPostArray($postArray){
        if (is_array($postArray)) {
            foreach($postArray as $name => $value) {
                $setMthod = 'set' . ucfirst($name);
                if (method_exists($this, $setMthod)) {
                    $this->$setMthod($value);
                }
            }
        }
    }
    
    /**
     * ActionFormのabstruct method
     * エラーチェック
     *
     * @return エラーメッセージ（配列）
     */
    public function validate(){
        $log = $this->log->getMethodLog(__METHOD__);
        $errors = array();
        return $errors;
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
}

$form = new HashForm();

if (isset($_POST['submit'])) {
    $form->setPostArray($_POST);
} else {
    $base = array(
            'merchantID' => 'ID123',
            'orderID' => 'order002',
            'settlementmethod' => '01',
            'amount' => '1400' 
    );
    $form->setPostArray($base);
}
$hash = new HashCodeCreater();
$hashvalue = $hash->getHash($form->getMerchantID(), $form->getSettlementmethod(), $form->getOrderID(), $form->getAmount());
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="ja">
<head>
<meta http-equiv="content-type" content="text/html; charset=EUC-JP">
<meta http-equiv="content-style-type" content="text/css">
<meta http-equiv="content-script-type" content="text/javascript">
<title>ハッシュ計算</title>
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
				<td>マーチャントID</td>
				<td><input type="text" size="40" name="merchantID"
					value="<?= $form->getFormValue('merchantID') ?>"></td>
			</tr>
			<tr>
				<td>オーダーID</td>
				<td><input type="text" size="40" name="orderID"
					value="<?= $form->getFormValue('orderID') ?>"></td>
			</tr>
			<tr>
				<td>決済種別</td>
				<td><input type="text" size="40" name="settlementmethod"
					value="<?= $form->getFormValue('settlementmethod') ?>"></td>
			</tr>
			<tr>
				<td>金額</td>
				<td><input type="text" size="40" name="amount"
					value="<?= $form->getFormValue('amount') ?>"></td>
			</tr>
		</table>
		<br> <input type="submit" name="submit" value="ハッシュ計算">
	</form>
	<p>
Hash:[<?= $hashvalue ?>]<br>
	</p>
</body>
</html>