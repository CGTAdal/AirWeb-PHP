<?php

// 共通インクルードファイル
require_once('common.php');

/**
 * class AWKeyValidate
 * AWからのリクエストパラメータのチェックと、キーの更新を行う
 */
class AWKeyValidate {

	/**
	 * ログクラス
	 */
	private $log = null;
	private $resultForm = null;

	/*
	 * コンストラクタ
	* @param $awPost TVWからのリクエストパラメータ
	*/

	public function __construct($awPost) {
		$this->log = new Logger(__CLASS__);
		$log = $this->log->getMethodLog(__METHOD__);
		// リクエストパラメータを登録する
		$this->resultForm = new ResultCheckForm();
		$this->resultForm->setRequestArray($awPost);
		$log->debug("POSTデータ登録 取引ID：" . $this->resultForm->getOrderId());
		$log->debug("POSTデータ登録 ステータス：" . $this->resultForm->getMStatus());
		$log->debug("POSTデータ登録 エラーメッセージ：" . $this->resultForm->getMErrMsg());
		$log->debug("POSTデータ登録 結果コード：" . $this->resultForm->getvResultCode());
		$log->debug("POSTデータ登録 漢字氏名：" . $this->resultForm->getUserName());
		$log->debug("POSTデータ登録 カナ氏名：" . $this->resultForm->getUserNameKana());
		$log->debug("POSTデータ登録 メールアドレス：" . $this->resultForm->getMailAddress());
		$log->debug("POSTデータ登録 住所：" . $this->resultForm->getAddress());
		$log->debug("POSTデータ登録 性別：" . $this->resultForm->getSex());
		$log->debug("POSTデータ登録 電話番号：" . $this->resultForm->getTelephoneno());
		$log->debug("POSTデータ登録 郵便番号：" . $this->resultForm->getZipcode());
		$log->debug("POSTデータ登録 誕生日：" . $this->resultForm->getBirthday());
	}

	/**
	 * AWからのRequestの内容確認
	 */
	public function resultCheck() {
		$log = $this->log->getMethodLog(__METHOD__);
		$log->debug("チェック開始");

		$validate = $this->resultForm->validate();
		// NULLチェック
		if (count($validate) > 0) {
			$log->info("チェックNG");
			return false;
		}

		// 登録されているマーチャント側暗号鍵情報を取得
		$keyHelper = new KeyBoxHelper();
		$keyBox = $keyHelper->getKey($this->resultForm->getOrderId());
		// 個人情報送信時に取得したマーチャントキーがあるか
		$key1B = $keyBox->getSettlementKey1B();
		if (is_null($key1B) || $key1B == '') {
			// キーが無い＝未登録の取引ID
			$log->warn("取引ID未登録, 取引ID=" . $this->resultForm->getOrderId());
			return false;
		} else {
			$mstatus = $keyBox->getMStatus();
			if (!is_null($mstatus) && $mstatus != '') {
				// ステータス登録済み
				$log->warn("ステータス登録済, 取引ID=" . $this->resultForm->getOrderId());
				return false;
			}
		}

		$log->info("チェックOK");
		return true;
	}

	/**
	 * クライアントから送信されてきたキーと、AWから送信されてきたキーが一致するかをチェック
	 */
	public function resultCrossCheck() {
		$log = $this->log->getMethodLog(__METHOD__);
		$log->debug("キー照合開始");
		if (is_null($this->resultForm->getOrderId())) {
			$log->info("取引IDが空");
			return false;
		}
		// 登録されているマーチャント側暗号鍵情報を取得
		$keyHelper = new KeyBoxHelper();
		$keyBox = $keyHelper->getKey($this->resultForm->getOrderId());

		// 個人情報送信時に取得したマーチャントキーがあるか
		$key1B = $keyBox->getSettlementKey1B();
		if (is_null($key1B) || $key1B == '') {
			// キーが無い＝未登録の取引ID
			$log->info("取引ID未登録");
			return false;
		}

		$log->info("keyBox->getMStatus()=" . $keyBox->getMStatus());
		$log->info("keyBox->getvResultCode()=" . $keyBox->getvResultCode());
		$log->info("keyBox->getSessionId()=" . $keyBox->getSessionId());
		$log->info("this->resultForm->getMStatus()=" . $this->resultForm->getMStatus());
		$log->info("this->resultForm->getvResultCode()=" . $this->resultForm->getvResultCode());
		$log->info("this->resultForm->getSessionId()=" . $this->resultForm->getSessionId());

		// 取得したパラメータとクライアントからのキーを照合
		$result = 0;
		$result += ( (strcmp($keyBox->getMStatus(), $this->resultForm->getMStatus()) == 0 ) ? 1 : 0);
		$result += ( (strcmp($keyBox->getvResultCode(), $this->resultForm->getvResultCode()) == 0 ) ? 1 : 0);
		$result += ( (strcmp($keyBox->getSessionId(), $this->resultForm->getSessionId()) == 0 ) ? 1 : 0);

		if ($result == 3) {
			$log->info("照合OK");
			return true;
		} else {
			$log->info("照合NG");
			return false;
		}
	}

	/**
	 * マーチャント側暗号鍵情報を更新
	 */
	public function updateKeyBox() {
		$log = $this->log->getMethodLog(__METHOD__);
		$log->debug("キー更新開始");
		if (is_null($this->resultForm->getOrderId())) {
			$log->debug("取引ID未登録");
			return;
		}
		// 登録されているマーチャント側暗号鍵情報を取得
		$keyHelper = new KeyBoxHelper();
		$keyBox = $keyHelper->getKey($this->resultForm->getOrderId());
		// 取得したパラメータを登録
		$keyBox->setMStatus($this->resultForm->getMStatus());
		$keyBox->setMErrMsg($this->resultForm->getMErrMsg());
		$keyBox->setvResultCode($this->resultForm->getvResultCode());
		$keyBox->setUserName($this->resultForm->getUserName());
		$keyBox->setUserNameKana($this->resultForm->getUserNameKana());
		$keyBox->setMailAddress($this->resultForm->getMailAddress());
		$keyBox->setAddress($this->resultForm->getAddress());
		$keyBox->setSex($this->resultForm->getSex());
		$keyBox->setTelephoneno($this->resultForm->getTelephoneno());
		$keyBox->setZipcode($this->resultForm->getZipcode());
		$keyBox->setBirthday($this->resultForm->getBirthday());

		// マーチャント側暗号鍵情報を更新
		$keyHelper->setKey($keyBox);
		$log->info("keyBox->getMStatus()=" . $keyBox->getMStatus());
		$log->info("keyBox->getMErrMsg()=" . $keyBox->getMErrMsg());
		$log->info("keyBox->getvResultCode()=" . $keyBox->getvResultCode());
		$log->info("keyBox->getUserName()=" . $keyBox->getUserName());
		$log->info("keyBox->getUserNameKana()=" . $keyBox->getUserNameKana());
		$log->info("keyBox->getMailAddress()=" . $keyBox->getMailAddress());
		$log->info("keyBox->getAddress()=" . $keyBox->getAddress());
		$log->info("keyBox->getSex()=" . $keyBox->getSex());
		$log->info("keyBox->getTelephoneno()=" . $keyBox->getTelephoneno());
		$log->info("keyBox->getZipcode()=" . $keyBox->getZipcode());
		$log->info("keyBox->getBirthday()=" . $keyBox->getBirthday());

		$log->info("キー更新完了");
	}

}

?>