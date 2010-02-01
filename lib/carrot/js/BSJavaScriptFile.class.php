<?php
/**
 * @package org.carrot-framework
 * @subpackage js
 */

/**
 * JavaScriptファイル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSJavaScriptFile.class.php 1800 2010-02-01 08:23:35Z pooza $
 */
class BSJavaScriptFile extends BSFile implements BSDocumentSetEntry {

	/**
	 * 内容を最適化して返す
	 *
	 * @access public
	 * @return string 最適化された内容
	 */
	public function getOptimizedContents () {
		$contents = BSController::getInstance()->getAttribute($this, $this->getUpdateDate());
		if ($contents === null) {
			BSUtility::includeFile('jsmin');
			$contents = JSMin::minify($this->getContents());
			BSController::getInstance()->setAttribute($this, $contents);
		}
		return $contents;
	}

	/**
	 * メディアタイプを返す
	 *
	 * @access public
	 * @return string メディアタイプ
	 */
	public function getType () {
		return BSMIMEType::getType('js');
	}

	/**
	 * エンコードを返す
	 *
	 * @access public
	 * @return string PHPのエンコード名
	 */
	public function getEncoding () {
		return 'utf-8';
	}

	/**
	 * @access public
	 * @return string 基本情報
	 */
	public function __toString () {
		return sprintf('JavaScriptファイル "%s"', $this->getShortPath());
	}
}

/* vim:set tabstop=4: */
