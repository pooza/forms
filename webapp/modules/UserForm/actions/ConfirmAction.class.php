<?php
/**
 * Confirmアクション
 *
 * @package jp.co.commons.forms
 * @subpackage UserForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class ConfirmAction extends BSRecordAction {
	public function execute () {
		return BSView::INPUT;
	}

	public function handleError () {
		return $this->getRecord()->redirect();
	}

	public function validate () {
		if (AccountHandler::getCurrentAccount()->isRegisterd($this->getRecord())) {
			return false;
		} else if (!$this->user->getAttribute('answer')) {
			return false;
		}
		return true;
	}
}

/* vim:set tabstop=4: */

