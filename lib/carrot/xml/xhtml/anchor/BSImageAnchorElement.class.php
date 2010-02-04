<?php
/**
 * @package org.carrot-framework
 * @subpackage xml.xhtml.anchor
 */

/**
 * 画像へのリンク
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSImageAnchorElement.class.php 1812 2010-02-03 15:15:09Z pooza $
 * @abstract
 */
abstract class BSImageAnchorElement extends BSAnchorElement {

	/**
	 * グループ名を設定
	 *
	 * @access public
	 * @param string $group グループ名
	 * @abstract
	 */
	abstract public function setImageGroup ($group);

	/**
	 * キャプションを設定
	 *
	 * @access public
	 * @param string $caption キャプション
	 */
	public function setCaption ($caption) {
		$this->setAttribute('title', $caption);
	}

	/**
	 * リンク対象画像を設定
	 *
	 * @access public
	 * @param BSImageContainer $record 対象レコード
	 * @param string $size サイズ名
	 * @param integer $pixel ピクセル数
	 * @param integer $flags フラグのビット列
	 *   self::WITHOUT_BROWSER_CACHE クエリー末尾に乱数を加え、ブラウザキャッシュを無効にする
	 *   self::WIDTH_FIXED 幅固定
	 *   self::HEIGHT_FIXED 高さ固定
	 *   self::WITHOUT_SQUARE 正方形に整形しない
	 *   self::FORCE_GIF gif形式を強制
	 * @return BSURL URL
	 */
	public function setImage (BSImageContainer $record, $size, $pixel = null, $flags = null) {
		$this->setURL(
			BSImageCacheHandler::getInstance()->getURL($record, $size, $pixel, $flags)
		);
	}
}

/* vim:set tabstop=4: */
