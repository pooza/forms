<?php
/**
 * @package org.carrot-framework
 * @subpackage net.http.useragent
 */

/**
 * CLI環境用 ダミーユーザーエージェント
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSConsoleUserAgent.class.php 1469 2009-09-11 12:40:31Z pooza $
 */
class BSConsoleUserAgent extends BSUserAgent {

	/**
	 * ビューを初期化
	 *
	 * @access public
	 * @param BSSmartyView 対象ビュー
	 * @return boolean 成功時にTrue
	 */
	public function initializeView (BSSmartyView $view) {
		$view->getRenderer()->setUserAgent($this);
		$view->setAttributes(BSRequest::getInstance()->getAttributes());
		$view->setAttribute('module', $view->getModule());
		$view->setAttribute('action', $view->getAction());
		$view->setAttribute('errors', BSRequest::getInstance()->getErrors());
		$view->setAttribute('params', BSRequest::getInstance()->getParameters());
		$view->setAttribute('credentials', BSUser::getInstance()->getCredentials());
		$view->setAttribute('is_debug', BS_DEBUG);
		return true;
	}

	/**
	 * プラットホームを返す
	 *
	 * @access public
	 * @return string プラットホーム
	 */
	public function getPlatform () {
		return null;
	}

	/**
	 * 規定の画像形式を返す
	 *
	 * @access public
	 * @return string 規定の画像形式
	 */
	public function getDefaultImageType () {
		return null;
	}

	/**
	 * セッションハンドラを生成して返す
	 *
	 * @access public
	 * @return BSSessionHandler
	 */
	public function createSession () {
		return new BSConsoleSessionHandler;
	}

	/**
	 * 一致すべきパターンを返す
	 *
	 * @access public
	 * @return string パターン
	 */
	public function getPattern () {
		return '^Console$';
	}
}

/* vim:set tabstop=4: */
