<?php
// 共通インクルードファイル
require_once ('common.php');

// セッションを開始
session_start();

$log = new Logger(__FILE__);

if (isset($merchant) && ($merchant instanceof MerchantInfo)) {
    $log->debug("マーチャント情報確認");
} else {
    $log->info("マーチャント情報未登録なので、個人情報入力画面へ");
    session_write_close(); // entry.php内でsession_start()を呼ぶのでここで閉じておく
    header('Location: if_entry.php');
    exit();
}
ob_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="ja">
<head>
<link rel="stylesheet" href="../iframe.css" type="text/css" />
<?php include("../include_head.php"); ?>
<title><?php echo $lang['JUMP.TITLE'];?></title>
<script type="text/javascript">
	<!--
            function onSubmit () {
                document.getElementById('merchant').style.display = 'none';
		document.getElementById('aw').style.display = 'block';
            }
	// -->
	</script>
</head>
<body>
	<div class="header"></div>
	<div class="if_contents">

		<div id="aw" style="display: none;">
			<iframe src="" name="aweb_frame" class="frame"><?php echo $lang['JUMP.IF_MESSAGE'];?></iframe>
		</div>

		<div id="merchant">
			<h1 align="center"><?php echo $lang['JUMP.HEADER'];?></h1>
			<div align="center">
				<table border="1" cellpadding="10" bgcolor="#FFFFCC">
					<tr>
						<td><?php echo $lang['JUMP.MESSAGE1'];?><br> <?php echo $lang['JUMP.MESSAGE2'];?><br>
						</td>
					</tr>
				</table>
				<br /> <br />
				<form action="<?= PAYMENT_URL ?>" method="post"
					onsubmit="document.getElementById('submitBtn').disabled=true;onSubmit();"
					target="aweb_frame">
					<input type="hidden" name="MERCHANT_ID"
						value="<?= $merchant->getMerchantID() ?>" /> <input type="hidden"
						name="ORDER_ID" value="<?= $merchant->getOrderID() ?>" /> <input
						type="hidden" name="BROWSER_ENCRYPTION_KEY"
						value="<?= $merchant->getBrowserEncKey() ?>" /> <input
						id="submitBtn" type="submit"
						value="<?php echo $lang['JUMP.TO_SCREEN'];?>" />
				</form>
			</div>
		</div>

	</div>
	<div class="footer"></div>
</body>
</html>
<?php
ob_end_flush();
?>