<?php
/**
 * @package org.carrot-framework
 * @subpackage filter
 */

/**
 * ホスト認証
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSHostSecurityFilter.class.php 1272 2009-06-14 02:16:27Z pooza $
 */
class BSHostSecurityFilter extends BSFilter {
	public function execute () {
		try {
			$this->auth();
		} catch (BSNetException $e) {
			$this->controller->getSecureAction()->forward();
			return true;
		}
	}

	/**
	 * クライアントホストによる認証
	 *
	 * @access private
	 * @return 許可されたネットワーク内ならTrue
	 */
	private function auth () {
		foreach (BSAdministratorRole::getInstance()->getAllowedNetworks() as $network) {
			if ($this->request->getHost()->isInNetwork($network)) {
				return true;
			}
		}
		throw new BSNetException('リモートアクセス禁止のホストです。');
	}
}

/* vim:set tabstop=4: */
