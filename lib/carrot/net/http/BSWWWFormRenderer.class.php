<?php
/**
 * @package org.carrot-framework
 * @subpackage net.http
 */

/**
 * WWWフォームレンダラー
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSWWWFormRenderer.class.php 1346 2009-07-22 08:41:47Z pooza $
 */
class BSWWWFormRenderer extends BSParameterHolder implements BSRenderer {

	/**
	 * 出力内容を返す
	 *
	 * @access public
	 */
	public function getContents () {
		return http_build_query($this->getParameters());
	}

	/**
	 * 出力内容を設定
	 *
	 * @param mixed $contents 出力内容
	 * @access public
	 */
	public function setContents ($contents) {
		$this->clear();
		if (BSArray::isArray($contents)) {
			$this->setParameters($contents);
		} else {
			parse_str($contents, $this->parameters);
		}
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
	 * メディアタイプを返す
	 *
	 * @access public
	 * @return string メディアタイプ
	 */
	public function getType () {
		return 'application/x-www-form-urlencoded';
	}

	/**
	 * 出力可能か？
	 *
	 * @access public
	 * @return boolean 出力可能ならTrue
	 */
	public function validate () {
		return true;
	}

	/**
	 * エラーメッセージを返す
	 *
	 * @access public
	 * @return string エラーメッセージ
	 */
	public function getError () {
		return null;
	}
}

/* vim:set tabstop=4: */
