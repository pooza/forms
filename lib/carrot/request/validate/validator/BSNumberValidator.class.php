<?php
/**
 * @package org.carrot-framework
 * @subpackage request.validate.validator
 */

/**
 * 数値バリデータ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSNumberValidator.class.php 1436 2009-09-05 13:03:25Z pooza $
 */
class BSNumberValidator extends BSValidator {

	/**
	 * 初期化
	 *
	 * @access public
	 * @param string[] $parameters パラメータ配列
	 */
	public function initialize ($parameters = array()) {
		$this['max'] = null;
		$this['max_error'] = '値が大きすぎます。';
		$this['min'] = null;
		$this['min_error'] = '値が小さすぎます。';
		$this['nan_error'] = '数値を入力して下さい。';
		return parent::initialize($parameters);
	}

	/**
	 * 実行
	 *
	 * @access public
	 * @param mixed $value バリデート対象
	 * @return boolean 妥当な値ならばTrue
	 */
	public function execute ($value) {
		if (!is_numeric($value)) {
			$this->error = $this['nan_error'];
			return false;
		}

		$min = $this['min'];
		if (!!$min && ($value < $min)) {
			$this->error = $this['min_error'];
			return false;
		}

		$max = $this['max'];
		if (!!$max && ($max < $value)) {
			$this->error = $this['max_error'];
			return false;
		}

		return true;
	}
}

/* vim:set tabstop=4: */
