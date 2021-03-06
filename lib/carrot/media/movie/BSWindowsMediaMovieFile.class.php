<?php
/**
 * @package jp.co.b-shock.carrot
 * @subpackage media.movie
 */

/**
 * WindowsMedia動画ファイル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class BSWindowsMediaMovieFile extends BSMovieFile {

	/**
	 * 表示用のXHTML要素を返す
	 *
	 * @access public
	 * @param BSParameterHolder $params パラメータ配列
	 * @param BSUserAgent $useragent 対象ブラウザ
	 * @return BSDivisionElement 要素
	 */
	public function createElement (BSParameterHolder $params, BSUserAgent $useragent = null) {
		switch ($params['mode']) {
			case 'shadowbox':
				return $this->createShadowboxElement($params);
			case 'lity':
				return $this->createLityElement($params);
		}

		$params = BSArray::create($params);
		$this->resizeByWidth($params, $useragent);
		$container = new BSDivisionElement;
		$container->registerStyleClass($params['style_class']);
		$container->setStyles($this->getStyles($params));
		$object = $container->addElement(new BSWindowsMediaObjectElement);
		$object->setAttribute('type', $this->getType());
		$object->setAttribute('width', $params['width']);
		$object->setAttribute('height', $params['height']);
		$object->setURL($this->createURL($params));
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

