<?php
/**
 * @package org.carrot-framework
 * @subpackage view
 */

/**
 * レンダラーを持たないビュー
 *
 * アクションがBSView::NONEを返したとき、HEADリクエストされたとき等に使用。
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSEmptyView.class.php 1133 2009-05-03 08:39:03Z pooza $
 */
class BSEmptyView extends BSView {

	/**
	 * 初期化
	 *
	 * @access public
	 * @return boolean 初期化が成功すればTrue
	 */
	public function initialize () {
		return true;
	}

	/**
	 * レンダリング
	 *
	 * ヘッダの送信のみ。
	 *
	 * @access public
	 */
	public function render () {
		$this->putHeaders();
	}

	/**
	 * レスポンスヘッダを送信
	 *
	 * @access public
	 */
	public function putHeaders () {
		$this->controller->putHeaders();
	}
}

/* vim:set tabstop=4: */
