<?php

// hidden情報から遷移先を決定する
$iFrameFlag = false;    // インラインフレーム遷移フラグ
if(isset($_POST[ 'DisplayType' ]) && $_POST['DisplayType'] == "iframe"){
	$iFrameFlag = true;
}

// 共通インクルードファイル
require_once('common.php');

// セッションを開始
session_start();

$log = new Logger(__FILE__);

// セッションに登録されていなければ、初期ページに飛ばす
if (!isset($_SESSION['commodityName1'])) {
	$log->info("セッションに購入商品が登録されていない→商品購入ページへ");
	if ($iFrameFlag) {
		header("Location: if_purchase.php");
	} else {
		header("Location: purchase.php");
	}
	exit();
}

// エラー発生フラグ
$error = false;

// フォームオブジェクトを生成
$form = new CvsForm();
$form->setSettlementType(AW_SETTLEMENT_TYPE_CVS);

// POSTされたフォームを登録
$form->setRequestArray($_POST);
// 入力チェックを行う
$errors = $form->validate();

// エラーが発生しているか
if (count($errors) > 0) {
	$log->debug("入力チェックエラーあり");
	$error = true;
} else {
	$log->debug("入力チェックエラーなし");
}

// エラーが発生したか
if ($error) {
	$log->info("個人情報入力画面へ");
	// 入力画面を呼び出して終了する
	session_write_close(); // entry_cvs.php内でsession_start()を呼ぶのでここで閉じておく
	if ($iFrameFlag) {
		include_once('./if_entry_cvs.php');
	} else {
		include_once('./entry_cvs.php');
	}
	exit();
}

// コンビニ決済固有項目のセット
// 支払期限
$payLimit = intval(CVS_PAYLIMIT);
$limitdate = getLimitDateStr($payLimit);
$log->info("支払期限：" . $limitdate);
$form->setTimelimitOfPayment($limitdate);

// セッションにパラメータを登録する
$_SESSION['CvsForm'] = $_POST;

// 個人情報を送信する
$log->info("個人情報送信");
$action = new ConfirmActionManager();
if ($action->execute($form)) {
	$log->info("個人情報送信完了");
	// マーチャントキーを格納する
	$action->setMerchantKey();
	$merchant = $action->getMerchantInfo();
} else {
	$log->info("個人情報送信失敗");

	$errors = $action->getMessage();
	$log->info("個人情報入力画面へ");
	// 入力画面を呼び出して終了する
	session_write_close(); // entry.php内でsession_start()を呼ぶのでここで閉じておく
	if ($iFrameFlag) {
		include_once('if_entry_cvs.php');
	} else {
		include_once('entry_cvs.php');
	}
	exit();
}

$log->info("AWへの遷移画面へ");
session_write_close();
if ($iFrameFlag) {
	include_once('../if_jump.php');
} else {
	include_once('../jump.php');
}
?>