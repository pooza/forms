<?php
/**
 * @package org.carrot-framework
 * @subpackage net.mime.header.address
 */

/**
 * Return-Pathヘッダ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSReturnPathMIMEHeader.class.php 1469 2009-09-11 12:40:31Z pooza $
 */
class BSReturnPathMIMEHeader extends BSAddressMIMEHeader {

	/**
	 * ヘッダの内容からパラメータを抜き出す
	 *
	 * @access protected
	 */
	protected function parseParameters () {
		BSMIMEHeader::parseParameters();
		if (mb_ereg('^<?([^>]*)>?$', $this->contents, $matches)) {
			$this->email = BSMailAddress::getInstance($matches[1]);
		}
	}
}

/* vim:set tabstop=4: */
