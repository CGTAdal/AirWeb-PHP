<?php

/**
 * class CommodityDetail
 * 商品情報クラス
 * jp.co.veritrans.card.web.ws.bean.CommodityDetailより移植
 *
 * @copyright
 */
class CommodityDetail {
	/*
	 * commodityId
	* @var string
	*/

	private $commodityId;
	/*
	 * janCode
	* @var string
	*/
	private $janCode;
	/*
	 * commodityName
	* @var string
	*/
	private $commodityName;
	/*
	 * commodityUnit
	* @var int
	*/
	private $commodityUnit;
	/*
	 * commodityNum
	* @var int
	*/
	private $commodityNum;

	/*
	 * setCommodityId
	* @param string
	*/

	public function setCommodityId($commodityId) {
		$this->commodityId = $commodityId;
	}

	/*
	 * setJanCode
	* @param string
	*/

	public function setJanCode($janCode) {
		$this->janCode = $janCode;
	}

	/*
	 * setCommodityName
	* @param string
	*/

	public function setCommodityName($commodityName) {
		$this->commodityName = $commodityName;
	}

	/*
	 * setCommodityUnit
	* @param int
	*/

	public function setCommodityUnit($commodityUnit) {
		$this->commodityUnit = $commodityUnit;
	}

	/*
	 * setCommodityNum
	* @param int
	*/

	public function setCommodityNum($commodityNum) {
		$this->commodityNum = $commodityNum;
	}

	/*
	 * getCommodityId
	* @return string
	*/

	public function getCommodityId() {
		return $this->commodityId;
	}

	/*
	 * getJanCode
	* @return string
	*/

	public function getJanCode() {
		return $this->janCode;
	}

	/*
	 * getCommodityName
	* @return string
	*/

	public function getCommodityName() {
		return $this->commodityName;
	}

	/*
	 * getCommodityUnit
	* @return int
	*/

	public function getCommodityUnit() {
		return $this->commodityUnit;
	}

	/*
	 * getCommodityNum
	* @return int
	*/

	public function getCommodityNum() {
		return $this->commodityNum;
	}

	/*
	 * constructur
	*/

	public function __construct($commodityId = null, $janCode = null, $commodityName = null, $commodityUnit = null, $commodityNum = null) {
		$this->setCommodityId($commodityId);
		$this->setJanCode($janCode);
		$this->setCommodityName($commodityName);
		$this->setCommodityUnit($commodityUnit);
		$this->setCommodityNum($commodityNum);
	}

}

?>