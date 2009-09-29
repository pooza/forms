<?php
/**
 * @package org.carrot-framework
 * @subpackage xml.feed.atom10
 */

/**
 * Atom1.0エントリー
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSAtom10Entry.class.php 1495 2009-09-16 16:24:26Z pooza $
 */
class BSAtom10Entry extends BSAtom03Entry {

	/**
	 * 本文を設定
	 *
	 * @access public
	 * @param string $content 内容
	 */
	public function setBody ($body = null) {
		if (!$element = $this->getElement('content')) {
			$element = $this->createElement('content');
		}
		$element->setBody($body);
		$element->setAttribute('type', 'text');
	}
}

/* vim:set tabstop=4: */
