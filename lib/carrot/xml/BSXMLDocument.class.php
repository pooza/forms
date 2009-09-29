<?php
/**
 * @package org.carrot-framework
 * @subpackage xml
 */

/**
 * 整形式XML文書
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSXMLDocument.class.php 890 2009-02-21 13:59:40Z pooza $
 */
class BSXMLDocument extends BSXMLElement implements BSTextRenderer {
	private $error;

	/**
	 * メディアタイプを返す
	 *
	 * @access public
	 * @return string メディアタイプ
	 */
	public function getType () {
		return BSMIMEType::getType('xml');
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
	 * 出力内容のサイズを返す
	 *
	 * @access public
	 * @return integer サイズ
	 */
	public function getSize () {
		return strlen($this->getContents());
	}

	/**
	 * 内容をXMLで返す
	 *
	 * @access public
	 * @return string XML文書
	 */
	public function getContents () {
		$xml = new DOMDocument('1.0', 'utf-8');
		$xml->loadXML('<?xml version="1.0" encoding="utf-8" ?>' . parent::getContents());
		$xml->formatOutput = true;
		$xml->normalizeDocument();
		return $xml->saveXML();
	}

	/**
	 * 妥当な要素か？
	 *
	 * @access public
	 * @return boolean 妥当な要素ならTrue
	 */
	public function validate () {
		if (!parent::getContents()) {
			$this->error = '妥当なXML文書ではありません。';
			return false;
		}
		return true;
	}

	/**
	 * エラーメッセージを返す
	 *
	 * @access public
	 * @return string エラーメッセージ
	 */
	public function getError () {
		return $this->error;
	}
}

/* vim:set tabstop=4: */
