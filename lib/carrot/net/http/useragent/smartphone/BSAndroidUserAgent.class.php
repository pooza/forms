<?php
/**
 * @package org.carrot-framework
 * @subpackage net.http.useragent.smartphone
 */

/**
 * Androidユーザーエージェント
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSAndroidUserAgent.class.php 2336 2010-09-10 09:25:46Z pooza $
 */
class BSAndroidUserAgent extends BSWebKitUserAgent {

	/**
	 * スマートフォンか？
	 *
	 * @access public
	 * @return boolean スマートフォンならTrue
	 */
	public function isSmartPhone () {
		return true;
	}

	/**
	 * 一致すべきパターンを返す
	 *
	 * @access public
	 * @return string パターン
	 */
	public function getPattern () {
		return 'Android';
	}
}

/* vim:set tabstop=4: */
