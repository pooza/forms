<?php
/**
 * @package org.carrot-framework
 * @subpackage module
 */

/**
 * モジュール例外
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSModuleException.class.php 1004 2009-03-23 05:00:37Z pooza $
 */
class BSModuleException extends BSException {

	/**
	 * ログを書き込むか
	 *
	 * ループが発生する為、ログは書き込まない。
	 *
	 * @access public
	 * @return boolean ログを書き込むならTrue
	 */
	public function isLoggable () {
		return false;
	}
}

/* vim:set tabstop=4: */
