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
	protected function getFileClass () {
		return 'BSImageFile';
	}

	/**
	 * バリデータ登録
	 *
	 * @access public
	 */
	public function registerValidators () {
		parent::registerValidators();

		$params = new BSArray;
		$validator = new BSImageValidator;
		$server = BSController::getInstance()->getHost();
		if ($file = BSConfigManager::getConfigFile('validator/' . $server->getName())) {
			$config = new BSArray(BSConfigManager::getInstance()->compile($file));
			$params->setParameters($config['image']);
			$validator->initialize($params);
		}

		BSValidateManager::getInstance()->register($this->getName(), $validator);
	}

	/**
	 * 全てのファイル属性
	 *
	 * @access protected
	 * @return BSArray ファイル属性の配列
	 */
	protected function getFullAttributes () {
		$values = parent::getFullAttributes();
		$values['is_image'] = true;
		return $values;
	}
}

/* vim:set tabstop=4 */