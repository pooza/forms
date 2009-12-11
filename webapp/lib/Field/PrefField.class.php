<?php
/**
 * @package jp.co.commons.forms
 */

/**
 * 都道府県フィールド
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
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
			$this->choices = new BSArray($prefs->getLabels());
		}
		return $this->choices;
	}

	/**
	 * グループ化された選択肢を返す
	 *
	 * @access public
	 * @return BSArray 選択肢
	 */
	public function getGroupedChoices () {
		return $this->getChoices();
	}
}

/* vim:set tabstop=4 */