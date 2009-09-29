<?php
/**
 * @package org.carrot-framework
 * @subpackage css
 */

/**
 * CSSファイル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSCSSFile.class.php 1525 2009-09-25 10:38:32Z pooza $
 */
class BSCSSFile extends BSFile implements BSDocumentSetEntry {

	/**
	 * 内容を最適化して返す
	 *
	 * @access public
	 * @return string 最適化された内容
	 */
	public function getOptimizedContents () {
		$contents = BSController::getInstance()->getAttribute($this, $this->getUpdateDate());
		if ($contents === null) {
			$renderer = new BSPlainTextRenderer;
			$renderer->setContents(mb_ereg_replace('/\\*.*?\\*/', null, $this->getContents()));
			foreach ($renderer as $line) {
				$contents .= trim($line) . "\n";
			}
			$contents = mb_ereg_replace('\\n+', "\n", $contents);
			$contents = mb_ereg_replace('^\\n', null, $contents);
			$contents = mb_ereg_replace('\\n$', null, $contents);
			$contents = mb_ereg_replace(' *{ *', ' {', $contents);
			$contents = mb_ereg_replace(' *}', '}', $contents);
			$contents = mb_ereg_replace(' *: *', ':', $contents);
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
		return BSMIMEType::getType('css');
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
		return sprintf('CSSファイル "%s"', $this->getShortPath());
	}
}

/* vim:set tabstop=4: */
