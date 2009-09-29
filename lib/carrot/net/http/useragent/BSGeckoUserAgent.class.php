<?php
/**
 * @package org.carrot-framework
 * @subpackage net.http.useragent
 */

/**
 * Geckoユーザーエージェント
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSGeckoUserAgent.class.php 1469 2009-09-11 12:40:31Z pooza $
 */
class BSGeckoUserAgent extends BSUserAgent {

	/**
	 * 一致すべきパターンを返す
	 *
	 * @access public
	 * @return string パターン
	 */
	public function getPattern () {
		return 'Gecko/[[:digit:]]+';
	}

	/**
	 * アップロードボタンのラベルを返す
	 *
	 * @access public
	 * @return string アップロードボタンのラベル
	 */
	public function getUploadButtonLabel () {
		if ($this->getPlatform() == 'Macintosh') {
			return '選択...';
		}
		return parent::getUploadButtonLabel();
	}
}

/* vim:set tabstop=4: */
