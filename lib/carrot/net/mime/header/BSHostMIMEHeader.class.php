<?php
/**
 * @package org.carrot-framework
 * @subpackage net.mime.header
 */

/**
 * Hostヘッダ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSHostMIMEHeader.class.php 998 2009-03-20 11:16:16Z pooza $
 */
class BSHostMIMEHeader extends BSMIMEHeader {
	private $host;

	/**
	 * 実体を返す
	 *
	 * @access public
	 * @return BSDate 実体
	 */
	public function getEntity () {
		return $this->host;
	}

	/**
	 * 内容を設定
	 *
	 * @access public
	 * @param mixed $contents 内容
	 */
	public function setContents ($contents) {
		if ($contents instanceof BSHost) {
			$contents = $contents->getName();
		}
		parent::setContents($contents);
	}

	/**
	 * ヘッダの内容からパラメータを抜き出す
	 *
	 * @access protected
	 */
	protected function parseParameters () {
		parent::parseParameters();
		try {
			$this->host = new BSHost($this->contents);
		} catch (BSNetException $e) {
		}
	}
}

/* vim:set tabstop=4: */
