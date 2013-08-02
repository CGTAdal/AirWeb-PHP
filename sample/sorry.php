<?php
// 共通インクルードファイル
require_once('common.php');

// セッションを開始
session_start();

$log = new Logger(__FILE__);

// ConfirmActionからの遷移か、セッションにCommodityFormが登録されている
if (isset($form) || isset($_SESSION['CommodityForm'])) {
	// 個人情報登録ページへ
	$url = 'entry.php';
} else {
	// 初期ページへ
	$url = 'buy2.php';
}
$log->info('戻り先：' . $url);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="ja">
<head>
<meta http-equiv="content-type"
	content="text/html; charset=<?= AW_HTML_ENCODE ?>">
<meta name="format-detection" content="telephone=no" />
<meta name="viewport" content="width=device-width" />
<link rel="stylesheet" href="./style_m.css" type="text/css"
	media="only screen and (max-width:480px)" />
<link rel="stylesheet" href="./style.css" type="text/css"
	media="only screen and (min-width:481px)" />
<!--[if IE]>
		<link rel="stylesheet" href="./style.css" type="text/css" media="all"/>	
		<![endif]-->
<title>只今混雑しています</title>
<style type="text/css">
<!--
body {
	background-color: #ddddff;
	margin-left: auto;
	margin-right: auto;
	text-align: center;
}

p.big {
	color: red;
	font-size: 150%;
}
-->
</style>
</head>
<body>
	<div class="contents">
		<p class="big">只今混雑しています</p>
		<p>大変申し訳ありませんが、しばらく経ってから、再度やり直してください。</p>
		<p>
			<a href="<?= $url ?>">戻る</a>
		</p>
	</div>
</body>
</html>
