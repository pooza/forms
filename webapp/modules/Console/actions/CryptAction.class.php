<?php
/**
 * Cryptアクション
 *
 * @package org.carrot-framework
 * @subpackage Console
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: CryptAction.class.php 973 2009-03-12 06:29:42Z pooza $
 */
class CryptAction extends BSAction {
	public function initialize () {
		$this->request->addOption('t');
		$this->request->parse();
		return true;
	}

	public function execute () {
		$crypt = BSCrypt::getInstance();
		$this->request->setAttribute('plain', $this->request['t']);
		$this->request->setAttribute('crypted', $crypt->encrypt($this->request['t']));
		return BSView::SUCCESS;
	}

	public function handleError () {
		return BSView::ERROR;
	}
}

/* vim:set tabstop=4: */
