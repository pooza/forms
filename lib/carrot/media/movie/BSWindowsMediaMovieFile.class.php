<?php
/**
 * @package org.carrot-framework
 * @subpackage media.movie
 */

/**
 * WindowsMedia動画ファイル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSWindowsMediaMovieFile.class.php 1981 2010-04-09 03:24:07Z pooza $
 */
class BSWindowsMediaMovieFile extends BSMovieFile {

	/**
	 * ムービー表示用のXHTML要素を返す
	 *
	 * @access public
	 * @param BSParameterHolder $params パラメータ配列
	 * @return BSDivisionElement 要素
	 */
	public function getElement (BSParameterHolder $params) {
		$container = new BSDivisionElement;
		$container->registerStyleClass($params['style_class']);
		$container->setStyles($this->getStyles($params));
		$object = $container->addElement(new BSWindowsMediaObjectElement);
		$object->setAttribute('type', $this->getType());
		$object->setAttribute('width', $params['width']);
		$object->setAttribute('height', $params['height']);
		$object->setURL($this->getMediaURL($params));
		return $container;
	}

	/**
	 * プレイヤーの高さを返す
	 *
	 * @access public
	 * @return integer プレイヤーの高さ
	 */
	public function getPlayerHeight () {
		return BS_MOVIE_WMV_PLAYER_HEIGHT;
	}

	/**
	 * @access public
	 * @return string 基本情報
	 */
	public function __toString () {
		return sprintf('WindowsMedia動画ファイル "%s"', $this->getShortPath());
	}
}

/* vim:set tabstop=4: */
