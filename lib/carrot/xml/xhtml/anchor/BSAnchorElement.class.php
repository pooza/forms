<?php
/**
 * @package org.carrot-framework
 * @subpackage xml.xhtml.anchor
 */

/**
 * a要素
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSAnchorElement.class.php 1978 2010-04-08 09:19:47Z pooza $
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

	/**
	 * 対象をラップして返す
	 *
	 * @access public
	 * @param BSXMLElement $element 対象要素
	 * @param BSHTTPRedirector $url リンク先
	 * @return BSAnchorElement 自身
	 */
	public function wrap (BSXMLElement $element, BSHTTPRedirector $url) {
		$this->addElement($element);
		$this->setURL($url);
		if (!$this->useragent->isMobile() && $url->isForeign()) {
			$this->setAttribute('target', '_blank');
		}
		return $this;
	}
}

/* vim:set tabstop=4: */
