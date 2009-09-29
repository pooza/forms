<?php
/**
 * @package org.carrot-framework
 * @subpackage crypt.cryptor
 */

BSUtility::includeFile('pear/Crypt/CBC.php');

/**
 * CBC暗号
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSCBCCryptor.class.php 1429 2009-09-05 08:18:34Z pooza $
 */
class BSCBCCryptor extends Crypt_CBC implements BSCryptor {
	private $salt;

	/**
	 * @access public
	 * @param string $salt ソルト
	 */
	public function __construct ($salt = BS_CRYPT_SALT) {
		parent::Crypt_CBC($salt);
		$this->setSalt($salt);
	}

	/**
	 * ソルトを返す
	 *
	 * @access public
	 * @return string ソルト
	 */
	public function getSalt () {
		return $this->salt;
	}

	/**
	 * ソルトを設定
	 *
	 * @access public
	 * @param string $salt ソルト
	 */
	public function setSalt ($salt) {
		$this->salt = $salt;
	}
}

/* vim:set tabstop=4: */
