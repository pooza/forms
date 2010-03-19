<?php
/**
 * @package org.carrot-framework
 * @subpackage media.image.resizer
 */

/**
 * ImageMagick画像リサイズ機能
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSImagickImageResizer.class.php 1914 2010-03-18 13:35:15Z pooza $
 */
class BSImagickImageResizer extends BSImageResizer {
	private $file;

	/**
	 * @access public
	 */
	public function __destruct () {
		if ($file = $this->file) {
			$file->delete();
		}
	}

	/**
	 * 実行
	 *
	 * @access public
	 * @param integer $width 幅
	 * @param integer $height 高さ
	 * @return BSImage リサイズ後のレンダラー
	 */
	public function execute ($width, $height) {
		$dest = new BSImagickImage($width, $height);
		if ($this->source->getAspect() < $dest->getAspect()) {
			$width = $dest->getHeight() * $this->source->getAspect();
			$x = BSNumeric::round(($dest->getWidth() - $width) / 2);
			$coord = $dest->getCoordinate($x, 0);
		} else {
			$height = $dest->getWidth() / $this->source->getAspect();
			$y = BSNumeric::round(($dest->getHeight() - $height) / 2);
			$coord = $dest->getCoordinate(0, $y);
		}

		$resized = clone $this->source->getImagick();
		$resized->thumbnailImage($width, $height, true);
		$dest->getImagick()->compositeImage(
			$resized,
			Imagick::COMPOSITE_DEFAULT,
			$coord->getX(), $coord->getY()
		);
		return $dest;
	}
}

/* vim:set tabstop=4: */
