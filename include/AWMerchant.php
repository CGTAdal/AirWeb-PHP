<?php

/*
 * AWMerchant.php
*
* AW及びマーチャント情報定義ファイル
*/


/*
 * マーチャント情報
*/
// マーチャントID
define('AW_MERCHANT_ID', '');

// AWへ送信するデータの検証用ハッシュキー
define('AW_MERCHANT_HASH_KEY', '');


/*
 * URL
*/
// 決済完了後戻りURL
define('FINISH_PAYMENT_RETURN_URL', 'http://localhost/AirWebPHP/sample/DoPostActionBrowser.php');
// 決済結果通知先URL
define('FINISH_PAYMENT_ACCESS_URL', 'http://localhost/AirWebPHP/sample/DoPostActionAW.php');



// 決済種別を指定しない場合や、決済種別=電子マネー決済の場合で電子マネーを指定しない場合の支払期限(当日からX日後)
define('DEFAULT_PAYLIMIT', '60');

// 決済種別を指定しない場合の取消期限(当日からX日後)
define('DEFAULT_CANCELLIMIT', '60');


/*
 * カード決済固有
*/
// 売り上げフラグ：1：与信・売上、0：与信のみ。指定が無い場合は、0
define('CARD_CAPTURE_FLAG', '1');


/*
 * コンビニ決済固有
*/
// コンビニ決済の支払期限(当日からX日後)
define('CVS_PAYLIMIT', '60');

?>