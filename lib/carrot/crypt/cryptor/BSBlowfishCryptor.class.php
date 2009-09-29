<?php
/**
 * @package org.carrot-framework
 * @subpackage crypt.cryptor
 */

BSUtility::includeFile('pear/Crypt/Blowfish.php');

/**
 * Blowfish暗号
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSBlowfishCryptor.class.php 810 2009-01-27 17:54:31Z pooza $
 */
class BSBlowfishCryptor extends Crypt_Blowfish implements BSCryptor {
	private $salt;

	/**
	 * @access public
	 * @param string $salt ソルト
	 */
	public function __construct ($salt = BS_CRYPT_SALT) {
		parent::Crypt_Blowfish($salt);
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
	 * setKeyのエイリアス
	 *
	 * @access public
	 * @param string $salt ソルト
	 */
	public function setSalt ($salt) {
		$this->setKey($salt);
	}

	/**
	 * ソルトを設定
	 *
	 * @access public
	 * @param string $salt ソルト
	 */
	public function setKey ($salt) {
		$this->salt = $salt;
		return parent::setKey($salt);
	}
}

/* vim:set tabstop=4: */
