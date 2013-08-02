<?php

// SOAP出力用日時フォーマット
define('SOAP_DATETIME_FORMAT', 'Y-m-d\TH:i:s\Z');
define('SOAP_DATE_FORMAT', 'Y-m-d');

/**
 * class PurchaseData
 * 個人情報クラス
 * jp.co.veritrans.card.web.ws.bean.PurchaseDataより移植
 *
 * @copyright
 */
class PurchaseData {
	/**
	 * マーチャントID
	 * @var string
	 */
	private $merchantId = null;
	/**
	 * マーチャント生成ハッシュ値
	 * @var string
	 */
	private $merchanthash = null;
	/**
	 * 決済方法
	 * @var string
	 */
	private $settlementType = null;
	/**
	 * 決済方法サブタイプ
	 * @var string
	 */
	private $settlementSubType = null;
	/**
	 * 取引ID
	 * @var string
	 */
	private $orderId = null;
	/**
	 * 購入金額
	 * @var string
	 */
	private $amount = null;
	/**
	 * 送料金額
	 * @var string
	 */
	private $shippingAmount = null;
	/**
	 * SessionID
	 * @var string
	 */
	private $sessionId = null;
	/**
	 * 支払期限
	 * @var string
	 */
	private $timelimitOfPayment = null;
	/**
	 * 決済完了後戻りURL
	 * @var string
	 */
	private $finishPaymentReturnUrl = null;
	/**
	 * 決済結果通知先URL
	 * @var string
	 */
	private $finishPaymentAccessUrl = null;
	/**
	 * カード売上フラグ
	 * @var string
	 */
	private $cardCaptureFlag = null;
	/**
	 * 名前１
	 * @var string
	 */
	private $name1 = null;
	/**
	 * 名前２
	 * @var string
	 */
	private $name2 = null;
	/**
	 * カナ１
	 * @var string
	 */
	private $kana1 = null;
	/**
	 * カナ２
	 * @var string
	 */
	private $kana2 = null;
	/**
	 * 電話番号
	 * @var string
	 */
	private $telephoneNo = null;
	/**
	 * メールアドレス
	 * @var string
	 */
	private $mailAddress = null;
	/**
	 * 郵便番号
	 * @var string
	 */
	private $zipCode = null;
	/**
	 * 住所１
	 * @var string
	 */
	private $address1 = null;
	/**
	 * 住所２
	 * @var string
	 */
	private $address2 = null;
	/**
	 * 住所３
	 * @var string
	 */
	private $address3 = null;

	/**
	 * 生年月日
	 * @var string
	 */
	private $birthday = null;
	/**
	 * 性別
	 * @var string
	 */
	private $sex = null;
	/**
	 * commodityDetails
	 * @var CommodityDetail
	 */
	private $commodityDetails = null;

	/**
	 * __constructur
	 */
	public function __construct() {

	}
	/**
	 * マーチャントIDの取得
	 * @return string マーチャントID
	 */
	public function getMerchantId() {
		return $this->merchantId;
	}

	/**
	 * マーチャントIDの設定
	 * @param string $merchantId マーチャントID
	 */
	public function setMerchantId($merchantId) {
		$this->merchantId = $merchantId;
	}

	/**
	 * マーチャント生成ハッシュ値の取得
	 * @return string マーチャント生成ハッシュ値
	 */
	public function getMerchanthash() {
		return $this->merchanthash;
	}

	/**
	 * マーチャント生成ハッシュ値の設定
	 * @param string $merchanthash マーチャント生成ハッシュ値
	 */
	public function setMerchanthash($merchanthash) {
		$this->merchanthash = $merchanthash;
	}

	/**
	 * 決済方法の取得
	 * @return string 決済方法
	 */
	public function getSettlementType() {
		return $this->settlementType;
	}

	/**
	 * 決済方法の設定
	 * @param string $settlementType 決済方法
	 */
	public function setSettlementType($settlementType) {
		$this->settlementType = $settlementType;
	}

