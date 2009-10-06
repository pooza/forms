<?php
/**
 * @package jp.co.commons.forms
 */

/**
 * 同意フィールド
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class AgreementField extends Field {

	/**
	 * バリデータ登録
	 *
	 * @access public
	 */
	public function registerValidators () {
		$params = array('required_msg' => 'ご同意下さい。');
		BSValidateManager::getInstance()->register(
			$this->getName(),
			new BSEmptyValidator($params)
		);
	}
}

/* vim:set tabstop=4 */