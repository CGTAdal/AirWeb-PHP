<?php

// 共通インクルードファイル
require_once('common.php');
/*
 * class MerchantInfo
* マーチャント情報保持クラス
* マーチャント固有の設定値（マーチャントID等）はこのパラメータに初期値として登録する
*/

class MerchantInfo {

	/**
	 * マーチャントID
	 * @var String
	 */
	private $merchantID = AW_MERCHANT_ID;
	/**
	 * 取引ID
	 * @var String
	 */
	private $orderID = null;
	/**
	 * 決済方式
	 * @var String
	 * SETTLEMENT_TYPE_***のいずれかを指定
	 */
	private $settlementType = AW_SETTLEMENT_TYPE;
	/**
	 * マーチャントシークレット
	 * @var String
	 */
	private $merchantSecret = "SECRET";
	/**
	 * マーチャント認証鍵
	 * @var String
	 */
	private $merchantKey = "KEY";
	/**
	 * マーチャント側で作成したハッシュ
	 * @var String
	 */
	private $merchantHash = null;
	/**
	 * ブラウザ側暗号鍵
	 * @var String
	 */
	private $settlementKey1A = null;
	/**
	 * マーチャント側暗号鍵
	 * @var String
	 */
	private $settlementKey1B = null;
	/**
	 * SCD
	 * @var String
	 */
	private $scd = null;
	/**
	 * セッションID
	 * @var String
	 */
	private $sessionId = null;

	/**
	 * マーチャントIDの設定
	 * @param merchantID マーチャントID
	 */
	public function setMerchantID($merchantID) {
		$this->merchantID = $merchantID;
	}

	/**
	 * マーチャントIDの取得
	 * @return マーチャントID
	 */
	public function getMerchantID() {
		return $this->merchantID;
	}

	/**
	 * 取引IDの設定
	 * @param orderID 取引ID
	 */
	public function setOrderID($orderID) {
		$this->orderID = $orderID;
	}

	/**
	 * 取引IDの取得
	 * @return 取引ID
	 */
	public function getOrderID() {
		return $this->orderID;
	}

	/**
	 * 決済方法の設定
	 * @param settlementType 決済方法
	 */
	public function setSettlementType($settlementType) {
		$this->settlementType = $settlementType;
	}

	/**
	 * 決済方法の取得
	 * @return 決済方法
	 */
	public function getSettlementType() {
		return $this->settlementType;
	}

	/**
	 * マーチャントシークレットの設定
	 * @param merchantSecret マーチャントシークレット
	 */
	public function setMerchantSecret($merchantSecret) {
		$this->merchantSecret = $merchantSecret;
	}

	/**
	 * マーチャントシークレットの取得
	 * @return マーチャントシークレット
	 */
	public function getMerchantSecret() {
		return $this->merchantSecret;
	}

	/**
	 * マーチャント認証鍵の設定
	 * @param merchantKey マーチャント認証鍵
	 */
	public function setMerchantKey($merchantKey) {
		$this->merchantKey = $merchantKey;
	}

	/**
	 * マーチャント認証鍵の取得
	 * @return マーチャント認証鍵
	 */
	public function getMerchantKey() {
		return $this->merchantKey;
	}

	/**
	 * マーチャントハッシュの設定
	 * @param merchantHash マーチャントハッシュ
	 */
	public function setMerchantHash($merchantHash) {
		$this->merchantHash = $merchantHash;
	}

	/**
	 * マーチャントハッシュの取得
	 * @return マーチャントハッシュ
	 */
	public function getMerchantHash() {
		return $this->merchantHash;
	}

	/**
	 * ブラウザ側暗号鍵の設定
	 * @param settlementKey1A ブラウザ側暗号鍵
	 */
	public function setSettlementKey1A($settlementKey1A) {
		$this->settlementKey1A = $settlementKey1A;
	}

	/**
	 * ブラウザ暗号鍵の取得
	 * @return ブラウザ側暗号鍵
	 */
	public function getSettlementKey1A() {
		return $this->settlementKey1A;
	}

	/**
	 * マーチャント側暗号鍵の設定
	 * @param settlementKey1B マーチャント側暗号鍵
	 */
	public function setSettlementKey1B($settlementKey1B) {
		$this->settlementKey1B = $settlementKey1B;
	}

	/**
	 * マーチャント側暗号鍵の取得
	 * @return マーチャント側暗号鍵
	 */
	public function getSettlementKey1B() {
		return $this->settlementKey1B;
	}

	/**
	 * SCDの設定
	 * @param scd SCD
	 */
	public function setScd($scd) {
		$this->scd = $scd;
	}

	/**
	 * SCDの取得
	 * @return scd
	 */
	public function getScd() {
		return $this->scd;
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
	 * @param String $sessionId
	 */
	public function setSessionId($sessionId) {
		$this->sessionId = $sessionId;
	}

	/**
	 * 取引IDを自動生成する
	 * 現在日時＋ユニークIDで取引IDを自動生成する
	 * @return 生成した取引ID
	 */
	public function createOrderID() {
		// 取引IDアルゴリズムは必要に応じて修正
		$this->orderID = uniqid(date('YmdHis'));
		return $this->orderID;
	}

}

?>