<?php

// 共通インクルードファイル
require_once('common.php');

/**
 * class ResultCheckForm
 *
 */
class ResultCheckForm extends ActionForm {

	/**
	 * 取引ID
	 * @var String
	 */
	private $orderId = null;
	/**
	 * 決済結果のステータス
	 * @var String
	 */
	private $mStatus = null;
	/**
	 * エラーメッセージ
	 * @var String
	 */
	private $mErrMsg = null;
	/**
	 * 結果コード
	 * @var String
	 */
	private $vResultCode = null;
	/**
	 * セッションID
	 */
	private $sessionId = null;
	/**
	 * 漢字氏名
	 */
	private $userName = null;
	/**
	 * カナ氏名
	 */
	private $userNameKana = null;
	/**
	 * メールアドレス
	 */
	private $mailAddress = null;
	/**
	 * 住所
	 */
	private $address = null;
	/**
	 * 性別
	 */
	private $sex = null;
	/**
	 * 電話番号
	 */
	private $telephoneno = null;
	/**
	 * 郵便番号
	 */
	private $zipcode = null;
	/**
	 * 誕生日
	 */
	private $birthday = null;
	/**
	 * validate()で必須チェック対象とするパラメータリスト
	 */
	private $validateParam = array('mStatus');
	/**
	 * ログクラス
	 */
	private $log = null;

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		parent::__construct();
		$this->log = new Logger(__CLASS__);
	}

	/**
	 * 取引IDの設定
	 * @param orderId 取引ID
	 */
	public function setOrderId($orderId) {
		$this->orderId = urldecode(mb_convert_encoding($orderId, AW_BASE_ENCODE, AW_SERVER_ENCODE));
		if (strlen($this->orderId) == 0) {
			$this->orderId = $orderId;
		}
	}

	/**
	 * 取引IDの取得
	 * @return String 取引ID
	 */
	public function getOrderId() {
		return $this->orderId;
	}

	/**
	 * 決済結果のステータスの取得
	 * @return String 決済結果のステータス
	 */
	public function getMStatus() {
		return $this->mStatus;
	}

	/**
	 * 決済結果のステータスの設定
	 * @param String mStatus
	 */
	public function setMStatus($mStatus) {
		$this->mStatus = urldecode(mb_convert_encoding($mStatus, AW_BASE_ENCODE, AW_SERVER_ENCODE));
		if (strlen($this->mStatus) == 0) {
			$this->mStatus = $mStatus;
		}
	}

	/**
	 * エラーメッセージの取得
	 * @return String mErrMsg
	 */
	public function getMErrMsg() {
		return $this->mErrMsg;
	}

	/**
	 * エラーメッセージの設定
	 * @param String mErrMsg
	 */
	public function setMErrMsg($mErrMsg) {
		$this->mErrMsg = urldecode(mb_convert_encoding($mErrMsg, AW_BASE_ENCODE, AW_SERVER_ENCODE));
		if (strlen($this->mErrMsg) == 0) {
			$this->mErrMsg = $mErrMsg;
		}
	}

	/**
	 * 結果コードの取得
	 * @return String vResultCode
	 */
	public function getvResultCode() {
		return $this->vResultCode;
	}

	/**
	 * 結果コードの設定
	 * @param String vResultCode
	 */
	public function setvResultCode($vResultCode) {
		$this->vResultCode = urldecode(mb_convert_encoding($vResultCode, AW_BASE_ENCODE, AW_SERVER_ENCODE));
		if (strlen($this->vResultCode) == 0) {
			$this->vResultCode = $vResultCode;
		}
	}

	/**
	 * セッションIDの取得
	 * @return String sessionId
	 */
	public function getSessionId() {
		return $this->sessionId;
	}

	/**
	 * セッションIDの設定
	 * @param <type> $sessionId
	 */
	public function setSessionId($sessionId) {
		$this->sessionId = urldecode(mb_convert_encoding($sessionId, AW_BASE_ENCODE, AW_SERVER_ENCODE));
		if (strlen($this->sessionId) == 0) {
			$this->sessionId = $sessionId;
		}
	}

	/**
	 * 漢字氏名の取得
	 * @return String userName
	 */
	public function getUserName() {
		return $this->userName;
	}

	/**
	 * 漢字氏名の設定
	 * @param String $userName
	 */
	public function setUserName($userName) {
		$this->userName = urldecode(mb_convert_encoding($userName, AW_BASE_ENCODE, AW_SERVER_ENCODE));
		if (strlen($this->userName) == 0) {
			$this->userName = $userName;
		}
	}

	/**
	 * カナ氏名の取得
	 * @return String userNameKana
	 */
	public function getUserNameKana() {
		return $this->userNameKana;
	}

	/**
	 * カナ氏名の設定
	 * @param String $userNameKana
	 */
	public function setUserNameKana($userNameKana) {
		$this->userNameKana = urldecode(mb_convert_encoding($userNameKana, AW_BASE_ENCODE, AW_SERVER_ENCODE));
		if (strlen($this->userNameKana) == 0) {
			$this->userNameKana = $userNameKana;
		}
	}

	/**
	 * メールアドレスの取得
	 * @return String  mailAddress
	 */
	public function getMailAddress() {
		return $this->mailAddress;
	}

	/**
	 * メールアドレスの設定
	 * @param String $mailAddress
	 */
	public function setMailAddress($mailAddress) {
		$this->mailAddress = urldecode(mb_convert_encoding($mailAddress, AW_BASE_ENCODE, AW_SERVER_ENCODE));
		if (strlen($this->mailAddress) == 0) {
			$this->mailAddress = $mailAddress;
		}
	}

	/**
	 * 住所の取得
	 * @return String address
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * 住所の設定
	 * @param String $address
	 */
	public function setAddress($address) {
		$this->address = urldecode(mb_convert_encoding($address, AW_BASE_ENCODE, AW_SERVER_ENCODE));
		if (strlen($this->address) == 0) {
			$this->address = $address;
		}
	}

	/**
	 * 性別の取得
	 * @return String sex
	 */
	public function getSex() {
		return $this->sex;
	}

	/**
	 * 性別の設定
	 * @param String $sex
	 */
	public function setSex($sex) {
		$this->sex = urldecode(mb_convert_encoding($sex, AW_BASE_ENCODE, AW_SERVER_ENCODE));
		if (strlen($this->sex) == 0) {
			$this->sex = $sex;
		}
	}

	/**
	 * 電話番号の取得
	 * @return String  telephoneno
	 */
	public function getTelephoneno() {
		return $this->telephoneno;
	}

	/**
	 * 電話番号の設定
	 * @param String $telephoneno
	 */
	public function setTelephoneno($telephoneno) {
		$this->telephoneno = urldecode(mb_convert_encoding($telephoneno, AW_BASE_ENCODE, AW_SERVER_ENCODE));
		if (strlen($this->telephoneno) == 0) {
			$this->telephoneno = $telephoneno;
		}
	}

	/**
	 * 郵便番号の取得
	 * @return String zipcode
	 */
	public function getZipcode() {
		return $this->zipcode;
	}

	/**
	 * 郵便番号の設定
	 * @param String $zipcode
	 */
	public function setZipcode($zipcode) {
		$this->zipcode = urldecode(mb_convert_encoding($zipcode, AW_BASE_ENCODE, AW_SERVER_ENCODE));
		if (strlen($this->zipcode) == 0) {
			$this->zipcode = $zipcode;
		}
	}

	/**
	 * 誕生日の取得
	 * @return String birthday
	 */
	public function getBirthday() {
		return $this->birthday;
	}

	/**
	 * 誕生日の設定
	 * @param String $birthday
	 */
	public function setBirthday($birthday) {
		$this->birthday = urldecode(mb_convert_encoding($birthday, AW_BASE_ENCODE, AW_SERVER_ENCODE));
		if (strlen($this->birthday) == 0) {
			$this->birthday = $birthday;
		}
	}

	/**
	 * ActionFormのabstruct method
	 * エラーチェック
	 * @return エラーメッセージ（配列）
	 */
	public function validate() {
		$log = $this->log->getMethodLog(__METHOD__);
		$errors = array();

		// チェック対象プロパティのどれかが空であるか検査
		foreach ($this->validateParam as $param) {
			$value = $this->getValue($param);
			if ($this->IsEmpty($value)) {
				$errors[] = $param . " is empty";
				$log->info("パラメータ" . $param . "が未入力");
				break;
			}
		}
		return $errors;
	}

	/**
	 * ActionFormのabstruct method
	 */
	protected function setValue($name, $value) {
		$setMthod = 'set' . ucfirst($name);
		if (method_exists($this, $setMthod)) {
			$this->$setMthod($value);
		}
	}

	/**
	 * ActionFormのabstruct method
	 */
	protected function getValue($name) {
		$getMthod = 'get' . ucfirst($name);
		if (method_exists($this, $getMthod)) {
			return $this->$getMthod();
		} else {
			return null;
		}
	}

}

?>