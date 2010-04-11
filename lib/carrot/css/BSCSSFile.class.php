<?php
/**
 * @package org.carrot-framework
 * @subpackage css
 */

/**
 * CSSファイル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSCSSFile.class.php 1990 2010-04-11 07:17:52Z pooza $
 */
class BSCSSFile extends BSFile {

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
	 * シリアライズ
	 *
	 * @access public
	 */
	public function serialize () {
		$renderer = new BSPlainTextRenderer;
		$renderer->setContents(mb_ereg_replace('/\\*.*?\\*/', null, $this->getContents()));
		$contents = null;
		foreach ($renderer as $line) {
			$contents .= trim($line) . "\n";
		}
		$contents = mb_ereg_replace('\\n+', "\n", $contents);
		$contents = mb_ereg_replace('^\\n', null, $contents);
		$contents = mb_ereg_replace('\\n$', null, $contents);
		$contents = mb_ereg_replace('[[ \\t]]*{[[ \\t]]*', ' {', $contents);
		$contents = mb_ereg_replace('[[ \\t]]*}', '}', $contents);
		$contents = mb_ereg_replace('[[ \\t]]*:[[ \\t]]*', ':', $contents);
		BSController::getInstance()->setAttribute($this, $contents);
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
