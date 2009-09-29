<?php
/**
 * @package org.carrot-framework
 * @subpackage session
 */

/**
 * ケータイ用セッションハンドラ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSMobileSessionHandler.class.php 1195 2009-05-16 11:46:01Z pooza $
 */
class BSMobileSessionHandler extends BSSessionHandler {

	/**
	 * @access public
	 */
	public function __construct () {
		if (!$this->getStorage()->initialize()) {
			$this->storage = new BSDefaultSessionStorage;
			$this->storage->initialize();
		}
		ini_set('session.use_only_cookies', 0);
		session_start();
	}

	/**
	 * セッションIDを返す
	 *
	 * @access public
	 * @return integer セッションID
	 */
	public function getID () {
		$request = BSRequest::getInstance();
		if (!BSString::isBlank($id = $request[$this->getName()])) {
			session_id($id);
		}
		return parent::getID();
	}
}

/* vim:set tabstop=4: */
