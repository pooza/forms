<?php
/**
 * @package org.carrot-framework
 * @subpackage request.validate.validator
 */

/**
 * 選択バリデータ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSChoiceValidator.class.php 1608 2009-11-09 03:11:27Z pooza $
 */
class BSChoiceValidator extends BSValidator {

	/**
	 * 初期化
	 *
	 * @access public
	 * @param string[] $parameters パラメータ配列
	 */
	public function initialize ($parameters = array()) {
		$this['class'] = null;
		$this['function'] = 'getStatusOptions';
		$this['choices'] = null;
		$this['choices_error'] = '正しくありません。';
		return parent::initialize($parameters);
	}

	/**
	 * 実行
	 *
	 * @access public
	 * @param mixed $value バリデート対象
	 * @return boolean 妥当な値ならばTrue
	 */
	public function execute ($value) {
		$choices = new BSArray($value);
		$choices->trim();
		foreach ($choices as $choice) {
			if (!$this->getChoices()->isContain($choice)) {
				$this->error = $this['choices_error'];
				return false;
			}
		}
		return true;
	}

	protected function getChoices () {
		$choices = new BSArray;
		if ($config = $this['choices']) {
			if (BSArray::isArray($config)) {
				$choices->setParameters($config);
			} else {
				$choices = BSString::explode(',', $config);
			}
		} else if ($this['class']) {
			$classes = BSClassLoader::getInstance();
			try {
				$class = $classes->getClassName($this['class'], BSTableHandler::CLASS_SUFFIX);
			} catch (Exception $e) {
				$class = $classes->getClassName($this['class']);
			}
			$choices->setParameters(call_user_func(array($class, $this['function'])));
			$choices = $choices->getKeys(BSArray::WITHOUT_KEY);
		}
		return $choices;
	}
}

/* vim:set tabstop=4: */
