<?php
/**
 * @package org.carrot-framework
 * @subpackage request.validate.validator
 */

/**
 * URLバリデータ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSURLValidator.class.php 1685 2009-12-14 07:30:31Z pooza $
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
		$this['schemes'] = array('http', 'https');
		$this['scheme_error'] = sprintf(
			'スキーム(%s)が正しくありません。',
			join('|', $this['schemes'])
		);
		return BSValidator::initialize($parameters);
	}

	private function getSchemes () {
		return new BSArray($this['schemes']);
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

			if (!$url = BSURL::getInstance($value)) {
				$this->error = $this['net_error'];
			}
			if (!$this->getSchemes()->isContain($url['scheme'])) {
				$this->error = $this['scheme_error'];
			}
		} catch (BSNetException $e) {
			$this->error = $this['net_error'];
		}
		return BSString::isBlank($this->error);
	}
}

/* vim:set tabstop=4: */
