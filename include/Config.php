<?php

/*
 * Config.php
 *
 * AW及びマーチャント情報定義ファイル
 */

/**
 * マーチャント情報
 */
// マーチャントID
define('AW_MERCHANT_ID', '<<Merchant ID>>');

// AWへ送信するデータの検証用ハッシュキー
define('AW_MERCHANT_HASH_KEY', '<<Merchang Hash Key>>');

// ダミー取引フラグ ダミー取引フラグ 0 = 本番; 1 = テスト
define('DUMMY_PAYMENT_FLAG', '1');

/**
 * URLs
 */
// 決済完了後戻りURL
define('FINISH_PAYMENT_RETURN_URL', 'http://localhost/AirWebSample/sample/DoPostActionBrowser.php');

// 決済結果通知先URL
define('FINISH_PAYMENT_ACCESS_URL', 'http://localhost/AirWebSample/sample/DoPostActionAW.php');

// HTTP POST送信先URL
define('AW_HTTP_POST_URI', 'https://air.veritrans.co.jp/web/commodityRegist.action');

// AW決済サイトURL
define('PAYMENT_URL', 'https://air.veritrans.co.jp/web/paymentStart.action');

// 売り上げフラグ：1：与信・売上、0：与信のみ。指定が無い場合は、0
define('CARD_CAPTURE_FLAG', '1');

// コンビニ決済の支払期限(当日からX日後)
define('CVS_PAYLIMIT', '60');

/** To run this sample not need to change below settings */
/*
 * 決済方式
 */
// 決済方式：決済情報入力時に選択
define('AW_SETTLEMENT_TYPE_FREE', '00');

// 決済方式：カード決済
define('AW_SETTLEMENT_TYPE_CARD', '01');

// 決済方式：コンビニ決済
define('AW_SETTLEMENT_TYPE_CVS', '02');

// デフォルト決済方式。00を指定
define('AW_SETTLEMENT_TYPE', AW_SETTLEMENT_TYPE_FREE);

// 商品情報の商品ID未入力時に設定するダミー値
define('DUMMY_COMMODITY_ID', 'DUMMY_ID');

// 商品情報のJAN_CODE未入力時に設定するダミー値
define('DUMMY_COMMODITY_JANCODE', 'DUMMY_JANCODE');

/**
 * 文字コード関係
 */
// PHPスクリプトの文字コード,設置環境に合わせて変更する
define('AW_BASE_ENCODE', 'UTF-8');

// HTMLのcontent-typeに設定する文字コード
define('AW_HTML_ENCODE', 'UTF-8');

// AWサーバへ送信する時の文字コード,通常は変更しない
define('AW_SERVER_ENCODE', 'UTF-8');

/**
 * このファイルのあるパス
 * 以下、ファイルパスの相対設定に使用できる
 */
define('AW_INCLUDE_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR);

/**
 * 決済認証データファイル
 */
define('AW_DATASTORE_FILE', AW_INCLUDE_DIR . '../DataStore/DataStore.dat');

/**
 * メッセージリソースファイル
 */
define('AW_MESSAGE_RESOURCE_FILE', AW_INCLUDE_DIR . 'MessageResources.ini');

// ログ関係 ==================
/**
 * ユーザDEBUGレベル
 * PHP5では未定義のため、追加
 */
if (!defined('E_USER_DEBUG')) {
    define('E_USER_DEBUG', 8192); // 0x2000
}
/**
 * E_USER_DEBUGを含めた全レベル
 * PHP5では未定義のため、追加
 */
if (!defined('E_USER_DEBUGALL')) {
    define('E_USER_DEBUGALL', 16383); // 0x3fff
}
// 出力レベルの指定
// 複数指定の場合は、E_USER_DEBUGALL
// または各レベルのor結合（ex. E_USER_ERROR | E_USER_WARNING）
// E_USER_DEBUGALL= all
// E_USER_ERROR = error
// E_USER_WARNING = warn
// E_USER_NOTICE = info
// E_USER_DEBUG = debug
// 全てのログ
// define('LOGGER_LEVEL', E_USER_DEBUGALL);
// DEBUGを除く（info以上）
define('LOGGER_LEVEL', E_USER_DEBUGALL & ~E_USER_DEBUG);
// errorまたはwarn
// define('LOGGER_LEVEL', E_USER_ERROR | E_USER_WARNING);
?>