<?php
/**
 * Detailアクション
 *
 * @package jp.co.commons.forms
 * @subpackage AgentForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class DetailAction extends BSRecordAction {
	public function execute () {
		$this->request->setAttribute('renderer', $this->getRecord()->getFieldOptions());
		return BSView::SUCCESS;
	}
}

/* vim:set tabstop=4: */
