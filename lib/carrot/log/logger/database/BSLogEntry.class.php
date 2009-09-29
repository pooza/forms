<?php
/**
 * @package org.carrot-framework
 * @subpackage log.logger.database
 */

/**
 * ログレコード
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSLogEntry.class.php 1443 2009-09-06 12:53:17Z pooza $
 */
class BSLogEntry extends BSRecord {

	/**
	 * 例外か？
	 *
	 * @access public
	 * @return boolean 例外ならTrue
	 */
	public function isException () {
		return mb_ereg('Exception$', $this->getAttribute('priority'));
	}
}
