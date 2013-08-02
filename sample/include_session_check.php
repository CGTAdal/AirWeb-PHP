<?php

// 共通インクルードファイル
require_once('common.php');

$log_entry = new Logger(__FILE__);

// セッションを開始
session_start();

// セッションに登録されていなければ、初期ページに飛ばす
if (!isset($_SESSION['commodityName1'])) {
	$log_entry->info("セッションに購入商品が登録されていない→商品購入ページへ");
	header("Location: purchase.php");
	exit();
}
?>