<?php
/**
 * @package org.carrot-framework
 * @subpackage media.image
 */

/**
 * 色
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSColor.class.php 1568 2009-10-19 10:56:07Z pooza $
 */
class BSColor extends BSParameterHolder {
	const DEFAULT_COLOR = 'black';

	/**
	 * @access public
	 * @param string $color HTML形式の色コード
	 */
	public function __construct ($color = null) {
		if (BSString::isBlank($color)) {
			$color = self::DEFAULT_COLOR;
		} else if (is_numeric($color)) {
			$color = sprintf('%06x', $color);
		}
		$this->setColor($color);
	}

	/**
	 * HTML形式の色コードを設定
	 *
	 * @access public
	 * @param string $color HTML形式の色コード
	 */
	public function setColor ($color) {
		$color = ltrim($color, '#');
		if (mb_ereg('^[[:xdigit:]]{6}$', $color)) {
			$this['red'] = hexdec($color[0] . $color[1]);
			$this['green'] = hexdec($color[2] . $color[3]);
			$this['blue'] = hexdec($color[4] . $color[5]);
		} else if (mb_ereg('^[[:xdigit:]]{3}$', $color)) {
			$this['red'] = hexdec($color[0] . $color[0]);
			$this['green'] = hexdec($color[1] . $color[1]);
			$this['blue'] = hexdec($color[2] . $color[2]);
		} else {
			$color = BSString::toLower($color);
			require(BSConfigManager::getInstance()->compile('color'));
			$colors = new BSArray($config);
			if (BSString::isBlank($code = $colors[$color])) {
				throw new BSImageException('色 "%s" は正しくありません。', $color);
			}
			$this->setColor($code);
		}
	}

	/**
	 * HTML形式の色コードを返す
	 *
	 * @access public
	 * @return string HTML形式の色コード
	 */
	public function getContents () {
		return sprintf('#%02x%02x%02x', $this['red'], $this['green'], $this['blue']);
	}
}

/* vim:set tabstop=4: */
