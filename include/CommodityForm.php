<?php

// 共通インクルードファイル
require_once('common.php');

/**
 * class CommodityForm
 * 入力フォームクラス
 * jp.co.veritrans.sample.CommodityFormより移植
 */
class CommodityForm extends ActionForm {
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
	 * 電話番号(市外局番)
	 * @var string
	 */
	private $telephoneNo1 = null;
	/**
	 * 電話番号(市内局番)
	 * @var string
	 */
	private $telephoneNo2 = null;
	/**
	 * 電話番号(加入者番号)
	 * @var string
	 */
	private $telephoneNo3 = null;
	/**
	 * メールアドレス
	 * @var string
	 */
	private $mailAddress = null;
	/**
	 * 郵便番号(先頭3桁)
	 * @var string
	 */
	private $zipCode1 = null;
	/**
	 * 郵便番号(末尾4桁)
	 * @var string
	 */
	private $zipCode2 = null;
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
	 * 生年月日(年)
	 * @var string
	 */
	private $birthdayYYYY = null;
	/**
	 * 生年月日(月)
	 * @var string
	 */
	private $birthdayMM = null;
	/**
	 * 生年月日(日)
	 * @var string
	 */
	private $birthdayDD = null;
	/**
	 * 性別
	 * @var string
	 */
	private $sex = null;
	/**
	 * 商品ID
	 * @var string
	 */
	private $commodityId1 = null;
	/**
	 * 商品ID
	 * @var string
	 */
	private $commodityId2 = null;
	/**
	 * 商品ID
	 * @var string
	 */
	private $commodityId3 = null;
	/**
	 * 単価
	 * @var string
	 */
	private $commodityUnit1 = null;
	/**
	 * 単価
	 * @var string
	 */
	private $commodityUnit2 = null;
	/**
	 * 単価
	 * @var string
	 */
	private $commodityUnit3 = null;
	/**
	 * 個数
	 * @var string
	 */
	private $commodityNum1 = null;
	/**
	 * 個数
	 * @var string
	 */
	private $commodityNum2 = null;
	/**
	 * 個数
	 * @var string
	 */
	private $commodityNum3 = null;
	/**
	 * 商品名
	 * @var string
	 */
	private $commodityName1 = null;
	/**
	 * 商品名
	 * @var string
	 */
	private $commodityName2 = null;
	/**
	 * 商品名
	 * @var string
	 */
	private $commodityName3 = null;
	/**
	 * JANコード
	 * @var string
	 */
	private $commodityJanCode1 = null;
	/**
	 * JANコード
	 * @var string
	 */
	private $commodityJanCode2 = null;
	/**
	 * JANコード
	 * @var string
	 */
	private $commodityJanCode3 = null;
	/**
	 * ブラウザ側暗号鍵
	 * @var string
	 */
	private $settlementKey1A = null;
	/**
	 * 決済結果
	 * @var string
	 */
	private $settlementComplete = null;
	/**
	 * 商品IDのマップ
	 * @var array
	 */
	private $idmap = array();
	/**
	 * 商品名のマップ
	 * @var array
	 */
	private $namemap = array();
	/**
	 * 個数のマップ
	 * @var array
	 */
	private $nummap = array();
	/**
	 * 単価のマップ
	 * @var array
	 */
	private $unitmap = array();
	/**
	 * JANコードのマップ
	 * @var array
	 */
	private $janCodemap = array();
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
	 * 電話番号(市外局番)の取得
	 * @return string 電話番号(市外局番)
	 */
	public function getTelephoneNo1() {
		return $this->telephoneNo1;
	}

	/**
	 * 電話番号(市外局番)の設定
	 * @param string $telephoneNo1 電話番号(市外局番)
	 */
	public function setTelephoneNo1($telephoneNo1) {
		$this->telephoneNo1 = $telephoneNo1;
	}

	/**
	 * 電話番号(市内局番)の取得
	 * @return string 電話番号(市内局番)
	 */
	public function getTelephoneNo2() {
		return $this->telephoneNo2;
	}

