<?php

/*
 * functions.php
*
* 共通ユーティリティ関数
*/

/*
 * PHPのmagic_quotes_gpc（送信データのエスケープを行う）の設定を
* チェックして、アンエスケープ処理を行う
*/

/**
 * magic_quotes_gpcが有効時に、アンエスケープ処理を行う関数
 */
function mqg_func($value) {
	return stripslashes($value);
}

/**
 * magic_quotes_gpcが無効時に、アンエスケープ処理を行わない関数
 */
function non_mqg_func($value) {
	return $value;
}

/**
 * magic_quotes_gpcの設定により、関数のハンドルを設定する
 * 使う場合は以下の書式で呼び出す
 * $newvalue = call_user_func(MPG_FUNC, $value)
 */
define('MPG_FUNC', ((get_magic_quotes_gpc()) ? 'mqg_func' : 'non_mqg_func'));

/*
 * mb_check_encodingが有効ならば、mb_check_encodingで判定する
* PHP5のバージョンによりmb_check_encoding()が無い場合があるので
* その対策
*/

/**
 * mb_check_encoding()を使用して、文字列に非ASCII文字が
 * 含まれているかをチェックする
 */
function ascii_check_encoding($value) {
	return mb_check_encoding($value, "ASCII");
}

/**
 * mb_convert_encoding()を使用して、文字列に非ASCII文字が
 * 含まれているかをチェックする
 */
function ascii_check_encoding_old($value) {
	return ($value === mb_convert_encoding($value, "ASCII", "ASCII"));
}

/**
 * mb_check_encodingの有無により、関数のハンドルを設定する
 * 使う場合は以下の書式で呼び出す
 * $newvalue = call_user_func(ASCII_CHECK_FUNC, $value)
 */
define('ASCII_CHECK_FUNC', ((function_exists('mb_check_encoding')) ? 'ascii_check_encoding' : 'ascii_check_encoding_old'));

/**
 * スクリプトの終了時に呼び出されるコールバック関数
 * エラー発生時の処理を行う
 */
function OnHalt() {
	// 処理エラーが発生しているか
	if (connection_status() > 0) {
		// ログが登録済みであれば再利用する
		if (isset($GLOBALS['log'])) {
			$log = $GLOBALS['log']->getFunctionLog(__FUNCTION__);
		} else {
			$log = new Logger(__FUNCTION__);
		}
		// ログを出力してエラー画面に遷移する
		$log->error('program abort Code:' . strval(connection_status()));
		header('Location: sorry.php');
	}
}

/**
 * システム時間からx日後の日付を取得する(Date)
 */
function getLimitDate($days) {
	$limitdate = mktime(0, 0, 0, date("m"), date("d") + $days, date("Y"));
	return $limitdate;
}

/**
 * システム時間からx日後の日付を取得する(YYYYMMDD型のString)
 */
function getLimitDateStr($days) {
	return date('Ymd', getLimitDate($days));
}

// スクリプトの終了時にOnHalt()が呼び出される
register_shutdown_function('OnHalt');
?>