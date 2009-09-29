<?php
/**
 * @package org.carrot-framework
 * @subpackage view.renderer.smarty.cache.storage
 */

/**
 * Smartyキャッシュストレージ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSSmartyCacheStorage.interface.php 971 2009-03-12 03:48:25Z pooza $
 */
interface BSSmartyCacheStorage {

	/**
	 * 初期化
	 *
	 * @access public
	 * @param BSSmarty $smarty
	 * @return string 利用可能ならTrue
	 */
	public function initialize (BSSmarty $smarty);
}

/* vim:set tabstop=4: */
