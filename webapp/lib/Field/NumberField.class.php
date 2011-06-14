<?php
/**
 * @package jp.co.b-shock.forms
 */

/**
 * 数値フィールド
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class NumberField extends Field {

	/**
	 * バリデータ登録
	 *
	 * @access public
	 */
	public function registerValidators () {
		parent::registerValidators();
		BSValidateManager::getInstance()->register($this->getName(), new BSNumberValidator);
	}
}

/* vim:set tabstop=4 */