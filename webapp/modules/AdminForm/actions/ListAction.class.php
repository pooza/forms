<?php
/**
 * Listアクション
 *
 * @package jp.co.b-shock.forms
 * @subpackage AdminForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class ListAction extends BSTableAction {
	public function execute () {
		$this->request->setAttribute('forms', $this->getRows());
		return BSView::INPUT;
	}
}

