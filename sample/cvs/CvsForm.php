<?php

// 共通インクルードファイル
require_once('common.php');

/**
 * class CvsForm
 * 入力フォームクラス
 * jp.co.veritrans.sample.server.action.cvs.CvsFormより移植
 */
class CvsForm extends CommodityForm {

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
	 * ActionFormのabstruct method
	 * エラーチェック
	 * @return array() エラーメッセージ（配列）
	 */
	public function validate() {
		$log = $this->log->getMethodLog(__METHOD__);
		$errors = array();

		$userSettlementSubType = $this->getSettlementSubType();
		if (!$this->IsEmpty($userSettlementSubType)) {
			$settlementSubTypeList = array(CVS_SUBTYPE_711, CVS_SUBTYPE_LAWSON, CVS_SUBTYPE_FAMILYMART, CVS_SUBTYPE_DAILY, CVS_SUBTYPE_MINISTOP, CVS_SUBTYPE_SEICO, CVS_SUBTYPE_SUNKUS);
			if (!in_array($userSettlementSubType, $settlementSubTypeList)) {
				$errors[] = $this->actionMessage("error.cvs.subtype.invalid");
			}
		}

		$parentErrors = parent::validate();
		$count = count($parentErrors);
		for ($i = 0; $i < $count; $i++) {
			$errors[] = $parentErrors[$i];
		}

		return $errors;
	}

}

?>