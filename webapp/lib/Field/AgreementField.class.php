<?php
/**
 * @package jp.co.b-shock.forms
 */

/**
 * 同意フィールド
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class AgreementField extends SingleAnswerField {

	/**
	 * バリデータ登録
	 *
	 * @access public
	 */
	public function registerValidators () {
		$params = ['required_msg' => 'ご同意下さい。'];
		BSValidateManager::getInstance()->register(
			$this->getName(),
			new BSEmptyValidator($params)
		);
	}

	/**
	 * 選択肢を返す
	 *
	 * @access public
	 * @return BSArray 選択肢
	 */
	public function getChoices () {
		if (!$this->choices) {
			$prefs = new PrefHandler;
			$this->choices = new BSArray([1, 0]);
		}
		return $this->choices;
	}
}

/* vim:set tabstop=4 */