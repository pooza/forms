<?php
/**
 * Thanxアクション
 *
 * @package jp.co.commons.forms
 * @subpackage UserForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class ThanxAction extends BSRecordAction {
	public function execute () {
		$this->setAttribute('answer', $this->user->getAttribute('answer'));
		return BSView::SUCCESS;
	}
}

/* vim:set tabstop=4: */

