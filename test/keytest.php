<?php
// 共通インクルードファイル
require_once('common.php');

/*
 * Created on 2006/11/16
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class KeyBox extends ActionForm {
	/**
	 * ログクラス
	 */
	private $log = null;
	private $orderId = null;
	private $settlementKey1B = null;
	private $vtwComplete = null;
	private $keyBox = array('VTW_COMPLETE' => null, 'SETTLEMENTKEY1B' => null);

  /**
   * コンストラクタ
   */
  public function __construct($orderId = null, $keyBox = null) {
    parent::__construct();
    $this->log = new Logger(__CLASS__);
    if (!is_null($orderId) && !is_null($keyBox)) {
      $this->setKeyBox($orderId, $keyBox);
    }
  }

	public function getOrderId() {
		return $this->orderId;
	}
	public function getSettlementKey1B() {
		return $this->settlementKey1B;
	}
	public function getVtwComplete() {
		return $this->vtwComplete;
	}

	public function getKeyBox() {
		if (!is_null($this->getVtwComplete()) && $this->getVtwComplete() != '' ) {
			$vtwComplete = $this->getVtwComplete();
		}
		if (!is_null($this->getSettlementKey1B()) && $this->getSettlementKey1B() != '' ) {
			$settlementKey1B = $this->getSettlementKey1B();
		}
		
		return array('VTW_COMPLETE' => $vtwComplete, 
					'SETTLEMENTKEY1B' => $settlementKey1B);
	}

	public function setOrderId($orderId) {
		$this->orderId = $orderId;
	}
	public function setSettlementKey1B($settlementKey1B) {
		$this->settlementKey1B = $settlementKey1B;
	}
	public function setVtwComplete($vtwComplete) {
		$this->vtwComplete = $vtwComplete;
	}

	public function setKeyBox($orderId, $keyBox) {
		$this->setOrderId($orderId);
		if (is_array($keyBox)) {
			if (isset($keyBox['VTW_COMPLETE'])) {
				$this->setVtwComplete($keyBox['VTW_COMPLETE']);
			}
			if (isset($keyBox['SETTLEMENTKEY1B'])) {
				$this->setSettlementKey1B($keyBox['SETTLEMENTKEY1B']);
			}
		}
	}
  /**
   * ActionFormのabstruct method
   */
  protected function setValue($name, $value) {
    $setMthod = 'set'.ucfirst($name);
    if (method_exists($this, $setMthod)) {
      $this->$setMthod($value);
    }
  }

  /**
   * ActionFormのabstruct method
   */
  protected function getValue($name) {
    $getMthod = 'get'.ucfirst($name);
    if (method_exists($this, $getMthod)) {
      return $this->$getMthod();
    }
    else {
      return null;
    }
  }

	public function validate() {
		$log = $this->log->getMethodLog(__METHOD__);
		$errors = array();
		return $errors;
	}

}

class KeyBoxHelper {
	const KEY_FILE = '../KeyBox/KeyBox.dat';
	private $keyBox = array ();

	public function setKey(KeyBox $keyBox) {
		$this->loadKeyBox();
		$orderId = $keyBox->getOrderId();
		$this->keybox[$orderId] = $keyBox->getKeyBox(); 
		$this->saveKeyBox();
	}

	public function getKey($orderId) {
		$keyBox = new KeyBox();
		$keyBox->setOrderId($orderId);
		if ($this->loadKeyBox()) {
			if (array_key_exists($orderId, $this->keybox)) {
				$keyBox->setKeyBox($orderId, $this->keybox[$orderId]); 
			}
		}
		return $keyBox;
	}
	public function getKeyArray() {
		$keyArray = array();
		if ($this->loadKeyBox()) {
			foreach ($this->keybox as $orderId => $keybox) {
				$keyArray[$orderId] = new KeyBox($orderId, $keybox);
			}
		}
		return $keyArray;
	}

	private function loadKeyBox() {
		try {
			if (file_exists(self::KEY_FILE)) {
				$ser_keybox = @ file_get_contents(self::KEY_FILE);
				$this->keybox = unserialize($ser_keybox);
				return true;
			}
		}
		catch(Exception $e) {
			$e->getMessage();
		}
		return false;
	}
	private function saveKeyBox() {
		try {
			$ser_keybox = serialize($this->keybox); 
			@ file_put_contents(self::KEY_FILE, $ser_keybox, LOCK_EX);
			return true;
		}
		catch(Exception $e) {
			$e->getMessage();
		}
		return false;
	}
} 

$keyBox = new KeyBox();
$keyHelper = new KeyBoxHelper();

if (isset ($_POST['submit'])) {
	$keyBox->setRequestArray($_POST);
	$keyHelper->setKey($keyBox);
}
$keyArray = $keyHelper->getKeyArray();
print_r($keyArray);
print_r($keyHelper);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html lang="ja">
<head>
  <meta http-equiv="content-type" content="text/html; charset=EUC-JP">
  <meta http-equiv="content-style-type" content="text/css">
  <meta http-equiv="content-script-type" content="text/javascript">
  <title>Key Box</title>
<style type="text/css">
body,table {
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
 foreach ($keyArray as $order => $keyBox) {
?>
  <tr>
    <td><?= $keyBox->getFormValue('orderId')?></td>
    <td><?= $keyBox->getFormValue('settlementKey1B')?></td>
    <td><?= $keyBox->getFormValue('vtwComplete')?></td>
  </tr>
<?php
} // foreach
?>
  <tr>
    <td>
      <input type="text" size="10" name="orderId" value="">
    </td>
    <td>
      <input type="text" size="10" name="settlementKey1B" value="">
    </td>
    <td>
      <input type="text" size="10" name="vtwComplete" value="">
    </td>
  </tr>
</table>
<br>
<input type="submit" name="submit" value="追加">
</form>
</body>
</html>