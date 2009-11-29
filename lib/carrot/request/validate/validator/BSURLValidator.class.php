<?php
/**
 * @package org.carrot-framework
 * @subpackage request.validate.validator
 */

/**
 * URLバリデータ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSURLValidator.class.php 1635 2009-11-27 09:49:03Z pooza $
 */
class BSURLValidator extends BSValidator {

	/**
	 * 初期化
	 *
	 * @access public
	 * @param string[] $parameters パラメータ配列
	 */
	public function initialize ($parameters = array()) {
		$this['net_error'] = '正しくありません。';
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
		try {
			if (!BSURL::getInstance($value)) {
				$this->error = $this['net_error'];
			}
		} catch (BSNetException $e) {
			$this->error = $this['net_error'];
		}
		return BSString::isBlank($this->error);
	}
}

/* vim:set tabstop=4: */