	/**
	 * 決済方法サブタイプの取得
	 * @return string 決済方法サブタイプ
	 */
	public function getSettlementSubType() {
		return $this->settlementSubType;
	}

	/**
	 * 決済方法サブタイプの設定
	 * @param string $settlementType 決済方法サブタイプ
	 */
	public function setSettlementSubType($settlementSubType) {
		$this->settlementSubType = $settlementSubType;
	}

	/**
	 * 取引IDの取得
	 * @return string 取引ID
	 */
	public function getOrderId() {
		return $this->orderId;
	}

	/**
	 * 取引IDの設定
	 * @param string $orderId 取引ID
	 */
	public function setOrderId($orderId) {
		$this->orderId = $orderId;
	}

	/**
	 * 購入金額の取得
	 * @return string 購入金額
	 */
	public function getAmount() {
		return $this->amount;
	}

	/**
	 * 購入金額の設定
	 * @param string $amount 購入金額
	 */
	public function setAmount($amount) {
		$this->amount = $amount;
	}

	/**
	 * 送料金額の取得
	 * @return string 送料金額
	 */
	public function getShippingAmount() {
		return $this->shippingAmount;
	}

	/**
	 * 送料金額の設定
	 * @param string $amount 送料金額
	 */
	public function setShippingAmount($shippingAmount) {
		$this->shippingAmount = $shippingAmount;
	}

	/**
	 * SessionIDの取得
	 * @return string SessionID
	 */
	public function getSessionId() {
		return $this->sessionId;
	}

	/**
	 * SessionIDの設定
	 * @param string $sessionId SessionID
	 */
	public function setSessionId($sessionId) {
		$this->sessionId = $sessionId;
	}

	/**
	 * 支払期限の取得
	 * @return string 支払期限
	 */
	public function getTimelimitOfPayment() {
		return $this->timelimitOfPayment;
	}

	/**
	 * 支払期限の設定
	 * @param string $timelimitOfPayment 支払期限
	 */
	public function setTimelimitOfPayment($timelimitOfPayment) {
		$this->timelimitOfPayment = $timelimitOfPayment;
	}

	/**
	 * 決済完了後戻りURLの取得
	 * @return string 決済完了後戻りURL
	 */
	public function getFinishPaymentReturnUrl() {
		return $this->finishPaymentReturnUrl;
	}

	/**
	 * 決済完了後戻りURLの設定
	 * @param string $finishPaymentReturnUrl 決済完了後戻りURL
	 */
	public function setFinishPaymentReturnUrl($finishPaymentReturnUrl) {
		$this->finishPaymentReturnUrl = $finishPaymentReturnUrl;
	}
	
	/**
	 * 決済結果通知先URLの取得
	 * @return string 決済結果通知先URL
	 */
	public function getFinishPaymentAccessUrl() {
		return $this->finishPaymentAccessUrl;
	}
	
	/**
	 * 決済結果通知先URLの設定
	 * @param string $finishPaymentAccessUrl 決済結果通知先URL
	 */
	public function setFinishPaymentAccessUrl($finishPaymentAccessUrl) {
		$this->finishPaymentAccessUrl = $finishPaymentAccessUrl;
	}

	/**
	 * カード売上フラグの取得
	 * @return string カード売上フラグ
	 */
	public function getCardCaptureFlag() {
		return $this->cardCaptureFlag;
	}

	/**
	 * カード売上フラグの設定
	 * @param string $cardCaptureFlag カード売上フラグ
	 */
	public function setCardCaptureFlag($cardCaptureFlag) {
		$this->cardCaptureFlag = $cardCaptureFlag;
	}

	/**
	 * 名前１の取得
	 * @return string 名前１
	 */
	public function getName1() {
		return $this->name1;
	}

