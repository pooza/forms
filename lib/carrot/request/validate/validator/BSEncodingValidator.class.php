<?php
/**
 * @package org.carrot-framework
 * @subpackage request.validate.validator
 */

/**
 * エンコード名バリデータ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSEncodingValidator.class.php 1335 2009-07-18 09:49:09Z pooza $
 */
class BSEncodingValidator extends BSValidator {

	/**
	 * 初期化
	 *
	 * @access public
	 * @param string[] $parameters パラメータ配列
	 */
	public function initialize ($parameters = array()) {
		$this['match_error'] = '利用できないエンコード名です。';
		return BSValidator::initialize($parameters);
	}

	/**
	 * 実行
	 *
	 * @access public
	 * @param mixed $value バリデート対象
	 * @return boolean 妥当な値ならばTrue
	 */
	public function execute ($value) {
		if (BSString::isBlank(mb_preferred_mime_name($value))) {
			$this->error = $this['match_error'];
			return false;
		}
		return true;
	}
}

/* vim:set tabstop=4: */
