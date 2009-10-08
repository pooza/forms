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
}

/* vim:set tabstop=4: */
