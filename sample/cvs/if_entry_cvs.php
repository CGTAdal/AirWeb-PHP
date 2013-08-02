<?php include("../include_session_check.php"); ?>
<?php
// ConfirmActionからの遷移＝$formがセットされている
if (!isset($form)) {
	// CvsFormを生成
	$form = new CvsForm();

	// セッションにパラメータが登録されている
	if (isset($_SESSION['CvsForm'])) {
		$log_entry->debug("他画面からの遷移：Formをセッションから取得");
		$form->setRequestArray($_SESSION['CvsForm']);
	} else {
		$log_entry->debug("新規遷移");
	}
}
?>
<?php include("../include_retrieve_info.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="ja">
<head>
<link rel="stylesheet" href="../iframe.css" type="text/css" />
<title><?php echo $lang['ENTRY.CVS.TITLE'];?></title>
<?php include("../include_head.php"); ?>
</head>
<body>
	<div class="header"></div>
	<div class="contents">
		<h1><?php echo $lang['ENTRY.CVS.HEADER'];?></h1>
		<?php include("../include_error_desc.php"); ?>

		<form method="post" action="CvsConfirmAction.php" name="CvsForm"
			onSubmit="document.getElementById('submitBtn').disabled=true;">
			<input type="hidden" name="DisplayType" value="iframe"> <br /> <br />
			<?php include("../include_cart_table.php"); ?>
			<br /> <br />

			<h2><?php echo $lang['ENTRY.CVS.PAYMENT_INFO'];?></h2>
			<br />
			<table class="settlement">
				<tr>
					<th class="type"><?php echo $lang['ENTRY.CVS.ITEMS'];?></th>
					<th class="pal"><?php echo $lang['ENTRY.CVS.CONTENT'];?></th>
				</tr>
				<tr>
					<td><?php echo $lang['ENTRY.CVS.PAYMENT_METHOD'];?></td>
					<td><?php echo $lang['ENTRY.CVS.CVS_PAYMENT'];?></td>
				</tr>
				<tr>
					<td><?php echo $lang['ENTRY.CVS.SUB_TYPE'];?></td>
					<td><select name="settlementSubType" size="1"
						onchange="kanaEnable()">
							<option value="" selected="selected"><?php echo $lang['ENTRY.CVS.NO_SPECIFIED'];?></option>
							<option value="220"><?php echo $lang['ENTRY.CVS.LAWSON'];?></option>
							<option value="220"><?php echo $lang['ENTRY.CVS.FAMIMA'];?></option>
							<option value="210"><?php echo $lang['ENTRY.CVS.711'];?></option>
							<option value="230"><?php echo $lang['ENTRY.CVS.DAILY'];?></option>
							<option value="220"><?php echo $lang['ENTRY.CVS.MINI'];?></option>
							<option value="220"><?php echo $lang['ENTRY.CVS.SEICO'];?></option>
							<option value="230"><?php echo $lang['ENTRY.CVS.CIRCLE'];?></option>
					</select>
					</td>
				</tr>
			</table>
			<br /> <br />
			<?php include("../include_customer_table.php"); ?>
			<br />
			<?php include("../include_input_hidden.php"); ?>
			<br /> <input type="submit" id="submitBtn" value="<?php echo $lang['ENTRY.CVS.PURCHASE'];?>" />
		</form>
	</div>
	<div class="footer"></div>
</body>
</html>
