<?php   
require_once('common.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="ja">
<head>
<title>テストページ</title>
<meta http-equiv="Content-Type" content="text/html; charset=EUC_JP">
</head>
<body>
	<div style="margin: 1em auto; padding: 0; text-align: center;">
		<br /> <br /> <a href="./sample/purchase.php"> <?php echo $lang['INDEX.PURCHASE'];?>
		</a><br /> <br /> <br /> <a href="./sample/if_purchase.php"><?php echo $lang['INDEX.PURCHASE_IFRAME'];?></a><br />
		<br /> <br /> <br> <br> <a
			href="./test/AirWebReponseEmu.php"><?php echo $lang['INDEX.AIRWEB_RESPONSE'];?></a><br /> <br />
		<br /> <a href="./test/CustomerReturn.php"><?php echo $lang['INDEX.BROWSER_RETURN'];?></a><br />
		<br />
		<a href="./index.php?lang=ja"><?php echo $lang['INDEX.JAPANESE'];?></a>&nbsp;
		<a href="./index.php?lang=en"><?php echo $lang['INDEX.ENGLISH'];?></a>
	</div>
</body>
</html>