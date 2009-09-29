<?php
/**
 * Pingアクション
 *
 * @package org.carrot-framework
 * @subpackage Default
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: PingAction.class.php 1390 2009-08-23 06:41:37Z pooza $
 */
class PingAction extends BSAction {
	public function execute () {
		try {
			BSDatabase::getInstance();
			return BSView::SUCCESS;
		} catch (Exception $e) {
			$this->request->setError('database', $e->getMessage());
			return BSView::ERROR;
		}
	}
}

/* vim:set tabstop=4: */
