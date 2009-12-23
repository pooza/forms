<?php
/**
 * @package org.carrot-framework
 * @subpackage media.movie
 */

/**
 * QuickTime動画ファイル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSQuickTimeMovieFile.class.php 1711 2009-12-23 10:05:53Z pooza $
 */
class BSQuickTimeMovieFile extends BSMovieFile {

	/**
	 * ムービー表示用のXHTML要素を返す
	 *
	 * @access public
	 * @param BSParameterHolder $params パラメータ配列
	 * @return BSXMLElement 要素
	 */
	public function getImageElement (BSParameterHolder $params) {
		$element = new BSDivisionElement;
		$element->registerStyleClass($params['style_class']);
		$element->setStyles($this->getStyles($params));
		$object = $element->addElement(new BSQuickTimeObjectElement);
		$object->setAttribute('width', $params['width']);
		$object->setAttribute('height', $params['height']);
		$object->setURL($this->getMediaURL($params));
		return $element;
	}

	/**
	 * プレイヤーの高さを返す
	 *
	 * @access public
	 * @return integer プレイヤーの高さ
	 */
	public function getPlayerHeight () {
		return BS_MOVIE_QUICKTIME_PLAYER_HEIGHT;
	}

	/**
	 * @access public
	 * @return string 基本情報
	 */
	public function __toString () {
		return sprintf('QuickTime動画ファイル "%s"', $this->getShortPath());
	}
}

/* vim:set tabstop=4: */
