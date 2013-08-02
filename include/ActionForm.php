<?php

/**
 * abstract class ActionForm
 * 入力フォームに付加機能を追加するクラス
 *
 * ・メッセージリソースの呼び出し
 * ・HTMLのFORMへ値を出力する際の変換処理
 */
abstract class ActionForm {

	private $log = null;
	/**
	 * メッセージリソース
	 * @var array
	 */
	private $prop = null;

	/**
	 * コンストラクタ
	 * abstructクラスなので、継承クラスからしか呼び出せない
	 */
	protected function __construct() {
		$this->log = new Logger(__CLASS__);
	}

	/**
	 * 派生クラスのプロパティを取得する
	 */
	abstract protected function setValue($name, $value);
	/**
	 * // example code
	 * protected function setValue($name, $value) {
	 *   $setMthod = 'set'.ucfirst($name);
	 *   if (method_exists($this, $setMthod)) {
	 *     $this->$setMthod($value);
	 *   }
	 * }
	 */

	/**
	 * 派生クラスのプロパティを取得する
	 */
	abstract protected function getValue($name);
	/**
	 * // example code
	 * protected function getValue($name) {
	 *   $getMthod = 'get'.ucfirst($name);
	 *   if (method_exists($this, $getMthod)) {
	 *     return $this->$getMthod();
	 *   }
	 *   else {
	 *     return null;
	 *   }
	 * }
	 */

	/**
	 * エラーチェック
	 * @return エラーメッセージ（配列）
	 */
	abstract public function validate();

	/**
	 * リクエストされたデータを登録する
	 * magic_quotes処理を行うので、GET/POSTされたフォームから
	 * パラメータを登録する場合に使用する
	 */
	public function setRequestArray($reqArray) {

		if (is_array($reqArray)) {
			foreach ($reqArray as $name => $value) {
				if (!is_null($value)) {
					// magic_quotes処理を行う
					$value = call_user_func(MPG_FUNC, $value);
					// 派生クラスへ値を登録する
					$val = $this->setValue($name, $value);
				}
			}
		}
	}

	/**
	 * 値が空（Null又は空白）であるかを検査する
	 * PHPのempty()だと'0'がTrueとなるため
	 */
	protected function IsEmpty($value) {
		return (is_null($value) || $value == '');
	}

	/**
	 * 値が半角（ASCII文字）のみであるかを検査する
	 */
	protected function IsAscii($value) {
		return call_user_func(ASCII_CHECK_FUNC, $value);
	}

	/**
	 * 値が半角数字のみであるかを検査する
	 */
	protected function IsNumeric($value) {
		return preg_match("/^[0-9]+$/", $value);
	}

	/**
	 * 値が全角カナのみであるかを検査する
	 */
	protected function IsMultiByteKana($value) {
		return preg_match("/^[ァアィイゥウェエォオカガキギクグケゲコゴサザシジスズセゼソゾタダチヂッツヅテデトドナニヌネノハバパヒビピフブプヘベペホボポマミムメモャヤュユョヨラリルレロヮワヰヱヲンヴヵヶー－　]+$/", $value);
	}

	/**
	 * アクションメッセージを取得する
	 */
	protected function actionMessage($msgid) {
		// メッセージリソースが未登録であれば呼び出す
		if (is_null($this->prop)) {
			$this->prop = parse_ini_file(AW_MESSAGE_RESOURCE_FILE);
		}
		// リソースIDからメッセージを取得
		return (isset($this->prop[$msgid]) ? $this->prop[$msgid] : '');
	}

	/**
	 * パラメータのテキストを取得する
	 * 値がNullの場合、代替文字をセットする
	 */
	public function getTextValue($name, $def='') {

		// 派生クラスから値を取得する
		$val = $this->getValue($name);
		// Nullの場合デフォルト値をセット
		if (is_null($val)) {
			$val = $def;
		}
		return $val;
	}

	/**
	 * フォームのvalue値に出力する
	 * 値がNullの場合、代替文字をセットする
	 */
	public function getFormValue($name, $def='') {

		// 派生クラスから値を取得する
		$val = $this->getValue($name);
		// Nullの場合デフォルト値をセット
		if (is_null($val)) {
			$val = $def;
		}
		return htmlspecialchars($val);
	}

	/**
	 * フォームのselectの選択（selected）を検査する
	 */
	public function getFormSelected($name, $match='') {
		// 派生クラスから値を取得する
		$val = $this->getValue($name);

		// 一致していれば' selected'を返す
		if (is_null($val)) {
			return '';
		} elseif ($val == $match) {
			return ' selected';
		} else {
			return '';
		}
	}

	/**
	 * フォームのradio/checkboxの選択（checked）を検査する
	 */
	public function getFormChecked($name, $match='') {
		// 派生クラスから値を取得する
		$val = $this->getValue($name);

		// 一致していれば' checked'を返す
		if (is_null($val)) {
			return '';
		} elseif ($val == $match) {
			return ' checked';
		} else {
			return '';
		}
	}

}

?>