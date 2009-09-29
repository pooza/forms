<?php
/**
 * @package org.carrot-framework
 * @subpackage request.validate.validator
 */

/**
 * 英字項目バリデータ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSEnglishValidator.class.php 1485 2009-09-14 11:40:21Z pooza $
 */
class BSEnglishValidator extends BSRegexValidator {

	/**
	 * 初期化
	 *
	 * @access public
	 * @param string[] $parameters パラメータ配列
	 */
	public function initialize ($parameters = array()) {
		$this['match'] = true;
		$this['match_error'] = '使用出来ない文字が含まれています。';
		$this['pattern'] = '^[\\n[:ascii:]]*$';
		return BSValidator::initialize($parameters);
	}
}

/* vim:set tabstop=4: */
