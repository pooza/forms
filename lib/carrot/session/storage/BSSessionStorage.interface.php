<?php
/**
 * @package org.carrot-framework
 * @subpackage session.storage
 */

/**
 * セッションストレージ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSSessionStorage.interface.php 932 2009-02-27 04:39:33Z pooza $
 */
interface BSSessionStorage {

	/**
	 * 初期化
	 *
	 * @access public
	 * @return string 利用可能ならTrue
	 */
	public function initialize ();
}

/* vim:set tabstop=4: */
