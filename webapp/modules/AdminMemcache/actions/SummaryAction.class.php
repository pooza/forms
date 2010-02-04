<?php
/**
 * Summaryアクション
 *
 * @package org.carrot-framework
 * @subpackage AdminMemcache
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: SummaryAction.class.php 1812 2010-02-03 15:15:09Z pooza $
 */
class SummaryAction extends BSAction {
	public function execute () {
		if ($server = BSMemcacheManager::getInstance()->getServer()) {
			$this->request->setAttribute('server', $server->getAttributes());
		}
		return BSView::SUCCESS;
	}
}

/* vim:set tabstop=4: */
