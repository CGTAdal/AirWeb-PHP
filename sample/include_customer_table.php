<h2><?php echo $lang['ENTRY.CUSTOMER_INFO'];?></h2>
<br />
<table class="customer">
	<tr>
		<th class="name"><?php echo $lang['ENTRY.ITEMS'];?></th>
		<th class="value"><?php echo $lang['ENTRY.CONTENT'];?></th>
	
	
	<tr>
	
	
	<tr>
		<td class="name"><?php echo $lang['ENTRY.FULLNAME_KANJI'];?></td>
		<td class="value"><?php echo $lang['ENTRY.LASTNAME'];?><input type="text" size="20" name="name1"
			value="<?= $form->getFormValue('name1') ?>" /><br /> <?php echo $lang['ENTRY.FIRSTNAME'];?><input
			type="text" size="20" name="name2"
			value="<?= $form->getFormValue('name2') ?>" />
		</td>
	</tr>
	<tr>
		<td class="name"><?php echo $lang['ENTRY.FULLNAME_KANA'];?></td>
		<td class="value"><?php echo $lang['ENTRY.LASTNAME'];?><input type="text" size="20" name="kana1"
			value="<?= $form->getFormValue('kana1') ?>" /><br /> <?php echo $lang['ENTRY.FIRSTNAME'];?><input
			type="text" size="20" name="kana2"
			value="<?= $form->getFormValue('kana2') ?>" />
		</td>
	</tr>
	<tr>
		<td class="name"><?php echo $lang['ENTRY.PHONE'];?></td>
		<td class="value"><input type="text" size="5" name="telephoneNo1"
			value="<?= $form->getFormValue('telephoneNo1') ?>" />- <input
			type="text" size="5" name="telephoneNo2"
			value="<?= $form->getFormValue('telephoneNo2') ?>" />- <input
			type="text" size="5" name="telephoneNo3"
			value="<?= $form->getFormValue('telephoneNo3') ?>" />
		</td>
	</tr>
	<tr>
		<td class="name"><?php echo $lang['ENTRY.ZIPCODE'];?></td>
		<td class="value"><input type="text" size="3" name="zipCode1"
			maxlength="3" value="<?= $form->getFormValue('zipCode1') ?>" />- <input
			type="text" size="4" name="zipCode2" maxlength="4"
			value="<?= $form->getFormValue('zipCode2') ?>" />
		</td>
	</tr>
	<tr>
		<td class="name"><?php echo $lang['ENTRY.ADDRESS1'];?></td>
		<td class="value"><input type="text" size="30" name="address1"
			value="<?= $form->getFormValue('address1') ?>" />
		</td>
	</tr>
	<tr>
		<td class="name"><?php echo $lang['ENTRY.ADDRESS2'];?></td>
		<td class="value"><input type="text" size="30" name="address2"
			value="<?= $form->getFormValue('address2') ?>" />
		</td>
	</tr>
	<tr>
		<td class="name"><?php echo $lang['ENTRY.ADDRESS3'];?></td>
		<td class="value"><input type="text" size="30" name="address3"
			value="<?= $form->getFormValue('address3') ?>" />
		</td>
	</tr>
	<tr>
		<td class="name"><?php echo $lang['ENTRY.EMAIL'];?></td>
		<td class="value"><input type="text" size="30" name="mailAddress"
			value="<?= $form->getFormValue('mailAddress') ?>" />
		</td>
	</tr>
	<tr>
		<td class="name"><?php echo $lang['ENTRY.BIRTHDAY'];?></td>
		<td class="value"><input type="text" size="4" name="birthdayYYYY"
			maxlength="4" value="<?= $form->getFormValue('birthdayYYYY') ?>" /><?php echo $lang['ENTRY.YEAR'];?>
			<input type="text" size="2" name="birthdayMM" maxlength="2"
			value="<?= $form->getFormValue('birthdayMM') ?>" /><?php echo $lang['ENTRY.MONTH'];?> <input
			type="text" size="2" name="birthdayDD" maxlength="2"
			value="<?= $form->getFormValue('birthdayDD') ?>" /><?php echo $lang['ENTRY.DAY'];?></td>
	</tr>
	<tr>
		<td class="name"><?php echo $lang['ENTRY.GENDER'];?></td>
		<td class="value"><input type="radio" name="sex" value="1"
		<?= $form->getFormChecked('sex', "1") ?>><?php echo $lang['ENTRY.MALE'];?> <input type="radio"
			name="sex" value="2" <?= $form->getFormChecked('sex', "2") ?>><?php echo $lang['ENTRY.FEMALE'];?> <input
			type="hidden" name="sex" value="" />
		</td>
	</tr>
</table>
