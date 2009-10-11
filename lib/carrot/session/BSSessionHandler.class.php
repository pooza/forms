<?php
/**
 * @package org.carrot-framework
 * @subpackage session
 */

/**
 * セッションハンドラ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSSessionHandler.class.php 1550 2009-10-10 11:20:23Z pooza $
 */
class BSSessionHandler implements BSUserIdentifier {
	private $storage;

	/**
	 * @access public
	 */
	public function __construct () {
		if (headers_sent()) {
			throw new BSSessionException('セッションを開始できません。');
		}
		if (!$this->getStorage()->initialize()) {
			$this->storage = new BSDefaultSessionStorage;
			$this->storage->initialize();
		}
		session_cache_limiter('private_no_expire');
		session_start();

		if (BS_SESSION_REGENERATE_ID) {
			session_regenerate_id(true);
		}
	}

	/**
	 * セッションIDを返す
	 *
	 * @access public
	 * @return integer セッションID
	 */
	public function getID () {
		return session_id();
	}

	/**
	 * セッション名を返す
	 *
	 * @access public
	 * @return integer セッション名
	 */
	public function getName () {
		return session_name();
	}

	/**
	 * セッションストレージを返す
	 *
	 * @access protected
	 * @return BSSessionStorage セッションストレージ
	 */
	protected function getStorage () {
		if (!$this->storage) {
			$this->storage = BSClassLoader::getInstance()->getObject(
				BS_SESSION_STORAGE,
				'SessionStorage'
			);
		}
		return $this->storage;
	}

	/**
	 * セッション変数を返す
	 *
	 * @access public
	 * @param string $key 変数名
	 * @return mixed セッション変数
	 */
	public function read ($key) {
		if (isset($_SESSION[$key])) {
			return $_SESSION[$key];
		}
	}

	/**
	 * セッション変数を書き込む
	 *
	 * @access public
	 * @param string $key 変数名
	 * @param mixed $value 値
	 */
	public function write ($key, $value) {
		$_SESSION[$key] = $value;
	}

	/**
	 * セッション変数を削除
	 *
	 * @access public
	 * @param string $key 変数名
	 */
	public function remove ($key) {
		if (isset($_SESSION[$key])) {
			unset($_SESSION[$key]);
		}
	}

	/**
	 * ユーザーIDを返す
	 *
	 * @access public
	 * @return string ユーザーID
	 */
	public function getUserID () {
		return $this->getID();
	}

	/**
	 * 認証
	 *
	 * セッションが成立している時点で認証は困難、或いは不要と思われる。
	 *
	 * @access public
	 * @params string $password パスワード
	 * @return boolean 正しいユーザーならTrue
	 */
	public function auth ($password = null) {
		return true;
	}
}

/* vim:set tabstop=4: */
