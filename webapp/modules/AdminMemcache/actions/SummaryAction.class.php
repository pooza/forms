<?php
/**
 * Summaryアクション
 *
 * @package org.carrot-framework
 * @subpackage AdminMemcache
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: SummaryAction.class.php 957 2009-03-07 15:17:28Z pooza $
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