	/**
	 * 名前１の設定
	 * @param string $name1 名前１
	 */
	public function setName1($name1) {
		$this->name1 = $name1;
	}

	/**
	 * 名前２の取得
	 * @return string 名前２
	 */
	public function getName2() {
		return $this->name2;
	}

	/**
	 * 名前２の設定
	 * @param string $name2 名前２
	 */
	public function setName2($name2) {
		$this->name2 = $name2;
	}

	/**
	 * カナ１の取得
	 * @return string カナ１
	 */
	public function getKana1() {
		return $this->kana1;
	}

	/**
	 * カナ１の設定
	 * @param string $kana1 カナ１
	 */
	public function setKana1($kana1) {
		$this->kana1 = $kana1;
	}

	/**
	 * カナ２の取得
	 * @return string カナ２
	 */
	public function getKana2() {
		return $this->kana2;
	}

	/**
	 * カナ２の設定
	 * @param string $kana2 カナ２
	 */
	public function setKana2($kana2) {
		$this->kana2 = $kana2;
	}

	/**
	 * 電話番号の取得
	 * @return string 電話番号
	 */
	public function getTelephoneNo() {
		return $this->telephoneNo;
	}

	/**
	 * 電話番号の設定
	 * @param string $telephoneNo 電話番号
	 */
	public function setTelephoneNo($telephoneNo) {
		$this->telephoneNo = $telephoneNo;
	}

	/**
	 * メールアドレスの取得
	 * @return string メールアドレス
	 */
	public function getMailAddress() {
		return $this->mailAddress;
	}

	/**
	 * メールアドレスの設定
	 * @param string $mailAddress
	 */
	public function setMailAddress($mailAddress) {
		$this->mailAddress = $mailAddress;
	}

	/**
	 * 郵便番号の取得
	 * @return string 郵便番号
	 */
	public function getZipCode() {
		return $this->zipCode;
	}

	/**
	 * 郵便番号の設定
	 * @param string $zipCode 郵便番号
	 */
	public function setZipCode($zipCode) {
		$this->zipCode = $zipCode;
	}

	/**
	 * 住所１の取得
	 * @return string 住所１
	 */
	public function getAddress1() {
		return $this->address1;
	}

	/**
	 * 住所１の設定
	 * @param string $address1 住所１
	 */
	public function setAddress1($address1) {
		$this->address1 = $address1;
	}

	/**
	 * 住所２の取得
	 * @return string 住所２
	 */
	public function getAddress2() {
		return $this->address2;
	}

	/**
	 * 住所２の設定
	 * @param string $address2 住所２
	 */
	public function setAddress2($address2) {
		$this->address2 = $address2;
	}

	/**
	 * 住所３の取得
	 * @return string 住所３
	 */
	public function getAddress3() {
		return $this->address3;
	}

	/**
	 * 住所３の設定
	 * @param string $address3 住所３
	 */
	public function setAddress3($address3) {
		$this->address3 = $address3;
	}

	/**
	 * 生年月日の取得
	 * @return string 生年月日
	 */
	public function getBirthday() {
		return $this->birthday;
	}

	/**
	 * 生年月日の設定
	 * @param string $birthdayYYYY 生年月日
	 */
	public function setBirthday($birthday) {
		$this->birthday = $birthday;
	}

	/**
	 * 性別の取得
	 * @return string 性別
	 */
	public function getSex() {
		return $this->sex;
	}

	/**
	 * 性別の設定
	 * @param string $sex 性別
	 */
	public function setSex($sex) {
		$this->sex = $sex;
	}

	/**
	 * commodityDetailsの取得
	 * @return commodityDetails
	 */
	public function getCommodityDetails() {
		return $this->commodityDetails;
	}

	/**
	 * commodityDetailsの設定
	 * @param commodityDetails
	 */
	public function setCommodityDetails($commodityDetails) {
		$this->commodityDetails = $commodityDetails;
	}

}

?>