<?php
/**
 * @package org.carrot-framework
 * @subpackage request.validate.validator
 */

/**
 * 必須バリデータ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSEmptyValidator.class.php 1335 2009-07-18 09:49:09Z pooza $
 */
class BSEmptyValidator extends BSValidator {

	/**
	 * 初期化
	 *
	 * @access public
	 * @param string[] $parameters パラメータ配列
	 */
	public function initialize ($parameters = array()) {
		$this['required_msg'] = '空欄です。';
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
		if (self::isEmpty($value)) {
			$this->error = $this['required_msg'];
			return false;
		}
		return true;
	}

	/**
	 * フィールド値は空欄か？
	 *
	 * @access public
	 * @return boolean フィールド値が空欄ならばTrue
	 * @static
	 */
	static public function isEmpty ($value) {
		if (BSArray::isArray($value)) {
			$value = new BSArray($value);
			if ($value['is_file']) {
				return BSString::isBlank($value['name']);
			} else {
				return ($value->count() == 0);
			}
		} else {
			return BSString::isBlank($value);
		}
	}
}

/* vim:set tabstop=4: */
