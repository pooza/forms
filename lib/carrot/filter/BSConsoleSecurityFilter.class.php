<?php
/**
 * @package org.carrot-framework
 * @subpackage filter
 */

/**
 * コンソール認証
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSConsoleSecurityFilter.class.php 1812 2010-02-03 15:15:09Z pooza $
 */
class BSConsoleSecurityFilter extends BSFilter {
	public function execute () {
		return !$this->request->isCLI();
	}
}

/* vim:set tabstop=4: */
