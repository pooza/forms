<?php
/**
 * AdminFieldモジュール
 *
 * @package jp.co.commons.forms
 * @subpackage AdminField
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class AdminFieldModule extends BSModule {

	/**
	 * イベントを返す
	 *
	 * @access public
	 * @return Event イベント
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
