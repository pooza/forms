<?php
/**
 * @package org.carrot-framework
 * @subpackage js
 */

/**
 * JavaScriptセット
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSJavaScriptSet.class.php 1756 2010-01-15 07:21:15Z pooza $
 */
class BSJavaScriptSet extends BSDocumentSet {

	/**
	 * 書類のクラス名を返す
	 *
	 * @access protected
	 * @return string $name 書類のクラス名
	 */
	protected function getDocumentClass () {
		return 'BSJavaScriptFile';
	}

	/**
	 * ディレクトリを返す
	 *
	 * @access protected
	 * @return BSDirectory ディレクトリ
	 */
	protected function getDirectory () {
		return BSFileUtility::getDirectory('js');
	}
}

/* vim:set tabstop=4: */
