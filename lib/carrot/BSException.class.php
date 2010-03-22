<?php
/**
 * @package org.carrot-framework
 */

/**
 * 例外
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSException.class.php 1920 2010-03-21 09:16:06Z pooza $
 */
class BSException extends Exception {

	/**
	 * @access public
	 * $param string $message メッセージ
	 * @param int $code コード
	 * @param Exception $prev 直前の例外。例外の連結に使用。
	 */
	public function __construct ($message = null, $code = 0, Exception $prev = null) {
		if ($message instanceof BSStringFormat) {
			$message = $message->getContents();
		}
		parent::__construct($message, $code, $prev);

		if ($this->isLoggable()) {
			BSLogManager::getInstance()->put($this);
		}
	}

	/**
	 * 名前を返す
	 *
	 * @access public
	 * @return string 名前
	 */
	public function getName () {
		return get_class($this);
	}

	/**
	 * ログを書き込むか
	 *
	 * @access public
	 * @return boolean ログを書き込むならTrue
	 */
	public function isLoggable () {
		return true;
	}
}

/* vim:set tabstop=4: */
