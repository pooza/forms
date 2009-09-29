<?php
/**
 * @package org.carrot-framework
 * @subpackage net.mime.header
 */

/**
 * Content-Typeヘッダ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSContentTypeMIMEHeader.class.php 998 2009-03-20 11:16:16Z pooza $
 */
class BSContentTypeMIMEHeader extends BSMIMEHeader {

	/**
	 * 内容を設定
	 *
	 * @access public
	 * @param mixed $contents 内容
	 */
	public function setContents ($contents) {
		if ($contents instanceof BSRenderer) {
			$contents = self::getContentType($contents);
		} else {
			$contents = $contents;
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
		if ($this['boundary'] && $this->getPart()) {
			$this->getPart()->setBoundary($this['boundary']);
		}
		$type = BSString::explode('/', $this[0]);
		$this['main_type'] = $type[0];
		$this['sub_type'] = $type[1];
	}

	/**
	 * レンダラーの完全なタイプを返す
	 *
	 * @access public
	 * @param BSRenderer $renderer 対象レンダラー
	 * @return string メディアタイプ
	 * @static
	 */
	static public function getContentType (BSRenderer $renderer) {
		if ($renderer instanceof BSTextRenderer) {
			$encoding = $renderer->getEncoding();
			if (BSString::isBlank($charset = mb_preferred_mime_name($encoding))) {
				throw new BSMIMEException('エンコード"%s"が正しくありません。', $encoding);
			}
			return sprintf('%s; charset=%s', $renderer->getType(), $charset);
		}
		return $renderer->getType();
	}
}

/* vim:set tabstop=4: */
