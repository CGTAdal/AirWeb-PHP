<?php
// 共通インクルードファイル
require_once('common.php');
$keyHelper = new KeyBoxHelper();
$keyArray = $keyHelper->getKeyArray();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="ja">
<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
<meta name="viewport" content="width=device-width" />
<link rel="stylesheet" href="../sample/style_m.css" type="text/css"
	media="only screen and (max-width:480px)" />
<link rel="stylesheet" href="../sample/style.css" type="text/css"
	media="only screen and (min-width:481px)" />
<title><?php echo $lang['BRSRE.TITLE'];?></title>
</head>
<body>
	<form action="../sample/DoPostActionBrowser.php" method="POST">
		<table class="testTable">
			<tr>
				<td><?php echo $lang['BRSRE.ORDER_ID'];?></td>
				<td><select name="orderId" size="1">
						<?php
						foreach ($keyArray as $i => $value) {
							?>
						<option value="<?= $keyArray[$i]->getOrderId() ?>">
							<?= $keyArray[$i]->getOrderId() ?>
						</option>
						<?php
						}
						?>
				</select>
				</td>
			</tr>
			<tr>
				<td><?php echo $lang['BRSRE.STATUS'];?></td>
				<td><select name="mStatus" size="1">
						<option value="success"><?php echo $lang['BRSRE.SUCCESS'];?></option>
						<option value="failure"><?php echo $lang['BRSRE.FAILURE'];?></option>
						<option value="pending"><?php echo $lang['BRSRE.PENDING'];?></option>
				</select>
				</td>
			</tr>
			<tr>
				<td><?php echo $lang['BRSRE.RESULT_CODE'];?></td>
				<td><input type="text" size="20" name="vResultCode" value=""></td>
			</tr>
			<tr>
				<td><?php echo $lang['BRSRE.SESSION_ID'];?></td>
				<td><input type="text" size="50" name="sessionId" value=""></td>
			</tr>
		</table>
		<p>
			<input type="submit" name="submit" value="<?php echo $lang['BRSRE.SEND'];?>">
		</p>
	</form>
</body>
</html>
