<?php
/**
 * @package jp.co.commons.forms
 */

/**
 * 郵便番号フィールド
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class ZipcodeField extends Field {

	/**
	 * バリデータ登録
	 *
	 * @access public
	 */
	public function registerValidators () {
		parent::registerValidators();
		BSValidateManager::getInstance()->register($this->getName(), new BSZipcodeValidator);
	}
}

/* vim:set tabstop=4 */