<?php
/**
 * Loginアクション
 *
 * @package org.carrot-framework
 * @subpackage AdminTwitter
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: LoginAction.class.php 2047 2010-04-29 08:08:57Z pooza $
 */
class LoginAction extends BSAction {
	public function execute () {
		$service = new BSTwitterService;
		$service->login($this->request['verifier']);
		return $this->getModule()->redirect();
	}
}

/* vim:set tabstop=4: */
