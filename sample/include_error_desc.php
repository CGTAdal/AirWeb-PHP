<?php
// 入力チェックエラー
if ($isError) {
    ?>
<h1><?php echo $lang['ENTRY.ERROR.HEADER'];?></h1>
<div class="errorbox">
	<ul class="errorbox">
		<?php
    array_walk($errors, create_function('$val, $key', 'echo "    <li>$val</li>\n";'));
    ?>
	</ul>
</div>
<?php
} // if ($isError)
?>