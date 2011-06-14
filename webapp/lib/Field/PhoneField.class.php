<?php
/**
 * @package jp.co.b-shock.forms
 */

/**
 * 電話番号フィールド
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class PhoneField extends Field {

	/**
	 * バリデータ登録
	 *
	 * @access public
	 */
	public function registerValidators () {
		parent::registerValidators();
		BSValidateManager::getInstance()->register(
			$this->getName(),
			new BSPhoneNumberValidator(array('loose' => true))
		);
	}
}

/* vim:set tabstop=4 */