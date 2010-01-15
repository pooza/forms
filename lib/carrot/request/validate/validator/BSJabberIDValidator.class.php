<?php
/**
 * @package org.carrot-framework
 * @subpackage request.validate.validator
 */

/**
 * JabberIDバリデータ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSJabberIDValidator.class.php 1754 2010-01-14 11:04:40Z pooza $
 */
class BSJabberIDValidator extends BSRegexValidator {

	/**
	 * 初期化
	 *
	 * @access public
	 * @param string[] $params パラメータ配列
	 */
	public function initialize ($params = array()) {
		$this['match'] = true;
		$this['match_error'] = '正しいJabberIDではありません。';
		$this['pattern'] = BSJabberID::PATTERN;
		return BSValidator::initialize($params);
	}
}

/* vim:set tabstop=4: */
