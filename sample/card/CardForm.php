<?php

// 共通インクルードファイル
require_once('common.php');

/**
 * class CardForm
 * 入力フォームクラス
 * jp.co.veritrans.sample.server.action.card.CardFormより移植
 */
class CardForm extends CommodityForm {

	/**
	 * ログクラス
	 */
	private $log = null;

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		parent::__construct();
		$this->setSettlementType(AW_SETTLEMENT_TYPE_CARD);
		$this->log = new Logger(__CLASS__);
	}

	/**
	 * ActionFormのabstruct method
	 * エラーチェック
	 * @return array() エラーメッセージ（配列）
	 */
	public function validate() {
		$log = $this->log->getMethodLog(__METHOD__);
		$errors = array();

		return $errors;
	}

}

?>