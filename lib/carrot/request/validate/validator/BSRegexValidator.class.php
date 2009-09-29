<?php
/**
 * @package org.carrot-framework
 * @subpackage request.validate.validator
 */

/**
 * 正規表現バリデータ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSRegexValidator.class.php 1469 2009-09-11 12:40:31Z pooza $
 */
class BSRegexValidator extends BSValidator {

	/**
	 * 初期化
	 *
	 * @access public
	 * @param string[] $parameters パラメータ配列
	 */
	public function initialize ($parameters = array()) {
		$this['match'] = true;
		$this['match_error'] = '正しくありません。';
		$this['pattern'] = null;
		parent::initialize($parameters);

		if (!$this['pattern']) {
			throw new BSValidateException('正規表現パターンが指定されていません。');
		}
		return true;
	}

	/**
	 * 実行
	 *
	 * @access public
	 * @param mixed $value バリデート対象
	 * @return boolean 妥当な値ならばTrue
	 */
	public function execute ($value) {
		$matched = !!mb_ereg($this['pattern'], $value);
		if (($this['match'] && !$matched) || (!$this['match'] && $matched)) {
			$this->error = $this['match_error'];
			return false;
		}
		return true;
	}
}

/* vim:set tabstop=4: */
