<?php
/**
 * @package org.carrot-framework
 * @subpackage filter
 */

/**
 * HTTPSによるGETを強制するフィルタ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSHTTPSFilter.class.php 1596 2009-10-30 11:31:21Z pooza $
 */
class BSHTTPSFilter extends BSFilter {
	public function initialize ($parameters = array()) {
		$this['base_url'] = BS_ROOT_URL_HTTPS;
		return parent::initialize($parameters);
	}

	public function execute () {
		if (!BS_DEBUG
			&& !$this->request->isCLI()
			&& !$this->request->isSSL()
			&& ($this->request->getMethod() == 'GET')) {

			$url = BSURL::getInstance($this['base_url']);
			$url['path'] = $this->controller->getAttribute('REQUEST_URI');
			$url->redirect();
			return true;
		}
	}
}

/* vim:set tabstop=4: */
