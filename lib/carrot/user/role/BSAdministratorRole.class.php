<?php
/**
 * @package org.carrot-framework
 * @subpackage user.role
 */

/**
 * 管理者ロール
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSAdministratorRole.class.php 1522 2009-09-22 06:38:56Z pooza $
 */
class BSAdministratorRole implements BSRole {
	private $networks;
	static private $instance;

	/**
	 * @access private
	 */
	private function __construct () {
	}

	/**
	 * シングルトンインスタンスを返す
	 *
	 * @access public
	 * @return BSAdministratorRole インスタンス
	 * @static
	 */
	static public function getInstance () {
		if (!self::$instance) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * @access public
	 */
	public function __clone () {
		throw new BSSingletonException(__CLASS__ . 'はコピーできません。');
	}

	/**
	 * ユーザーIDを返す
	 *
	 * @access public
	 * @return string ユーザーID
	 */
	public function getID () {
		return $this->getMailAddress()->getContents();
	}

	/**
	 * メールアドレスを返す
	 *
	 * @access public
	 * @param string $language 言語
	 * @return BSMailAddress メールアドレス
	 */
	public function getMailAddress ($language = 'ja') {
		return BSMailAddress::getInstance(BS_ADMIN_EMAIL, self::getName($language));
	}

	/**
	 * 名前を返す
	 *
	 * @access public
	 * @param string $language 言語
	 * @return string 名前
	 */
	public function getName ($language = 'ja') {
		return BSController::getInstance()->getName($language) . ' 管理者';
	}

	/**
	 * JabberIDを返す
	 *
	 * @access public
	 * @return BSJabberID JabberID
	 */
	public function getJabberID () {
		if (!BSString::isBlank(BS_ADMIN_JID)) {
			return new BSJabberID(BS_ADMIN_JID);
		}
	}

	/**
	 * 許可されたネットワークを返す
	 *
	 * @access public
	 * @return BSArray 許可されたネットワークの配列
	 */
	public function getAllowedNetworks () {
		if (!$this->networks) {
			$this->networks = new BSArray;
			if (BSString::isBlank(BS_ADMIN_NETWORKS)) {
				$this->networks[] = new BSNetwork('0.0.0.0/0');
			} else {
				$this->networks[] = new BSNetwork('127.0.0.1/32');
				foreach (BSString::explode(',', BS_ADMIN_NETWORKS) as $network) {
					$this->networks[] = new BSNetwork($network);
				}
			}
		}
		return $this->networks;
	}

	/**
	 * ユーザーIDを返す
	 *
	 * @access public
	 * @return string ユーザーID
	 */
	public function getUserID () {
		return $this->getMailAddress()->getContents();
	}

	/**
	 * 認証
	 *
	 * @access public
	 * @params string $password パスワード
	 * @return boolean 正しいユーザーならTrue
	 */
	public function auth ($password = null) {
		return !BSString::isBlank(BS_ADMIN_PASSWORD)
			&& !BSString::isBlank($password)
			&& BSCrypt::getInstance()->auth(BS_ADMIN_PASSWORD, $password);
	}
}

/* vim:set tabstop=4: */
