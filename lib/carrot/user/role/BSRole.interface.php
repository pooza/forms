<?php
/**
 * @package org.carrot-framework
 * @subpackage user.role
 */

/**
 * ロール
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSRole.interface.php 1176 2009-05-10 11:38:04Z pooza $
 * @abstract
 */
interface BSRole extends BSUserIdentifier {

	/**
	 * メールアドレスを返す
	 *
	 * @access public
	 * @param string $language 言語
	 * @return BSMailAddress メールアドレス
	 */
	public function getMailAddress ($language = 'ja');

	/**
	 * 名前を返す
	 *
	 * @access public
	 * @param string $language 言語
	 * @return string 名前
	 */
	public function getName ($language = 'ja');
}

/* vim:set tabstop=4: */
