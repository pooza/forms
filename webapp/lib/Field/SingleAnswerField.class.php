<?php
/**
 * @package jp.co.commons.forms
 */

/**
 * 単一回答フィールド
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class SingleAnswerField extends Field {

	/**
	 * バリデータ登録
	 *
	 * @access public
	 */
	public function registerValidators () {
		$manager = BSValidateManager::getInstance();
		if ($this['required']) {
			$params = array('required_msg' => '選ばれていません。');
			$manager->register($this->getName(), new BSEmptyValidator($params));
			$params = array('max' => 2048);
			$manager->register($this->getName(), new BSStringValidator($params));
		}
		$params = array('choices' => $this->getChoices());
		$manager->register($this->getName(), new BSChoiceValidator($params));
	}
}

/* vim:set tabstop=4 */