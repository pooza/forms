<?php
/**
 * @package jp.co.commons.forms
 */

/**
 * ファイルフィールド
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class FileField extends Field {

	/**
	 * バリデータ登録
	 *
	 * @access public
	 */
	public function registerValidators () {
		parent::registerValidators();
		BSValidateManager::getInstance()->register($this->getName(), new BSFileValidator);
	}
}

/* vim:set tabstop=4 */