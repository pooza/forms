<?php
/**
 * @package org.carrot-framework
 * @subpackage css
 */

/**
 * スタイルセット
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSStyleSet.class.php 1600 2009-10-30 14:48:55Z pooza $
 */
class BSStyleSet extends BSDocumentSet {

	/**
	 * 書類のクラス名を返す
	 *
	 * @access protected
	 * @return string $name 書類のクラス名
	 */
	protected function getDocumentClassName () {
		return 'BSCSSFile';
	}

	/**
	 * ディレクトリを返す
	 *
	 * @access protected
	 * @return BSDirectory ディレクトリ
	 */
	protected function getDirectory () {
		return BSFileUtility::getDirectory('css');
	}
}

/* vim:set tabstop=4: */
