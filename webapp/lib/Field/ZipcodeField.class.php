<?php
/**
 * @package jp.co.b-shock.forms
 */

/**
 * 郵便番号フィールド
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class ZipcodeField extends Field {

	/**
	 * バリデータ登録
	 *
	 * @access public
	 */
	public function registerValidators () {
		parent::registerValidators();
		BSValidateManager::getInstance()->register(
			$this->getName(),
			new BSZipcodeValidator(array('address' => false))
		);
	}
}

/* vim:set tabstop=4 */