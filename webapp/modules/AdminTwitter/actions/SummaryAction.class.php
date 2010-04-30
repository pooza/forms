<?php
/**
 * Summaryアクション
 *
 * @package org.carrot-framework
 * @subpackage AdminTwitter
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: SummaryAction.class.php 2047 2010-04-29 08:08:57Z pooza $
 */
class SummaryAction extends BSAction {
	public function execute () {
		$service = new BSTwitterService;
		$this->request->setAttribute('service', $service);

		if ($account = $service->getAccount()) {
			$this->request->setAttribute('account', $account);
		} else {
			$values = array('url' => $service->getOAuthURL()->getContents());
			$this->request->setAttribute('oauth', $values);
		}
		return BSView::SUCCESS;
	}
}

/* vim:set tabstop=4: */
