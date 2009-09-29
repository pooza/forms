<?php
/**
 * Logoutアクション
 *
 * @package org.carrot-framework
 * @subpackage Default
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: LogoutAction.class.php 1176 2009-05-10 11:38:04Z pooza $
 */
class LogoutAction extends BSAction {
	public function execute () {
		$this->request->clearAttributes();
		$this->user->clearAttributes();
		$this->user->clearCredentials();
		$this->user->logout();
		return $this->getModule()->getAction('Login')->redirect();
	}
}

/* vim:set tabstop=4: */
