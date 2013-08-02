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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width" />
<link rel="stylesheet" href="../sample/style_m.css" type="text/css"
	media="only screen and (max-width:480px)" />
<link rel="stylesheet" href="../sample/style.css" type="text/css"
	media="only screen and (min-width:481px)" />
<title><?php echo $lang['AWEMU.TITLE'];?></title>
</head>
<body>
	<form action="../sample/DoPostActionAW.php" method="POST">
		<table class="testTable">
			<tr>
				<td><?php echo $lang['AWEMU.ORDER_ID'];?></td>
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
				<td><?php echo $lang['AWEMU.STATUS'];?></td>
				<td><select name="mStatus" size="1">
						<option value="success"><?php echo $lang['AWEMU.SUCCESS'];?></option>
						<option value="failure"><?php echo $lang['AWEMU.FAILURE'];?></option>
						<option value="pending"><?php echo $lang['AWEMU.PENDING'];?></option>
				</select>
				</td>
			</tr>
			<tr>
				<td><?php echo $lang['AWEMU.ERROR_MSG'];?></td>
				<td><input type="text" size="20" name="mErrMsg" value=""></td>
			</tr>
			<tr>
				<td><?php echo $lang['AWEMU.RESULT_CODE'];?></td>
				<td><input type="text" size="20" name="vResultCode" value=""></td>
			</tr>
			<tr>
				<td><?php echo $lang['AWEMU.KANJI'];?></td>
				<td><input type="text" size="40" name="userName" value=""></td>
			</tr>
			<tr>
				<td><?php echo $lang['AWEMU.KANA'];?></td>
				<td><input type="text" size="40" name="userNameKana" value=""></td>
			</tr>
			<tr>
				<td><?php echo $lang['AWEMU.EMAIL'];?></td>
				<td><input type="text" size="30" name="mailAddress" value=""></td>
			</tr>
			<tr>
				<td><?php echo $lang['AWEMU.ADDRESS'];?></td>
				<td><input type="text" size="50" name="address" value=""></td>
			</tr>
			<tr>
				<td><?php echo $lang['AWEMU.GENDER'];?></td>
				<td><input type="radio" name="sex" value="1"><?php echo $lang['AWEMU.MALE'];?> <input type="radio"
					name="sex" value="2"><?php echo $lang['AWEMU.FEMALE'];?></td>
			</tr>
			<tr>
				<td><?php echo $lang['AWEMU.PHONE'];?></td>
				<td><input type="text" size="20" name="telephoneno" value=""></td>
			</tr>
			<tr>
				<td><?php echo $lang['AWEMU.ZIP_CODE'];?></td>
				<td><input type="text" size="10" name="zipcode" value=""></td>
			</tr>
			<tr>
				<td><?php echo $lang['AWEMU.BIRTHDAY'];?></td>
				<td><input type="text" size="20" name="birthday" value=""></td>
			</tr>
		</table>
		<p>
			<input type="submit" name="submit" value="<?php echo $lang['AWEMU.SEND'];?>">
		</p>
	</form>
</body>
</html>
