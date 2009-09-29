<?php
/**
 * @package org.carrot-framework
 * @subpackage net.mime.header
 */

/**
 * Content-Dispositionヘッダ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSContentDispositionMIMEHeader.class.php 998 2009-03-20 11:16:16Z pooza $
 */
class BSContentDispositionMIMEHeader extends BSMIMEHeader {

	/**
	 * ヘッダの内容からパラメータを抜き出す
	 *
	 * @access protected
	 */
	protected function parseParameters () {
		parent::parseParameters();
		if ($this['filename'] && ($part = $this->getPart()) && !$part->getFileName()) {
			$part->setFileName($this['filename']);
		}
	}
}

/* vim:set tabstop=4: */
