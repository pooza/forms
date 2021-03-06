<?php
/**
 * @package jp.co.b-shock.carrot
 * @subpackage user.role
 */

/**
 * 発行者ロール
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class BSAuthorRole implements BSRole {
	use BSSingleton, BSBasicObject;
	protected $credentials;
	protected $twitterAccount;
	const CREDENTIAL = 'Author';

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
		return BSMailAddress::create(BS_AUTHOR_EMAIL, $this->getName($language));
	}

	/**
	 * Twitterアカウントを返す
	 *
	 * @access public
	 * @return BSTwitterAccount アカウント
	 */
	public function getTwitterAccount () {
		if (!$this->twitterAccount && !BSString::isBlank(BS_AUTHOR_TWITTER)) {
			$this->twitterAccount = new BSTwitterAccount(BS_AUTHOR_TWITTER);
		}
		return $this->twitterAccount;
	}

	/**
	 * 名前を返す
	 *
	 * @access public
	 * @param string $language 言語
	 * @return string 名前
	 */
	public function getName ($language = 'ja') {
		if (BSString::isBlank($name = BS_AUTHOR_NAME)) {
			$name = $this->controller->getAttribute('app_name_' . $language);
		}
		return $name;
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
	 * @param string $password パスワード
	 * @return boolean 正しいユーザーならTrue
	 */
	public function auth ($password = null) {
		return (!BSString::isBlank(BS_AUTHOR_PASSWORD)
			&& !BSString::isBlank($password)
			&& BSCrypt::getInstance()->auth(BS_AUTHOR_PASSWORD, $password)
		);
	}

	/**
	 * 認証時に与えられるクレデンシャルを返す
	 *
	 * @access public
	 * @return BSArray クレデンシャルの配列
	 */
	public function getCredentials () {
		if (!$this->credentials) {
			$this->credentials = BSArray::create();
			$this->credentials[] = self::CREDENTIAL;
		}
		return $this->credentials;
	}
}

