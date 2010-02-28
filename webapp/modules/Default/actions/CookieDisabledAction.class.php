<?php
/**
 * CookieDisabledアクション
 *
 * @package org.carrot-framework
 * @subpackage Default
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: CookieDisabledAction.class.php 1886 2010-02-28 04:45:35Z pooza $
 */
class CookieDisabledAction extends BSAction {
	public function execute () {
		return BSView::ERROR;
	}
}

/* vim:set tabstop=4: */
