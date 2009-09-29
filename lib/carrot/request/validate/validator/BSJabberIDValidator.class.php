<?php
/**
 * @package org.carrot-framework
 * @subpackage request.validate.validator
 */

/**
 * JabberIDバリデータ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSJabberIDValidator.class.php 1066 2009-04-17 07:25:12Z pooza $
 */
class BSJabberIDValidator extends BSRegexValidator {

	/**
	 * 初期化
	 *
	 * @access public
	 * @param string[] $parameters パラメータ配列
	 */
	public function initialize ($parameters = array()) {
		$this['match'] = true;
		$this['match_error'] = '正しいJabberIDではありません。';
		$this['pattern'] = BSJabberID::PATTERN;
		return BSValidator::initialize($parameters);
	}
}

/* vim:set tabstop=4: */
