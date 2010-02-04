<?php
/**
 * @package org.carrot-framework
 * @subpackage view.renderer.smarty.cache.storage
 */

/**
 * ファイルを用いたSmartyキャッシュストレージ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSFileSmartyCacheStorage.class.php 1812 2010-02-03 15:15:09Z pooza $
 */
class BSFileSmartyCacheStorage implements BSSmartyCacheStorage {

	/**
	 * 初期化
	 *
	 * @access public
	 * @param BSSmarty $smarty
	 * @return string 利用可能ならTrue
	 */
	public function initialize (BSSmarty $smarty) {
		$dir = BSFileUtility::getDirectory('cache');
		$smarty->cache_dir = $dir->getPath();
		$smarty->cache_lifetime = BS_SMARTY_CACHE_LIFE_TIME;
		$smarty->caching = 1;
		return $dir->isWritable();
	}
}

/* vim:set tabstop=4: */
