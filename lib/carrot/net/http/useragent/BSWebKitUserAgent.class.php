<?php
/**
 * @package org.carrot-framework
 * @subpackage net.http.useragent
 */

/**
 * Webkitユーザーエージェント
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSWebKitUserAgent.class.php 1469 2009-09-11 12:40:31Z pooza $
 */
class BSWebKitUserAgent extends BSUserAgent {

	/**
	 * 一致すべきパターンを返す
	 *
	 * @access public
	 * @return string パターン
	 */
	public function getPattern () {
		return 'AppleWebKit';
	}

	/**
	 * アップロードボタンのラベルを返す
	 *
	 * @access public
	 * @return string アップロードボタンのラベル
	 */
	public function getUploadButtonLabel () {
		return 'ファイルを選択';
	}
}

/* vim:set tabstop=4: */
