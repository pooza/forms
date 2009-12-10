<?php
/**
 * @package jp.co.commons.forms
 */

/**
 * 画像フィールド
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class ImageField extends FileField {

	/**
	 * ファイルのクラスを返す
	 *
	 * @access public
	 * @return string ファイルのクラス
	 */
	protected function getFileClassName () {
		return 'BSImageFile';
	}

	/**
	 * バリデータ登録
	 *
	 * @access public
	 */
	public function registerValidators () {
		parent::registerValidators();
		BSValidateManager::getInstance()->register($this->getName(), new BSImageValidator);
	}
}

/* vim:set tabstop=4 */