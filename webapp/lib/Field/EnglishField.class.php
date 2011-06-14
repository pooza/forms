<?php
/**
 * @package jp.co.b-shock.forms
 */

/**
 * 英数字フィールド
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class EnglishField extends Field {

	/**
	 * バリデータ登録
	 *
	 * @access public
	 */
	public function registerValidators () {
		parent::registerValidators();
		BSValidateManager::getInstance()->register($this->getName(), new BSEnglishValidator);
	}
}

/* vim:set tabstop=4 */