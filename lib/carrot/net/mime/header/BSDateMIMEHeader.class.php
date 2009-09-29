<?php
/**
 * @package org.carrot-framework
 * @subpackage net.mime.header
 */

/**
 * Dateヘッダ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSDateMIMEHeader.class.php 1195 2009-05-16 11:46:01Z pooza $
 */
class BSDateMIMEHeader extends BSMIMEHeader {
	private $date;

	/**
	 * 実体を返す
	 *
	 * @access public
	 * @return BSDate 実体
	 */
	public function getEntity () {
		return $this->date;
	}

	/**
	 * 内容を設定
	 *
	 * @access public
	 * @param mixed $contents 内容
	 */
	public function setContents ($contents) {
		if ($contents instanceof BSDate) {
			$contents = $contents->format('r');
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
		$this->date = BSDate::getInstance($this->contents);
	}
}

/* vim:set tabstop=4: */
