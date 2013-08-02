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

// クライアントから送信されてきたキーと、AWから送信されてきたキーが一致するかをチェック
$result = $KeyValidate->resultCrossCheck();

header("Content-Type: text/html;charset=EUC-JP");
// チェック結果を表示
if ($result) {
	$log->info("チェックOK");
	include('finish.php');
} else {
	$log->info("チェックNG");
	include('error.php');
}
?>