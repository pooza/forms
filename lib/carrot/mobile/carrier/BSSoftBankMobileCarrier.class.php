<?php
/**
 * @package org.carrot-framework
 * @subpackage mobile.carrier
 */

/**
 * SoftBank 携帯電話キャリア
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSSoftBankMobileCarrier.class.php 1016 2009-03-25 10:52:54Z pooza $
 */
class BSSoftBankMobileCarrier extends BSMobileCarrier {

	/**
	 * ドメインサフィックスを返す
	 *
	 * @access public
	 * @return string ドメインサフィックス
	 */
	public function getDomainSuffix () {
		return 'softbank.ne.jp';
	}

	/**
	 * キャリア名の別名を返す
	 *
	 * @access public
	 * @return BSArray 別名の配列
	 */
	public function getAltNames () {
		return new BSArray(array(
			'yahoo',
			'jphone',
			'vodafone',
			'vf',
		));
	}
}

/* vim:set tabstop=4: */