	/**
	 * 電話番号(市内局番)の設定
	 * @param string $telephoneNo2 電話番号(市内局番)
	 */
	public function setTelephoneNo2($telephoneNo2) {
		$this->telephoneNo2 = $telephoneNo2;
	}

	/**
	 * 電話番号(加入者番号)の取得
	 * @return string 電話番号(加入者番号)
	 */
	public function getTelephoneNo3() {
		return $this->telephoneNo3;
	}

	/**
	 * 電話番号(加入者番号)の設定
	 * @param string $telephoneNo3 電話番号(加入者番号)
	 */
	public function setTelephoneNo3($telephoneNo3) {
		$this->telephoneNo3 = $telephoneNo3;
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
	 * 郵便番号(先頭3桁)の取得
	 * @return string 郵便番号(先頭3桁)
	 */
	public function getZipCode1() {
		return $this->zipCode1;
	}

	/**
	 * 郵便番号(先頭3桁)の設定
	 * @param string $zipCode1 郵便番号(先頭3桁)
	 */
	public function setZipCode1($zipCode1) {
		$this->zipCode1 = $zipCode1;
	}

	/**
	 * 郵便番号(末尾4桁)の取得
	 * @return string 郵便番号(末尾4桁)
	 */
	public function getZipCode2() {
		return $this->zipCode2;
	}

	/**
	 * 郵便番号(末尾4桁)の設定
	 * @param string $zipCode2 郵便番号(末尾4桁)
	 */
	public function setZipCode2($zipCode2) {
		$this->zipCode2 = $zipCode2;
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
	 * 生年月日(年)の取得
	 * @return string 生年月日(年)
	 */
	public function getBirthdayYYYY() {
		return $this->birthdayYYYY;
	}

	/**
	 * 生年月日(年)の設定
	 * @param string $birthdayYYYY 生年月日(年)
	 */
	public function setBirthdayYYYY($birthdayYYYY) {
		$this->birthdayYYYY = $birthdayYYYY;
	}

	/**
	 * 生年月日(月)の取得
	 * @return string 生年月日(月)
	 */
	public function getBirthdayMM() {
		return $this->birthdayMM;
	}

	/**
	 * 生年月日(月)の設定
	 * @param string $birthdayMM 生年月日(月)
	 */
	public function setBirthdayMM($birthdayMM) {
		if (preg_match('/^\d{1,2}$/i', $birthdayMM)) {
			$this->birthdayMM = sprintf("%02d", intval($birthdayMM));
		} else {
			$this->birthdayMM = null;
		}
	}

	/**
	 * 生年月日(日)の取得
	 * @return string 生年月日(日)
	 */
	public function getBirthdayDD() {
		return $this->birthdayDD;
	}

	/**
	 * 生年月日(日)の設定
	 * @param string $birthdayDD 生年月日(日)
	 */
	public function setBirthdayDD($birthdayDD) {
		if (preg_match('/^\d{1,2}$/i', $birthdayDD)) {
			$this->birthdayDD = sprintf("%02d", intval($birthdayDD));
		} else {
			$this->birthdayDD = null;
		}
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
	 * 郵便番号の取得
	 * @return 郵便番号
	 */
	public function getZipCode() {
		return $this->zipCode1 . $this->zipCode2;
	}

	/**
	 * 電話番号の取得
	 * @return 電話番号
	 */
	public function getTelephoneNo() {
		return $this->telephoneNo1 . $this->telephoneNo2 . $this->telephoneNo3;
	}

	/**
	 * 誕生日の取得
	 * @return 誕生日
	 */
	public function getBirthday() {
		if (!$this->IsEmpty($this->birthdayYYYY) && !$this->IsEmpty($this->birthdayMM) && !$this->IsEmpty($this->birthdayDD)) {
			return $this->birthdayYYYY . $this->birthdayMM . $this->birthdayDD;
		} else {
			return "";
		}
	}

	/**
	 * 商品IDの取得
	 * @return 商品ID１
	 */
	public function getCommodityId1() {
		return $this->commodityId1;
	}

	/**
	 * 商品IDの設定
	 * @param commodityId1 商品ID１
	 */
	public function setCommodityId1($commodityId1) {
		$this->commodityId1 = $commodityId1;
		$this->idmap[1] = $commodityId1;
	}

	/**
	 * 商品IDの取得
	 * @return 商品ID2
	 */
	public function getCommodityId2() {
		return $this->commodityId2;
	}

	/**
	 * 商品IDの設定
	 * @param commodityId1 商品ID2
	 */
	public function setCommodityId2($commodityId2) {
		$this->commodityId2 = $commodityId2;
		$this->idmap[2] = $commodityId2;
	}

	/**
	 * 商品IDの取得
	 * @return 商品ID3
	 */
	public function getCommodityId3() {
		return $this->commodityId3;
	}

	/**
	 * 商品IDの設定
	 * @param commodityId1 商品ID3
	 */
	public function setCommodityId3($commodityId3) {
		$this->commodityId3 = $commodityId3;
		$this->idmap[3] = $commodityId3;
	}

	/**
	 * 商品名の取得
	 * @return 商品名
	 */
	public function getCommodityName1() {
		return $this->commodityName1;
	}

	/**
	 * 商品名の設定
	 * @param commodityName1 商品名１
	 */
	public function setCommodityName1($commodityName1) {
		$this->commodityName1 = $commodityName1;
		$this->namemap[1] = $commodityName1;
	}

	/**
	 * 商品名の取得
	 * @return 商品名
	 */
	public function getCommodityName2() {
		return $this->commodityName2;
	}

	/**
	 * 商品名の設定
	 * @param commodityName2 商品名２
	 */
	public function setCommodityName2($commodityName2) {
		$this->commodityName2 = $commodityName2;
		$this->namemap[2] = $commodityName2;
	}

	/**
	 * 商品名の取得
	 * @return 商品名
	 */
	public function getCommodityName3() {
		return $this->commodityName3;
	}

	/**
	 * 商品名の設定
	 * @param commodityName3 商品名３
	 */
	public function setCommodityName3($commodityName3) {
		$this->commodityName3 = $commodityName3;
		$this->namemap[3] = $commodityName3;
	}

	/**
	 * 個数の取得
	 * @return 個数１
	 */
	public function getCommodityNum1() {
		return $this->commodityNum1;
	}

	/**
	 * 個数の設定
	 * @param commodityNum1 個数１
	 */
	public function setCommodityNum1($commodityNum1) {
		$this->commodityNum1 = $commodityNum1;
		$this->nummap[1] = $commodityNum1;
	}

	/**
	 * 個数の取得
	 * @return 個数
	 */
	public function getCommodityNum2() {
		return $this->commodityNum2;
	}

	/**
	 * 個数の設定
	 * @param commodityNum2 個数
	 */
	public function setCommodityNum2($commodityNum2) {
		$this->commodityNum2 = $commodityNum2;
		$this->nummap[2] = $commodityNum2;
	}

	/**
	 * 個数の取得
	 * @return 個数
	 */
	public function getCommodityNum3() {
		return $this->commodityNum3;
	}

	/**
	 * 個数の設定
	 * @param commodityNum3 個数
	 */
	public function setCommodityNum3($commodityNum3) {
		$this->commodityNum3 = $commodityNum3;
		$this->nummap[3] = $commodityNum3;
	}

	/**
	 * 価格の取得
	 * @return 価格
	 */
	public function getCommodityUnit1() {
		return $this->commodityUnit1;
	}

	/**
	 * 価格の設定
	 * @param commodityUnit1 価格
	 */
	public function setCommodityUnit1($commodityUnit1) {
		$this->commodityUnit1 = $commodityUnit1;
		$this->unitmap[1] = $commodityUnit1;
	}

	/**
	 * 価格の取得
	 * @return 価格
	 */
	public function getCommodityUnit2() {
		return $this->commodityUnit2;
	}

	/**
	 * 価格の設定
	 * @param commodityUnit2 価格
	 */
	public function setCommodityUnit2($commodityUnit2) {
		$this->commodityUnit2 = $commodityUnit2;
		$this->unitmap[2] = $commodityUnit2;
	}

	/**
	 * 価格の取得
	 * @return 価格
	 */
	public function getCommodityUnit3() {
		return $this->commodityUnit3;
	}

	/**
	 * 価格の設定
	 * @param commodityUnit3 価格
	 */
	public function setCommodityUnit3($commodityUnit3) {
		$this->commodityUnit3 = $commodityUnit3;
		$this->unitmap[3] = $commodityUnit3;
	}

	/**
	 * JANコードの取得
	 * @return JANコード１
	 */
	public function getCommodityJanCode1() {
		return $this->commodityJanCode1;
	}

	/**
	 * JANコードの設定
	 * @param commodityJanCode1 JANコード１
	 */
	public function setCommodityJanCode1($commodityJanCode1) {
		$this->commodityJanCode1 = $commodityJanCode1;
		$this->janCodemap[1] = $commodityJanCode1;
	}

	/**
	 * JANコードの取得
	 * @return JANコード2
	 */
	public function getCommodityJanCode2() {
		return $this->commodityJanCode2;
	}

	/**
	 * JANコードの設定
	 * @param commodityJanCode2 JANコード2
	 */
	public function setCommodityJanCode2($commodityJanCode2) {
		$this->commodityJanCode2 = $commodityJanCode2;
		$this->janCodemap[2] = $commodityJanCode2;
	}

	/**
	 * JANコードの取得
	 * @return JANコード3
	 */
	public function getCommodityJanCode3() {
		return $this->commodityJanCode3;
	}

	/**
	 * JANコードの設定
	 * @param commodityJanCode3 JANコード3
	 */
	public function setCommodityJanCode3($commodityJanCode3) {
		$this->commodityJanCode3 = $commodityJanCode3;
		$this->janCodemap[3] = $commodityJanCode3;
	}

	/**
	 * 商品IDマップサイズの取得
	 * @return 商品IDマップのサイズ
	 */
	public function getIdlistSize() {
		return count($this->idmap);
	}

	/**
	 * 名前マップサイズの取得
	 * @return 名前マップのサイズ
	 */
	public function getNamelistSize() {
		return count($this->namemap);
	}

	/**
	 * 個数マップサイズの取得
	 * @return 個数マップのサイズ
	 */
	public function getNumlistSize() {
		return count($this->nummap);
	}

	/**
	 * 価格マップサイズの取得
	 * @return 価格マップのサイズ
	 */
	public function getUnitlistSize() {
		return count($this->unitmap);
	}

	/**
	 * JANコードマップサイズの取得
	 * @return 価格マップのサイズ
	 */
	public function getJanCodelistSize() {
		return count($this->janCodemap);
	}

	/**
	 * 商品IDの取得
	 * @param index マップのインデックス
	 * @return 商品ID
	 */
	public function getIdmap($index) {
		return $this->idmap[$index];
	}

	/**
	 * 名前の取得
	 * @param index マップのインデックス
	 * @return 商品名
	 */
	public function getNamemap($index) {
		return $this->namemap[$index];
	}

	/**
	 * 個数の取得
	 * @param index マップのインデックス
	 * @return 個数
	 */
	public function getNummap($index) {
		return $this->nummap[$index];
	}

	/**
	 * 価格の取得
	 * @param index マップのインデックス
	 * @return 価格
	 */
	public function getUnitmap($index) {
		return $this->unitmap[$index];
	}

	/**
	 * JanCodeの取得
	 * @param index マップのインデックス
	 * @return 価格
	 */
	public function getJanCodemap($index) {
		return $this->janCodemap[$index];
	}

	/**
	 * ブラウザ側暗号鍵の取得
	 * @return string ブラウザ側暗号鍵
	 */
	public function getSettlementKey1A() {
		return $this->settlementKey1A;
	}

	/**
	 * ブラウザ側暗号鍵の設定
	 * @param string $settlementKey1A ブラウザ側暗号鍵
	 */
	public function setSettlementKey1A($settlementKey1A) {
		$this->settlementKey1A = $settlementKey1A;
	}

	/**
	 * 決済結果の取得
	 * @return string 決済結果
	 */
	public function getSettlementComplete() {
		return $this->settlementComplete;
	}

	/**
	 * 決済結果の設定
	 * @param string $settlementComplete 決済結果
	 */
	public function setSettlementComplete($settlementComplete) {
		$this->settlementComplete = $settlementComplete;
	}

	/**
	 * ActionFormのabstruct method
	 * エラーチェック
	 * @return エラーメッセージ（配列）
	 */
	public function validate() {
		$log = $this->log->getMethodLog(__METHOD__);
		$errors = array();

		// 1:メールアドレス
		if (!$this->IsEmpty($this->mailAddress)) {
			if (!$this->IsAscii($this->mailAddress)) {
				$log->debug("全角文字：メールアドレス");
				$errors[] = $this->actionMessage("error.mailAddress.singlebyte");
			}
		}

		// 2:名前１
		if (!$this->IsEmpty($this->name1)) {
			if ($this->IsAscii($this->name1)) {
				$log->debug("全角文字：名前１");
				$errors[] = $this->actionMessage("error.name1.multibyte");
			}
		}

		// 3:名前２
		if (!$this->IsEmpty($this->name2)) {
			if ($this->IsAscii($this->name2)) {
				$log->debug("全角文字：名前２");
				$errors[] = $this->actionMessage("error.name2.multibyte");
			}
		}

		// 4:カナ１
		if (!$this->IsEmpty($this->kana1)) {
			if (!$this->IsMultiByteKana($this->getKana1())) {
				$log->debug("全角文字：カナ１");
				$errors[] = $this->actionMessage("error.kana1.multibyte");
			}
		}

		// 5:カナ２
		if (!$this->IsEmpty($this->kana2)) {
			if (!$this->IsMultiByteKana($this->getKana2())) {
				$log->debug("全角文字：カナ２");
				$errors[] = $this->actionMessage("error.kana2.multibyte");
			}
		}

		// 6:郵便番号
		if (!$this->IsEmpty($this->getZipCode())) {
			$tmp = pereg_replace("[^0-9]", "", $this->getZipCode());
			if (strcmp($tmp, $this->getZipCode()) != 0) {
				$log->debug("非半角数字：郵便番号");
				$errors[] = $this->actionMessage("error.zipCode.forbiddenchar");
			}
		}

		// 7:住所１
		if (!$this->IsEmpty($this->address1)) {
			if ($this->IsAscii($this->address1)) {
				$log->debug("全角文字：住所１");
				$errors[] = $this->actionMessage("error.address1.multibyte");
			}
		}

		// 8:住所２
		if (!$this->IsEmpty($this->address2)) {
			if ($this->IsAscii($this->address2)) {
				$log->debug("全角文字：住所２");
				$errors[] = $this->actionMessage("error.address2.multibyte");
			}
		}

		// 9:住所３
		if (!$this->IsEmpty($this->address3)) {
			if ($this->IsAscii($this->address3)) {
				$log->debug("全角文字：住所３");
				$errors[] = $this->actionMessage("error.address3.multibyte");
			}
		}

		// 10:電話番号
		if (!$this->IsEmpty($this->getTelephoneNo())) {
			if (!$this->IsAscii($this->getTelephoneNo())) {
				$log->debug("全角文字：電話番号");
				$errors[] = $this->actionMessage("error.telephoneNo.singlebyte");
			}
		}

		// 11:生年月日
		if (!$this->IsEmpty($this->birthdayYYYY) || !$this->IsEmpty($this->birthdayMM) || !$this->IsEmpty($this->birthdayDD)) {
			if (!$this->birthdaycheck($this->birthdayYYYY, $this->birthdayMM, $this->birthdayDD)) {
				$errors[] = $this->actionMessage("error.birthday.notdate");
			}
		}


		// 34-38:商品情報
		if ($this->namemap == null || $this->getNamelistSize() == 0) {
			if (($this->idmap != null && $this->getIdlistSize() > 0)
					|| ($this->janCodemap != null && $this->getJanCodelistSize() > 0)
					|| ($this->nummap != null && $this->getNumlistSize() > 0)
					|| ($this->unitmap != null && $this->getUnitlistSize() > 0)
			) {
				// 商品名に入力がない場合は商品情報は入力不可
				$this->logCommodityInfo();
				$errors[] = $this->actionMessage("error.commodityinfo.invalid");
			}
		} else {
			$commoditySize = $this->getNamelistSize();
			if ($this->nummap == null || $this->getNumlistSize() != $commoditySize
					|| $this->unitmap == null || $this->getUnitlistSize() != $commoditySize
					|| ($this->idmap != null && $this->getIdlistSize() != $commoditySize)
					|| ($this->janCodemap != null && $this->getJanCodelistSize() != $commoditySize)
			) {
				// 商品名の入力数と個数、単価の入力数は一致していければならない
				// 商品IDとJAN_CODEは入力必須ではないが、入力している場合は商品名の入力数と一致していなければならない
				$this->logCommodityInfo();
				$errors[] = $this->actionMessage("error.commodityinfo.unnmatch");
			} else {
				for ($i = 0; $i < $commoditySize; $i++) {
					if (!$this->IsNumeric($this->nummap[$i + 1]) || !$this->IsNumeric($this->nummap[$i + 1])) {
						// 単価と個数は数値項目でなければならない
						$this->logCommodityInfo();
						$errors[] = $this->actionMessage("error.commodityinfo.notnumeric");
					}
				}
			}
		}
		return $errors;
	}

	/**
	 * 日付の整合性チェック
	 * @param year 誕生日（年）
	 * @param month 誕生日（月）
	 * @param day 誕生日（日）
	 * @return True：日付が正しい、False：日付が不正
	 */
	private function birthdaycheck($year, $month, $day) {
		$log = $this->log->getMethodLog(__METHOD__);
		if (strlen($year) != 4) {
			$log->debug("年が４桁ではないのでやり直し");
			return false;
		}
		$result = checkdate(intval($month), intval($day), intval($year));
		if (!$result) {
			$log->debug("日付として正しくないのでやり直し");
		}
		return $result;
	}

	/**
	 * 商品情報をログ出力する。
	 */
	protected function logCommodityInfo() {
		$log = $this->log->getMethodLog(__METHOD__);
		if ($this->idmap != null && $this->getIdlistSize() > 0) {
			for ($i = 0; $i < $this->getIdlistSize(); $i++) {
				$log->info("COMMODITY_ID[" . $i + 1 . "] = " . $this->getIdmap($i + 1));
			}
		} else {
			$log->info("COMMODITY_ID is Empty");
		}

		if ($this->unitmap != null && $this->getUnitlistSize() > 0) {
			for ($i = 0; $i < $this->getUnitlistSize(); $i++) {
				$log->info("COMMODITY_UNIT[" . $i + 1 . "] = " . $this->getUnitmap($i + 1));
			}
		} else {
			$log->info("COMMODITY_UNIT is Empty");
		}

		if ($this->nummap != null && $this->getNumlistSize() > 0) {
			for ($i = 0; $i < $this->getNumlistSize(); $i++) {
				$log->info("COMMODITY_NUM[" . $i + 1 . "] = " . $this->getNummap($i + 1));
			}
		} else {
			$log->info("COMMODITY_NUM is Empty");
		}

		if ($this->namemap != null && $this->getNamelistSize() > 0) {
			for ($i = 0; $i < $this->getNamelistSize(); $i++) {
				$log->info("COMMODITY_NAME[" . $i + 1 . "] = " . $this->getNamemap($i + 1));
			}
		} else {
			$log->info("COMMODITY_NAME is Empty");
		}

		if ($this->janCodemap != null && $this->getJanCodelistSize() > 0) {
			for ($i = 0; $i < $this->getJanCodelistSize(); $i++) {
				$log->info("JAN_CODE[" . $i + 1 . "] = " . $this->getJanCodemap($i + 1));
			}
		} else {
			$log->info("JAN_CODE is Empty");
		}
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