<?php
/**
 * AdminRegistrationモジュール
 *
 * @package jp.co.commons.forms
 * @subpackage AdminRegistration
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class AdminRegistrationModule extends BSModule {

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

	/**
	 * テーブルを返す
	 *
	 * @access public
	 * @return BSTableHandler テーブル
	 */
	public function getTable () {
		if (!$this->table) {
			$this->table = new RegistrationDumpHandler($this->getForm());
		}
		return $this->table;
	}
}

/* vim:set tabstop=4: */
