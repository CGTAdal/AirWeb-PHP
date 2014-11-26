<?php

/*
 * 共通インクルードファイル
 */
// 共通関数定義ファイル
require_once ('functions.php');
// AW及びマーチャント情報定義ファイル
require_once ('Config.php');

// クラスが使用される時に、対応ファイルの自動インクルードを行う
function __autoload($class_name){
    include_once $class_name . '.php';
    // error_log("Auto Load ".$class_name);
}

if (isSet($_GET['lang'])) {
    $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;
    setcookie('lang', $lang, time() + (3600 * 24 * 30));
} else if (isSet($_SESSION['lang'])) {
    $lang = $_SESSION['lang'];
} else if (isSet($_COOKIE['lang'])) {
    $lang = $_COOKIE['lang'];
} else {
    $lang = 'en';
}

switch($lang){
    case 'en':
        $lang_file = 'lang.en.php';
        break;
    
    default:
        $lang_file = 'lang.ja.php';
}
include_once 'languages/' . $lang_file;

?>