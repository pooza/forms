<?php
/**
 * @package org.carrot-framework
 * @subpackage net.mime.header.addresses
 */

/**
 * BCCヘッダ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSBccMIMEHeader.class.php 998 2009-03-20 11:16:16Z pooza $
 */
class BSBccMIMEHeader extends BSAddressesMIMEHeader {

	/**
	 * 可視か？
	 *
	 * @access public
	 * @return boolean 可視ならばTrue
	 */
	public function isVisible () {
		return false;
	}
}

/* vim:set tabstop=4: */
