<?php
/**
 * @package org.carrot-framework
 * @subpackage request.validate.validator
 */

/**
 * フリガナ項目バリデータ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSKanaValidator.class.php 1754 2010-01-14 11:04:40Z pooza $
 */
class BSKanaValidator extends BSRegexValidator {

	/**
	 * 初期化
	 *
	 * @access public
	 * @param string[] $params パラメータ配列
	 */
	public function initialize ($params = array()) {
		$this['match'] = true;
		$this['match_error'] = '使用出来ない文字が含まれています。';
		$this['pattern'] = "^[ぁ-んァ-ンヴー\\n[:digit:]]*$";
		return BSValidator::initialize($params);
	}
}

/* vim:set tabstop=4: */
