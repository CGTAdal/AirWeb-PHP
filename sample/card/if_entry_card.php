<?php include("../include_session_check.php"); ?>
<?php
// ConfirmActionからの遷移＝$formがセットされている
if (!isset($form)) {
    // CardFormを生成
    $form = new CardForm();
    
    // セッションにパラメータが登録されている
    if (isset($_SESSION['CardForm'])) {
        $log_entry->debug("他画面からの遷移：Formをセッションから取得");
        $form->setRequestArray($_SESSION['CardForm']);
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
<title><?php echo $lang['ENTRY.CARD.TITLE'];?></title>
<?php include("../include_head.php"); ?>
</head>
<body>
	<div class="header"></div>
	<div class="contents">
		<h1><?php echo $lang['ENTRY.CARD.HEADER'];?></h1>
		<?php include("../include_error_desc.php"); ?>

		<form method="post" action="CardConfirmAction.php" name="CardForm"
			onSubmit="document.getElementById('submitBtn').disabled=true;">
			<input type="hidden" name="DisplayType" value="iframe"> <br /> <br />
			<?php include("../include_cart_table.php"); ?>
			<br /> <br />

			<h2><?php echo $lang['ENTRY.CARD.PAYMENT_INFO'];?></h2>
			<br />
			<table class="settlement">
				<tr>
					<th class="type"><?php echo $lang['ENTRY.CARD.ITEMS'];?></th>
					<th class="pal"><?php echo $lang['ENTRY.CARD.CONTENT'];?></th>
				</tr>
				<tr>
					<td class="type"><?php echo $lang['ENTRY.CARD.PAYMENT_METHOD'];?></td>
					<td class="pal"><?php echo $lang['ENTRY.CARD.CARD_PAYMENT'];?></td>
				</tr>
			</table>
			<br /> <br />
			<?php include("../include_customer_table.php"); ?>
			<br />
			<?php include("../include_input_hidden.php"); ?>
			<br /> <input type="submit" id="submitBtn"
				value="<?php echo $lang['ENTRY.CARD.PURCHASE'];?>" />
		</form>
	</div>
	<div class="footer"></div>
</body>
</html>
