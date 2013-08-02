<?php
// 共通インクルードファイル
require_once('common.php');

// セッションを開始
session_start();

$log = new Logger(__FILE__);

if (isset($merchant) && ($merchant instanceof MerchantInfo)) {
	$log->debug("マーチャント情報確認");
} else {
	$log->info("マーチャント情報未登録なので、個人情報入力画面へ");
	session_write_close(); // entry.php内でsession_start()を呼ぶのでここで閉じておく
	header('Location: entry.php');
	exit();
}
ob_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="ja">
<head>
<?php include("../include_head.php"); ?>
<title><?php echo $lang['JUMP.TITLE'];?></title>
</head>
<body>
	<div class="contents">
		<h1 align="center"><?php echo $lang['JUMP.HEADER'];?></h1>
		<form action="<?= PAYMENT_URL ?>" method="post"
			onSubmit="document.getElementById('submitBtn').disabled=true;">
			<input type="hidden" name="MERCHANT_ID"
				value="<?= $merchant->getMerchantID() ?>" /> <input type="hidden"
				name="ORDER_ID" value="<?= $merchant->getOrderID() ?>" /> <input
				type="hidden" name="BROWSER_ENCRYPTION_KEY"
				value="<?= $merchant->getSettlementKey1A() ?>" />
			<div align="center">
				<table border="1" cellpadding="10" bgcolor="#FFFFCC">
					<tr>
						<td align="left"><?php echo $lang['JUMP.MESSAGE1'];?><br>
							<?php echo $lang['JUMP.MESSAGE2'];?><br>
						</td>
					</tr>
				</table>
				<br /> <br /> <input id="submitBtn" type="submit" value="<?php echo $lang['JUMP.TO_SCREEN'];?>" />
			</div>
		</form>
	</div>
</body>
</html>
<?php
ob_end_flush();
?>