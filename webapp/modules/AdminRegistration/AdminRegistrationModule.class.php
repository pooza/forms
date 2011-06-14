<?php
/**
 * AdminRegistrationモジュール
 *
 * @package jp.co.b-shock.forms
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
		if (!$form = BSModule::getInstance('AdminForm')->getRecord()) {
			$table = new RegistrationHandler;
			if ($record = $table->getRecord($this->getRecordID())) {
				$form = $record->getForm();
			}
		}
		return $form;
	}

	/**
	 * テーブルを返す
	 *
	 * @access public
	 * @return BSTableHandler テーブル
	 */
	public function getTable () {
		if (BSString::isBlank($this->request['key'])) {
			return parent::getTable();
		}
		if (!$this->table) {
			$this->table = new RegistrationDumpHandler($this->getForm());
		}
		return $this->table;
	}
}

/* vim:set tabstop=4: */
