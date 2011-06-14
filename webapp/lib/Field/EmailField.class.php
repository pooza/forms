<?php
/**
 * @package jp.co.b-shock.forms
 */

/**
 * メールアドレスフィールド
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class EmailField extends Field {

	/**
	 * バリデータ登録
	 *
	 * @access public
	 */
	public function registerValidators () {
		parent::registerValidators();
		BSValidateManager::getInstance()->register($this->getName(), new BSMailAddressValidator);
	}
}

/* vim:set tabstop=4 */