<?php
/**
 * @package org.carrot-framework
 * @subpackage view.renderer.vcard
 */

/**
 * 複数の名刺を含むvCardレンダラー
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSMultiVCardRenderer.class.php 1472 2009-09-11 13:32:25Z pooza $
 */
class BSMultiVCardRenderer extends BSArray implements BSRenderer {
	private $contents;

	/**
	 * 要素を設定
	 *
	 * @access public
	 * @param string $name 名前
	 * @param mixed $value 要素
	 * @param boolean $position 先頭ならTrue
	 */
	public function setParameter ($name, $value, $position = self::POSITION_BOTTOM) {
		if (!($value instanceof BSVCardRenderer)) {
			throw new BSViewException(
				'%sに%sは加えられません。',
				get_class($this),
				get_class($value)
			);
		}
		parent::setParameter($name, $value, $position);
	}

	/**
	 * 出力内容を返す
	 *
	 * @access public
	 */
	public function getContents () {
		if (!$this->contents) {
			foreach ($this as $vcard) {
				$this->contents .= $vcard->getContents() . "\r\n";
			}
		}
		return $this->contents;
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
		return BSMIMEType::getType('vcf');
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
