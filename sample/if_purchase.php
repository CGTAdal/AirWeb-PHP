<?php
// 共通インクルードファイル
require_once('common.php');

$log = new Logger(__FILE__);

// セッションを開始
session_start();

// セッション変数を全て解除する
$_SESSION = array();

// セッションに購入商品情報を登録する
$_SESSION['commodityId1'] = "001";
$_SESSION['commodityId2'] = "002";
$_SESSION['commodityId3'] = "003";
$_SESSION['commodityJanCode1'] = "J01";
$_SESSION['commodityJanCode2'] = "J02";
$_SESSION['commodityJanCode3'] = "J03";
$_SESSION['commodityName1'] = $lang['PURCHASE.NAME1'];
$_SESSION['commodityName2'] = $lang['PURCHASE.NAME2'];
$_SESSION['commodityName3'] = $lang['PURCHASE.NAME3'];
$_SESSION['commodityNum1'] = "1";
$_SESSION['commodityNum2'] = "2";
$_SESSION['commodityNum3'] = "3";
$_SESSION['commodityUnit1'] = "100";
$_SESSION['commodityUnit2'] = "200";
$_SESSION['commodityUnit3'] = "300";
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
<link rel="stylesheet" href="./iframe.css" type="text/css" />
<!--[if IE]>
		<link rel="stylesheet" href="./style.css" type="text/css" media="all"/>	
		<![endif]-->
<title><?php echo $lang['PURCHASE.TITLE'];?></title>
</head>
<body>
	<div class="header"></div>
	<div class="contents">
		<br />
		<table class="cart">
			<tr>
				<th class="name"><?php echo $lang['PURCHASE.PRODUCT_NAME'];?></th>
				<th class="unitp"><?php echo $lang['PURCHASE.UNITPRICE'];?></th>
				<th class="num"><?php echo $lang['PURCHASE.QUANTITY'];?></th>
				<th class="sum"><?php echo $lang['PURCHASE.SUBTOTAL'];?></th>
			</tr>
			<tr>
				<td class="name"><?php echo $lang['PURCHASE.NAME1'];?></td>
				<td class="unitp">100 <?php echo $lang['PURCHASE.YEN'];?></td>
				<td class="num">1 <?php echo $lang['PURCHASE.ITEM'];?></td>
				<td class="sum">100 <?php echo $lang['PURCHASE.YEN'];?></td>
			</tr>
			<tr>
				<td class="name"><?php echo $lang['PURCHASE.NAME2'];?></td>
				<td class="unitp">200 <?php echo $lang['PURCHASE.YEN'];?></td>
				<td class="num">2 <?php echo $lang['PURCHASE.ITEM'];?></td>
				<td class="sum">400 <?php echo $lang['PURCHASE.YEN'];?></td>
			</tr>
			<tr>
				<td class="name"><?php echo $lang['PURCHASE.NAME3'];?></td>
				<td class="unitp">300 <?php echo $lang['PURCHASE.YEN'];?></td>
				<td class="num">3 <?php echo $lang['PURCHASE.ITEM'];?></td>
				<td class="sum">900 <?php echo $lang['PURCHASE.YEN'];?></td>
			</tr>
			<tr>
				<td colspan="4" class="sum"><?php echo $lang['PURCHASE.TOTAL'];?><?php echo $lang['PURCHASE.COLON'];?>1,400 <?php echo $lang['PURCHASE.YEN'];?></td>
			</tr>
		</table>
		<br />
		<table class="noline">
			<tr>
				<td><a href="./default/if_entry.php"><?php echo $lang['PURCHASE.NO_SPECIFIED'];?></a>&nbsp;</td>
				<td><a href="./card/if_entry_card.php"><?php echo $lang['PURCHASE.CARD'];?></a>&nbsp;</td>
				<td><a href="./cvs/if_entry_cvs.php"><?php echo $lang['PURCHASE.CVS'];?></a>&nbsp;</td>
			</tr>
		</table>
	</div>
	<div class="footer"></div>
</body>
</html>
