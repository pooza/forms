<?php
/**
 * @package jp.co.commons.forms
 */

/**
 * 日付フィールド
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class DateField extends Field {

	/**
	 * バリデータ登録
	 *
	 * @access public
	 */
	public function registerValidators () {
		parent::registerValidators();
		BSValidateManager::getInstance()->register($this->getName(), new BSDateValidator);
	}
}

/* vim:set tabstop=4 */