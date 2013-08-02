<h2><?php echo $lang['ENTRY.PRODUCT_INFO'];?></h2>
<br />
<table class="cart">
	<tr>
		<th class="name"><?php echo $lang['ENTRY.PRODUCT_NAME'];?></th>
		<th class="unitp"><?php echo $lang['ENTRY.UNITPRICE'];?></th>
		<th class="num"><?php echo $lang['ENTRY.QUANTITY'];?></th>
		<th class="sum"><?php echo $lang['ENTRY.SUBTOTAL'];?></th>
	</tr>
	<tr>
		<td class="name"><?= $name1 ?></td>
		<td class="unitp"><?= $unit1 ?> <?php echo $lang['ENTRY.YEN'];?></td>
		<td class="num"><?= $num1 ?> <?php echo $lang['ENTRY.ITEM'];?></td>
		<td class="sum"><?= $amount1 ?> <?php echo $lang['ENTRY.YEN'];?></td>
	</tr>
	<tr>
		<td class="name"><?= $name2 ?></td>
		<td class="unitp"><?= $unit2 ?> <?php echo $lang['ENTRY.YEN'];?></td>
		<td class="num"><?= $num2 ?> <?php echo $lang['ENTRY.ITEM'];?></td>
		<td class="sum"><?= $amount2 ?> <?php echo $lang['ENTRY.YEN'];?></td>
	</tr>
	<tr>
		<td class="name"><?= $name3 ?></td>
		<td class="unitp"><?= $unit3 ?> <?php echo $lang['ENTRY.YEN'];?></td>
		<td class="num"><?= $num3 ?> <?php echo $lang['ENTRY.ITEM'];?></td>
		<td class="sum"><?= $amount3 ?> <?php echo $lang['ENTRY.YEN'];?></td>
	</tr>
	<tr>
			<td colspan="4" class="sum"><?php echo $lang['PURCHASE.SHIPPING_AMOUNT'];?><?php echo $lang['PURCHASE.COLON'];?> <?= $shippingAmount ?> <?php echo $lang['PURCHASE.YEN'];?></td>
		</tr>
	<tr>
		<td colspan="4" class="sum"><?php echo $lang['ENTRY.TOTAL'];?><?php echo $lang['ENTRY.COLON'];?><?= number_format($purchaseamount) ?> <?php echo $lang['PURCHASE.YEN'];?>
		</td>
	</tr>
</table>
