<?php
/**
 * @package org.carrot-framework
 * @subpackage request.validate.validator
 */

/**
 * 郵便番号バリデータ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSZipcodeValidator.class.php 2454 2011-01-12 03:48:11Z pooza $
 */
class BSZipcodeValidator extends BSRegexValidator {
	const PATTERN = '^([[:digit:]]{3})-([[:digit:]]{4})$';

	/**
	 * 初期化
	 *
	 * @access public
	 * @param string[] $params パラメータ配列
	 */
	public function initialize ($params = array()) {
		$this['match'] = true;
		$this['match_error'] = '正しくありません。';
		$this['pattern'] = self::PATTERN;
		$this['fields'] = array();
		return BSValidator::initialize($params);
	}

	/**
	 * 実行
	 *
	 * @access public
	 * @param mixed $value バリデート対象
	 * @return boolean 妥当な値ならばTrue
	 */
	public function execute ($value) {
		if ($fields = $this['fields']) {
			$values = new BSArray;
			foreach ($fields as $field) {
				$values[] = $this->request[$field];
			}
			$value = $values->join('-');
		}
		return parent::execute($value);
	}
}

/* vim:set tabstop=4: */
