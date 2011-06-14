<?php
/**
 * @package jp.co.b-shock.forms
 */

/**
 * フリガナフィールド
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class ReadingField extends Field {

	/**
	 * バリデータ登録
	 *
	 * @access public
	 */
	public function registerValidators () {
		parent::registerValidators();
		BSValidateManager::getInstance()->register($this->getName(), new BSKanaValidator);
	}
}

/* vim:set tabstop=4 */