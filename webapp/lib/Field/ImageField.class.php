<?php
/**
 * @package jp.co.b-shock.forms
 */

/**
 * 画像フィールド
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
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

		$params = BSArray::create();
		$server = $this->controller->getHost();
		if ($file = BSConfigManager::getConfigFile('validator/' . $server->getName())) {
			$config = BSArray::create(BSConfigManager::getInstance()->compile($file));
			if ($config['image'] && isset($config['image']['params'])) {
				$params->setParameters($config['image']['params']);
			}
		}
		$validator = new BSImageValidator($params);

		BSValidateManager::getInstance()->register($this->getName(), $validator);
	}

	/**
	 * 全てのファイル属性
	 *
	 * @access protected
	 * @return BSArray ファイル属性の配列
	 */
	protected function getSerializableValues () {
		$values = parent::getSerializableValues();
		$values['is_image'] = true;
		return $values;
	}
}

/* vim:set tabstop=4 */