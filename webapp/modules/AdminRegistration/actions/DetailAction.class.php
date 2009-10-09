<?php
/**
 * Detailアクション
 *
 * @package jp.co.commons.forms
 * @subpackage AdminRegistration
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class DetailAction extends BSRecordAction {
	public function execute () {
		$this->request->setAttribute('form', $this->getModule()->getForm());
		return BSView::SUCCESS;
	}

	public function deny () {
		$this->user->setAttribute('RequestURL', $this->request->getURL()->getContents());
		return parent::deny();
	}
}

/* vim:set tabstop=4: */
