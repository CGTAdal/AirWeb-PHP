<?php

// 入力チェックエラー
$isError = false;
if (isset($errors) && is_array($errors) && count($errors) > 0) {
    $isError = true;
}

// マーチャント情報を取得
if (!isset($merchant)) {
    $merchant = new MerchantInfo();
}

// 商品情報をセット
$id1 = $_SESSION['commodityId1'];
$janCode1 = $_SESSION['commodityJanCode1'];
$name1 = $_SESSION['commodityName1'];
$num1 = $_SESSION['commodityNum1'];
$unit1 = $_SESSION['commodityUnit1'];
$id2 = $_SESSION['commodityId2'];
$janCode2 = $_SESSION['commodityJanCode2'];
$name2 = $_SESSION['commodityName2'];
$num2 = $_SESSION['commodityNum2'];
$unit2 = $_SESSION['commodityUnit2'];
$id3 = $_SESSION['commodityId3'];
$janCode3 = $_SESSION['commodityJanCode3'];
$name3 = $_SESSION['commodityName3'];
$num3 = $_SESSION['commodityNum3'];
$unit3 = $_SESSION['commodityUnit3'];
$shippingAmount = $_SESSION['shippingAmount'];

// 金額を計算
$amount1 = intval($num1) * intval($unit1);
$amount2 = intval($num2) * intval($unit2);
$amount3 = intval($num3) * intval($unit3);
$amount = $amount1 + $amount2 + $amount3 + $shippingAmount;
$purchaseamount = strval($amount);
?>