<?php
/**
 * @package org.carrot-framework
 * @subpackage net.mime.header
 */

/**
 * Subjectヘッダ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSSubjectMIMEHeader.class.php 1812 2010-02-03 15:15:09Z pooza $
 */
class BSSubjectMIMEHeader extends BSMIMEHeader {

	/**
	 * 内容を返す
	 *
	 * @access public
	 * @return string 内容
	 */
	public function getContents () {
		if (BS_DEBUG) {
			return '[TEST] ' . $this->contents;
		}
		return $this->contents;
	}
}

/* vim:set tabstop=4: */
