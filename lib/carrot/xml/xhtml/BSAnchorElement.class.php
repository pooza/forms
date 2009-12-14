<?php
/**
 * @package org.carrot-framework
 * @subpackage xml.xhtml
 */

/**
 * a要素
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSAnchorElement.class.php 1685 2009-12-14 07:30:31Z pooza $
 */
class BSAnchorElement extends BSXHTMLElement {

	/**
	 * タグ名を返す
	 *
	 * @access public
	 * @return string タグ名
	 */
	public function getTag () {
		return 'a';
	}

	/**
	 * URLを設定
	 *
	 * @access public
	 * @param mixed $url
	 */
	public function setURL ($url) {
		if ($url instanceof BSHTTPRedirector) {
			$url = $url->getURL()->getContents();
		}
		$this->setAttribute('href', $url);
	}
}

/* vim:set tabstop=4: */
