<?php
/**
 * @package org.carrot-framework
 * @subpackage view.renderer.smarty.cache.storage
 */

/**
 * 規定Smartyキャッシュストレージ
 *
 * キャッシュを行わない
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSDefaultSmartyCacheStorage.class.php 1812 2010-02-03 15:15:09Z pooza $
 */
class BSDefaultSmartyCacheStorage implements BSSmartyCacheStorage {

	/**
	 * 初期化
	 *
	 * @access public
	 * @param BSSmarty $smarty
	 * @return string 利用可能ならTrue
	 */
	public function initialize (BSSmarty $smarty) {
		return true;
	}
}

/* vim:set tabstop=4: */
