<?php
/**
 * @package jp.co.b-shock.forms
 */

/**
 * 都道府県フィールド
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class PrefField extends SingleAnswerField {

	/**
	 * 選択肢を返す
	 *
	 * @access public
	 * @return BSArray 選択肢
	 */
	public function getChoices () {
		if (!$this->choices) {
			$prefs = new PrefHandler;
			$this->choices = BSArray::create($prefs->getLabels());
		}
		return $this->choices;
	}
}

/* vim:set tabstop=4 */