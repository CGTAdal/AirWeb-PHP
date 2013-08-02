<?php

/*
 * ConfirmActionManager.php
*
* 個人情報送信処理クラス
*/

/**
 * ConfirmActionManager class
 *
 * 入力情報の送信を行う
 * jp.co.veritrans.sample.ConfirmActionManagerより移植
 */
class ConfirmActionManager {

	/**
	 * マーチャント情報
	 * @var class MerchantInfo
	 */
	private $merchant = null;
	/**
	 * 取得したブラウザキー
	 * @var string
	 */
	private $browserKey = null;
	/**
	 * 処理中に発生したメッセージ
	 * @var string
	 */
	private $message = array();
	/**
	 * ログクラス
	 */
	private $log = null;

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		$this->log = new Logger(__CLASS__);
		$this->merchant = new MerchantInfo();
	}

	/**
	 * AWへ個人情報、商品情報を送信する
	 * @param form 入力フォーム
	 * @return 送信結果（true/false）
	 */
	public function execute($form) {
		$log = $this->log->getMethodLog(__METHOD__);
		$log->info("送信処理開始");
		$purchaseData = $this->getPurchaseData($form);
		// HTTP POST送信
		$result = $this->sendPOST($purchaseData);

		return $result;
	}

	/**
	 * 送信情報をPurchaseDataに登録する
	 * @param CommodityDetail $form
	 * @return PurchaseData
	 */
	private function getPurchaseData($form) {
		$log = $this->log->getMethodLog(__METHOD__);
		$log->debug("送信情報作成開始");

		$data = new PurchaseData();
		$ch = new HashCodeCreater();

		// 商品情報クラスを生成
		$commodityDetails = $this->setCommodityDetail($form);

		// 全角文字が入るフィールドはAW用文字コードに変換して登録する
		// メールアドレス
		$data->setMailAddress($this->getSorpCode($form->getMailAddress()));

		// 名前１
		$data->setName1($this->getSorpCode($form->getName1()));

		// 名前２
		$data->setName2($this->getSorpCode($form->getName2()));

		// カナ１
		$data->setKana1($this->getSorpCode($form->getKana1()));

		// カナ２
		$data->setKana2($this->getSorpCode($form->getKana2()));

		// 郵便番号
		$zipCode = null;
		if (strlen($form->getZipCode1()) > 0) {
			if (strlen($form->getZipCode2()) > 0) {
				$zipCode = $form->getZipCode1() . "-" . $form->getZipCode2();
			} else {
				$zipCode = $form->getZipCode1();
			}
		} else {
			if (strlen($form->getZipCode2()) > 0) {
				$zipCode = $form->getZipCode2();
			}
		}
		$data->setZipCode($this->getSorpCode($zipCode));

		// 住所１
		$data->setAddress1($this->getSorpCode($form->getAddress1()));

		// 住所２
		$data->setAddress2($this->getSorpCode($form->getAddress2()));

		// 住所３
		$data->setAddress3($this->getSorpCode($form->getAddress3()));

		// 電話番号
		$data->setTelephoneNo($this->getSorpCode($form->getTelephoneNo()));

		// 生年月日
		$data->setBirthday($this->getSorpCode($form->getBirthday()));

		// 性別
		$data->setSex($this->getSorpCode($form->getSex()));

		// 決済方法
		// ユーザが指定した決済種別
		$userSettlementType = $form->getSettlementType();
		// 利用可能な決済種別
		$settlementTypeList = array(AW_SETTLEMENT_TYPE_CARD, AW_SETTLEMENT_TYPE_CVS);
		// 利用可能な決済種別が指定されている場合、指定された種別をセット
		if (in_array($userSettlementType, $settlementTypeList)) {
			$log->debug("決済種別をユーザが指定：" . $userSettlementType);
			$data->setSettlementType($this->getSorpCode($userSettlementType));
		} else {
			// 決済種別はAWサイトで選択
			$data->setSettlementType($this->getSorpCode(AW_SETTLEMENT_TYPE_FREE));
		}

		// 決済方法サブタイプ
		$data->setSettlementSubType($this->getSorpCode($form->getSettlementSubType()));

		// マーチャントID
		$data->setMerchantId($this->getSorpCode($this->merchant->getMerchantID()));

		// 取引ID
		$data->setOrderId($this->getSorpCode($this->merchant->createOrderID()));

		// SessionID
		$data->setSessionId($this->getSorpCode(session_id()));

		// 購入金額
		$data->setAmount($this->getSorpCode($form->getAmount()));

		// 送料金額
		$data->setShippingAmount($this->getSorpCode($form->getShippingAmount()));

		// カード売上フラグ
		$data->setCardCaptureFlag($this->getSorpCode($form->getCardCaptureFlag()));

		// 支払期限
		$data->setTimelimitOfPayment($this->getSorpCode($form->getTimelimitOfPayment()));

		// マーチャント生成ハッシュ値
		// ハッシュコードを生成
		$hashCode = $ch->getHash($data->getMerchantId(), $data->getSettlementType(), $data->getOrderId(), $data->getAmount());
		$data->setMerchantHash($this->getSorpCode($hashCode));
		$log->debug("Hash: {" . $data->getMerchantId() . ", " . $data->getSettlementType() . ", " . $data->getOrderId() . ", " . $data->getAmount() . "} ->{" . $data->getMerchantHash() . "}");

		// 決済完了後戻りURL
		$data->setFinishPaymentReturnUrl($this->getSorpCode(FINISH_PAYMENT_RETURN_URL));
		// 決済結果通知先URL
		$data->setFinishPaymentAccessUrl($this->getSorpCode(FINISH_PAYMENT_ACCESS_URL));

		// 商品情報を登録
		if (count($commodityDetails) > 0) {
			$data->setCommodityDetails($commodityDetails);
		}
		// 生成されたハッシュをマーチャント情報に登録する
		$this->merchant->setMerchantHash($data->getMerchantHash());
		$this->merchant->setSessionId(session_id());
		return $data;
	}

	/**
	 * 購入商品情報クラスをセット
	 * @return 購入商品情報
	 */
	private function setCommodityDetail(CommodityForm $commForm) {
		$log = $this->log->getMethodLog(__METHOD__);
		$log->info("購入商品情報クラスをセット");

		$commodityDetails = array();
		// 商品数
		$listsize = $commForm->getNamelistSize();
		for ($idx = 0; $idx < $listsize; $idx++) {
			$setId = null;
			if ($commForm->getIdmap($idx + 1) == null || $commForm->getIdlistSize() == 0) {
				$setId = DUMMY_COMMODITY_ID . $idx + 1;
			} else {
				$setId = $commForm->getIdmap($idx + 1);
			}

			$setJanCode = null;
			if ($commForm->getJanCodemap($idx + 1) == null || $commForm->getJanCodelistSize() == 0) {
				$setJanCode = DUMMY_COMMODITY_JANCODE . $idx + 1;
			} else {
				$setJanCode = $commForm->getJanCodemap($idx + 1);
			}

			// 商品情報を登録
			$commodityDetails[] = new CommodityDetail(
					$this->getSorpCode($setId),
					$this->getSorpCode($setJanCode),
					$this->getSorpCode($commForm->getNamemap($idx + 1)),
					$this->getSorpCode($commForm->getUnitmap($idx + 1)),
					$this->getSorpCode($commForm->getNummap($idx + 1)));
		}
		$log->debug("購入商品件数：" . strval(count($commodityDetails)));
		return $commodityDetails;
	}

	/**
	 * 文字コードをAW送信用に変換する
	 */
	protected function getSorpCode($value) {
		//return $value;
		return urlencode(mb_convert_encoding($value, AW_SERVER_ENCODE, AW_BASE_ENCODE));
	}

	/**
	 * 文字コードをAW受信用から変換する
	 */
	protected function getBaseCode($value) {
		return urldecode(mb_convert_encoding($value, AW_BASE_ENCODE, AW_SERVER_ENCODE));
	}

	/**
	 * HTTP POSTで送信する
	 */
	private function sendPOST(PurchaseData $data) {
		$log = $this->log->getMethodLog(__METHOD__);
		$log->info("HTTP POST送信処理開始");

		$query = array();
		$ch = new HashCodeCreater();

		// POSTリクエストデータを作成
		// メールアドレス
		$query['MAILADDRESS'] = $data->getMailaddress();
		// 名前１
		$query['NAME1'] = $data->getName1();
		// 名前２
		$query['NAME2'] = $data->getName2();
		// カナ１
		$query['KANA1'] = $data->getKana1();
		// カナ２
		$query['KANA2'] = $data->getKana2();
		// 郵便番号
		$query['ZIP_CODE'] = $data->getZipCode();
		// 住所１
		$query['ADDRESS1'] = $data->getAddress1();
		// 住所２
		$query['ADDRESS2'] = $data->getAddress2();
		// 住所３
		$query['ADDRESS3'] = $data->getAddress3();
		// 電話番号
		$query['TELEPHONE_NO'] = $data->getTelephoneNo();
		// 生年月日
		$query['BIRTHDAY'] = $data->getBirthday();
		// 性別
		$query['SEX'] = $data->getSex();
		// 決済方法
		$query['SETTLEMENT_TYPE'] = $data->getSettlementType();
		// 決済方法サブタイプ
		$query['SETTLEMENT_SUB_TYPE'] = $data->getSettlementSubType();
		// マーチャントID
		$query['MERCHANT_ID'] = $data->getMerchantID();
		// 取引ID
		$query['ORDER_ID'] = $data->getOrderID();
		// SessionID
		$query['SESSION_ID'] = $data->getSessionId();
		// 購入金額
		$query['AMOUNT'] = $data->getAmount();
		// 送料金額
		$query['SHIPPING_AMOUNT'] = $data->getShippingAmount();
		// カード売上フラグ
		$query['CARD_CAPTURE_FLAG'] = $data->getCardCaptureFlag();
		// カード売上フラグ
		$query['DDD_ENABLE_FLAG'] = "0";
		// 支払期限
		$query['TIMELIMIT_OF_PAYMENT'] = $data->getTimelimitOfPayment();
		// マーチャント生成ハッシュ値
		$query['MERCHANTHASH'] = $data->getMerchantHash();
		// 決済完了後戻りURL
		$query['FINISH_PAYMENT_RETURN_URL'] = $data->getFinishPaymentReturnUrl();
		$query['FINISH_PAYMENT_ACCESS_URL'] = $data->getFinishPaymentAccessUrl();
		// 商品情報を登録する
		$commodityDetails = $data->getCommodityDetails();
		if (is_array($commodityDetails) && count($commodityDetails) > 0) {
			$query['COMMODITY_ID'] = array();
			$query['COMMODITY_UNIT'] = array();
			$query['COMMODITY_NUM'] = array();
			$query['COMMODITY_NAME'] = array();
			$query['JAN_CODE'] = array();

			foreach ($commodityDetails as $detail) {
				$query['COMMODITY_ID'][] = $detail->getCommodityId();
				$query['COMMODITY_UNIT'][] = $detail->getCommodityUnit();
				$query['COMMODITY_NUM'][] = $detail->getCommodityNum();
				$query['COMMODITY_NAME'][] = $detail->getCommodityName();
				$query['JAN_CODE'][] = $detail->getJanCode();
			}
		}

		$log->debug("POST送信開始");
		// HTTP POSTで送信する
		$http = new HttpRequest(AW_HTTP_POST_URI, HttpRequest::REQ_HTTP_POST);
		$http->setPostData($query, AW_SERVER_ENCODE);
		$code = $http->sendRequest();

		// 正常終了（200 OK）が返ったか
		if (intval($code) == 200) {
			$log->debug("レスポンス解析");
			$merchantKey = null;
			$browserKey = null;
			$scd = null;
			$error_message = null;
			// レスポンスデータからマーチャントキー、ブラウザキーを取得
			$resBody = $http->getResponseBody();
			$bgodyLine = explode("\n", $resBody);
			foreach ($bgodyLine as $line) {
				$log->info("返信:" . $this->getBaseCode($line));
				if (preg_match('/^MERCHANT_ENCRYPTION_KEY=(.+)/', $line, $match)) {
					$merchantKey = $match[1];
				} elseif (preg_match('/^BROWSER_ENCRYPTION_KEY=(.+)/', $line, $match)) {
					$browserKey = $match[1];
					//} elseif (preg_match('/^SCD=(.+)/', $line, $match)) {
					//	$scd = $match[1];
				} elseif (preg_match('/^ERROR_MESSAGE=(.+)/', $line, $match)) {
					$error_message = $match[1];
				}
			}
			// 両方取れたらOK。SCDはカードでセキュリティコードが入力された場合のみ
			if (!is_null($merchantKey) && !is_null($browserKey)) {
				$this->merchant->setSettlementKey1B($merchantKey);
				$this->merchant->setSettlementKey1A($browserKey);
				//$this->merchant->setScd($scd);
				$log->info("キーが取得できた");
				return true;
			} elseif (!is_null($error_message)) {
				$this->message[] = $str = "AWeb:" . $this->getBaseCode($error_message);
				return false;
			}
			$log->warn("キーが取得できない");
			$this->message[] = "決済処理が完了しませんでした";
		} else {
			$log->error("送信失敗 HTTP Code:" . strval($code));
			$this->message[] = "決済サーバに接続できません";
		}
		return false;
	}

	/**
	 * マーチャント情報を取得
	 */
	public function getMerchantInfo() {
		return $this->merchant;
	}

	/**
	 * エラーメッセージを取得
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * マーチャントキーを格納する
	 */
	public function setMerchantKey() {
		$log = $this->log->getMethodLog(__METHOD__);
		$keyHelper = new KeyBoxHelper();
		$keyBox = $keyHelper->getKey($this->merchant->getOrderID());
		$keyBox->setSettlementKey1B($this->merchant->getSettlementKey1B());
		$keyBox->setSessionId($this->merchant->getSessionId());
		$keyHelper->setKey($keyBox);
		$log->info("KeyBoxデータ登録 取引ID：" . $keyBox->getOrderId());
		$log->info("KeyBoxデータ登録 マーチャント暗号鍵：" . $keyBox->getSettlementKey1B());
		$log->info("KeyBoxデータ登録 セッションID：" . $keyBox->getSessionId());
	}

}

?>