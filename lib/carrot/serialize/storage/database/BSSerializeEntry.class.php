<?php
/**
 * @package org.carrot-framework
 * @subpackage serialize.storage.database
 */

/**
 * ストアドシリアライズレコード
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSSerializeEntry.class.php 944 2009-02-28 09:49:04Z pooza $
 */
class BSSerializeEntry extends BSRecord {

	/**
	 * 更新可能か？
	 *
	 * @access protected
	 * @return boolean 更新可能ならTrue
	 */
	protected function isUpdatable () {
		return true;
	}

	/**
	 * 削除可能か？
	 *
	 * @access protected
	 * @return boolean 削除可能ならTrue
	 */
	protected function isDeletable () {
		return true;
	}
}

/* vim:set tabstop=4: */
