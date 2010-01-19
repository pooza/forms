<?php
/**
 * Listアクション
 *
 * @package jp.co.commons.forms
 * @subpackage AdminForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class ListAction extends BSTableAction {
	public function execute () {
		$this->request->setAttribute('forms', $this->getRows());
		return BSView::INPUT;
	}
}

/* vim:set tabstop=4: */
