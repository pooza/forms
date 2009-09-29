<?php
/**
 * NotFoundアクション
 *
 * @package org.carrot-framework
 * @subpackage Default
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: NotFoundAction.class.php 738 2008-12-12 00:59:09Z pooza $
 */
class NotFoundAction extends BSAction {
	public function execute () {
		return BSView::ERROR;
	}
}

/* vim:set tabstop=4: */
