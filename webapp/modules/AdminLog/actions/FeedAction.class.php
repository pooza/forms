<?php
/**
 * Feedアクション
 *
 * @package org.carrot-framework
 * @subpackage AdminLog
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: FeedAction.class.php 1054 2009-04-12 01:38:13Z pooza $
 */
class FeedAction extends BSAction {
	public function execute () {
		$this->request->setAttribute('entries', $this->getModule()->getEntries());
		return BSView::SUCCESS;
	}
}

/* vim:set tabstop=4: */
