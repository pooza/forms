<?php
/**
 * @package org.carrot-framework
 */

/**
 * 例外
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSException.class.php 1812 2010-02-03 15:15:09Z pooza $
 */
class BSException extends Exception {

	/**
	 * @access public
	 */
	public function __construct () {
		switch (count($args = func_get_args())) {
			case 0:
				$message = $this->getName() . 'が発生しました。';
				break;
			case 1:
				if ($args[0] instanceof BSStringFormat) {
					$message = $args[0]->getContents();
				} else {
					$message = $args[0];
				}
				break;
			default:
				$message = call_user_func_array('sprintf', $args);
				break;
		}
		parent::__construct($message);

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
