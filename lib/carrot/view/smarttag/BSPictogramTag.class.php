<?php
/**
 * @package org.carrot-framework
 * @subpackage view.smarttag
 */

/**
 * 絵文字タグ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSPictogramTag.class.php 1083 2009-04-19 03:32:33Z pooza $
 */
class BSPictogramTag extends BSSmartTag {

	/**
	 * タグ名を返す
	 *
	 * @access public
	 * @return string タグ名
	 */
	public function getTagName () {
		return 'picto';
	}

	/**
	 * 置換して返す
	 *
	 * @access public
	 * @param string $body 置換対象文字列
	 * @return string 置換された文字列
	 * @abstract
	 */
	public function execute ($body) {
		try {
			$pictogram = BSPictogram::getInstance($this->tag[1]);
			$replace = $pictogram->getContents();
		} catch (Exception $e) {
			$replace = sprintf('[エラー: %s]', $e->getMessage());
		}
		return str_replace($this->getContents(), $replace, $body);
	}
}

/* vim:set tabstop=4: */
