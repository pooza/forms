<?php
/**
 * @package org.carrot-framework
 * @subpackage xml.xhtml
 */

/**
 * span要素
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSSpanElement.class.php 1682 2009-12-13 04:31:44Z pooza $
 */
class BSSpanElement extends BSXHTMLElement {

	/**
	 * font要素に変換して返す
	 *
	 * @access public
	 * @return BSXHTMLElement タグ名
	 */
	public function getFontElement () {
		$element = new BSXHTMLElement('font');
		$element->setBody($this->getBody());
		if ($color = $this->getStyle('color')) {
			$element->setAttribute('color', $color);
		}
		return $element;
	}
}

/* vim:set tabstop=4: */
