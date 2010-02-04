<?php
/**
 * @package org.carrot-framework
 * @subpackage request.validate.validator
 */

/**
 * URLバリデータ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSURLValidator.class.php 1812 2010-02-03 15:15:09Z pooza $
 */
class BSURLValidator extends BSValidator {

	/**
	 * 初期化
	 *
	 * @access public
	 * @param string[] $params パラメータ配列
	 */
	public function initialize ($params = array()) {
		$this['net_error'] = '正しくありません。';
		$this['schemes'] = array('http', 'https');
		$this['scheme_error'] = sprintf(
			'スキーム(%s)が正しくありません。',
			join('|', $this['schemes'])
		);
		return BSValidator::initialize($params);
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
			if (!mb_ereg('https?://[-_.!~*\'()a-zA-Z0-9;/?:@&=+$,%#]+', $value)) {
				$this->error = $this['net_error'];
			}
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
