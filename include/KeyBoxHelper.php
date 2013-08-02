<?php

// 共通インクルードファイル
require_once('common.php');

/**
 * orderIdをキーにデータ管理を行うヘルパークラス
 * ファイルには配列で格納するが、外部とはKeyBoxクラスでアクセスする
 *
 * 注意：
 * 複数のorderIdからの同時アクセスには対応していません。
 */
class KeyBoxHelper {

	/**
	 * 読み込んだKeyBox
	 * 処理毎に再読み込みを行う
	 */
	private $keyBox = array();
	/**
	 * ログクラス
	 */
	private $log = null;

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		$this->log = new Logger(__CLASS__);
	}

	/**
	 * KeyBoxをファイルに書き出す
	 */
	public function setKey(KeyBox $keyBox) {
		$log = $this->log->getMethodLog(__METHOD__);
		$this->loadKeyBox();
		$orderId = $keyBox->getOrderId();
		$this->keybox[$orderId] = $keyBox->getKeyBox();
		$this->saveKeyBox();
	}

	/**
	 * 指定OrderIdのKeyBoxをファイルから読み込む
	 */
	public function getKey($orderId) {
		$log = $this->log->getMethodLog(__METHOD__);
		$keyBox = new KeyBox();
		$keyBox->setOrderId($orderId);
		if ($this->loadKeyBox()) {
			if (array_key_exists($orderId, $this->keybox)) {
				$keyBox->setKeyBox($orderId, $this->keybox[$orderId]);
			}
		}
		return $keyBox;
	}

	/**
	 * KeyBox全体をファイルから読み込む
	 */
	public function getKeyArray() {
		$keyArray = array();
		if ($this->loadKeyBox()) {
			foreach ($this->keybox as $orderId => $keybox) {
				$keyArray[$orderId] = new KeyBox($orderId, $keybox);
			}
		}
		return $keyArray;
	}

	/**
	 * KeyBoxの読み込み処理
	 */
	private function loadKeyBox() {
		$log = $this->log->getMethodLog(__METHOD__);
		try {
			if (file_exists(AW_KEYBOX_FILE)) {
				$ser_keybox = @ file_get_contents(AW_KEYBOX_FILE);
				$this->keybox = unserialize($ser_keybox);
				return true;
			}
		} catch (Exception $e) {
			$log->error('キーファイル読み込み失敗：' . $e->getMessage());
		}
		return false;
	}

	/**
	 * KeyBoxの書き出し処理
	 */
	private function saveKeyBox() {
		$log = $this->log->getMethodLog(__METHOD__);
		try {
			$ser_keybox = serialize($this->keybox);
			@ file_put_contents(AW_KEYBOX_FILE, $ser_keybox, LOCK_EX);
			return true;
		} catch (Exception $e) {
			$log->error('キーファイル書き出し失敗：' . $e->getMessage());
		}
		return false;
	}

}

?>