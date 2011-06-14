<?php
/**
 * AdminFieldモジュール
 *
 * @package jp.co.b-shock.forms
 * @subpackage AdminField
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class AdminFieldModule extends BSModule {

	/**
	 * フォームを返す
	 *
	 * @access public
	 * @return Form フォーム
	 */
	public function getForm () {
		if ($record = $this->getRecord()) {
			return $record->getForm();
		} else {
			return BSModule::getInstance('AdminForm')->getRecord();
		}
	}
}

/* vim:set tabstop=4: */
