<?php
/**
 * @package org.carrot-framework
 * @subpackage js
 */

/**
 * JavaScriptセット
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSJavaScriptSet.class.php 1773 2010-01-24 05:10:09Z pooza $
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
	 * ソースディレクトリを返す
	 *
	 * @access protected
	 * @return BSDirectory ソースディレクトリ
	 */
	protected function getSourceDirectory () {
		return BSFileUtility::getDirectory('js');
	}

	/**
	 * キャッシュディレクトリを返す
	 *
	 * @access protected
	 * @return BSDirectory キャッシュディレクトリ
	 */
	protected function getCacheDirectory () {
		return BSFileUtility::getDirectory('js_cache');
	}

	/**
	 * @access public
	 * @return string 基本情報
	 */
	public function __toString () {
		return sprintf(
			'JavaScriptセット "%s"(%s)',
			$this->getName(),
			$this->getCacheFile()->getShortPath()
		);
	}
}

/* vim:set tabstop=4: */
