<?php
/**
 * @package org.carrot-framework
 * @subpackage date
 */

/**
 * 日付例外
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSDateException.class.php 1657 2009-12-07 02:35:36Z pooza $
 */
class BSDateException extends BSException {

	/**
	 * ログを書き込むか
	 *
	 * @access public
	 * @return boolean ログを書き込むならTrue
	 */
	public function isLoggable () {
		return false;
	}
}

/* vim:set tabstop=4: */
