<?php
/*
 * Created on 2006/11/22
*
* To change the template for this generated file go to
* Window - Preferences - PHPeclipse - PHP - Code Templates
*/
// 共通インクルードファイル
require_once('common.php');

class MBForm extends ActionForm {
	private $text = '';

	public function __construct() {
		parent::__construct();
	}

	public function getText() {
		return $this->text;
	}

	public function setText($text) {
		$this->text = $text;
	}

	/**
	 * POSTされたデータを登録する
	 */
	public function setPostArray($postArray) {
		if (is_array($postArray)) {
			foreach( $postArray as $name => $value ) {
				$setMthod = 'set'.ucfirst($name);
				if (method_exists($this, $setMthod)) {
					$this->$setMthod($value);
				}
			}
		}
	}
	/**
	 * ActionFormのabstruct method
	 * エラーチェック
	 * @return エラーメッセージ（配列）
	 */
	public function validate() {
		// mb_check_encoding処理を行うcallback関数
		$errors = array();

		//    if (mb_check_encoding($this->text, 'ASCII')) {
		//    if ($this->text === mb_convert_encoding($this->text, 'ASCII', 'ASCII')) {
		//    if ($this->IsAscii($this->text)) {
			if (is_callable(ASCII_CHECK_FUNC)) {
				if (call_user_func(ASCII_CHECK_FUNC, $this->text)) {
					$errors[] = '全角チェックＯＫ';
				}
				else {
					$errors[] = '全角チェックＮＧ';
				}
			}
			else {
				$errors[] = 'Call NG';
			}

			return $errors;
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
	}

	$form = new MBForm();

	$resultMsg = null;
	if (isset($_POST['submit'])) {
		$form->setPostArray($_POST);
		$resultMsg = $form->validate($_POST);
	}
	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="ja">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta http-equiv="content-style-type" content="text/css">
<meta http-equiv="content-script-type" content="text/javascript">
<title>全角チェック</title>
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
				<td>テキスト</td>
				<td><input type="text" size="10" name="text"
					value="<?= $form->getFormValue('text') ?>">
				</td>
			</tr>
		</table>
		<br> <input type="submit" name="submit" value="チェック">
	</form>
	<?php
	if (is_array($resultMsg) && count($resultMsg) > 0) {
		?>
	<p>
		結果:[
		<?= $resultMsg[0] ?>
		]<br>
	</p>
	<?php
	} // is_null($resultMsg)
	echo (is_callable(ASCII_CHECK_FUNC) ? 'OK' : 'NG')."<br>\n";
	echo (call_user_func(ASCII_CHECK_FUNC, $form->getText()) ? 'OK' : 'NG')."<br>\n";
	?>
	<?=ASCII_CHECK_FUNC?>
	<br>
	<pre>
</pre>
</body>
</html>
