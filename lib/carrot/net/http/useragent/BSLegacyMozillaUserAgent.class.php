<?php
/**
 * @package org.carrot-framework
 * @subpackage net.http.useragent
 */

/**
 * レガシーMozillaユーザーエージェント
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSLegacyMozillaUserAgent.class.php 1812 2010-02-03 15:15:09Z pooza $
 */
class BSLegacyMozillaUserAgent extends BSUserAgent {

	/**
	 * @access public
	 * @param string $name ユーザーエージェント名
	 */
	public function __construct ($name = null) {
		parent::__construct($name);
		$this->bugs['css'] = true;
		$this->attributes['is_kuso'] = true;
	}

	/**
	 * レガシー環境/旧機種か？
	 *
	 * @access public
	 * @return boolean レガシーならばTrue
	 */
	public function isLegacy () {
		return true;
	}

	/**
	 * 一致すべきパターンを返す
	 *
	 * @access public
	 * @return string パターン
	 */
	public function getPattern () {
		return '^Mozilla/[1-4]\\..*\((Mac|Win|X11)';
	}
}

/* vim:set tabstop=4: */
