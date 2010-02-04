<?php
/**
 * @package org.carrot-framework
 * @subpackage net.mime.header
 */

/**
 * User-Agentヘッダ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSUserAgentMIMEHeader.class.php 1812 2010-02-03 15:15:09Z pooza $
 */
class BSUserAgentMIMEHeader extends BSMIMEHeader {
	private $useragent;

	/**
	 * 実体を返す
	 *
	 * @access public
	 * @return BSUserAgent 実体
	 */
	public function getEntity () {
		return $this->useragent;
	}

	/**
	 * 内容を設定
	 *
	 * @access public
	 * @param mixed $contents 内容
	 */
	public function setContents ($contents) {
		if ($contents instanceof BSUserAgent) {
			$contents = $contents->getName();
		}
		parent::setContents($contents);
	}

	/**
	 * ヘッダの内容からパラメータを抜き出す
	 *
	 * @access protected
	 */
	protected function parse () {
		parent::parse();
		try {
			$this->useragent = BSUserAgent::getInstance($this->contents);
		} catch (BSNetException $e) {
		}
	}
}

/* vim:set tabstop=4: */
