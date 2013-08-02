<?php

// 共通インクルードファイル
require_once('common.php');

$log = new Logger(__FILE__);

$log->info("処理開始");

// パラメータを解析して、チェックを行う
$KeyValidate = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$log->debug("POST Request");
	$KeyValidate = new AWKeyValidate($_POST);
} else {
	$log->debug("GET Request");
	$KeyValidate = new AWKeyValidate($_GET);
}

// AWからのRequestの内容確認
$result = $KeyValidate->resultCheck();

// チェック結果を表示
header("text/html; charset=" . AW_HTML_ENCODE);
if ($result) {
	$KeyValidate->updateKeyBox();
	$log->info("チェックOK");
	echo "OK\n";
} else {
	$log->info("チェックNG");
	echo "ERR\n";
}
?>