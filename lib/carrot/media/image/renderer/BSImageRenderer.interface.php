<?php
/**
 * @package org.carrot-framework
 * @subpackage media.image.renderer
 */

/**
 * 画像レンダラー
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSImageRenderer.interface.php 1916 2010-03-19 02:06:30Z pooza $
 */
interface BSImageRenderer extends BSRenderer {

	/**
	 * GDイメージリソースを返す
	 *
	 * @access public
	 * @return resource GDイメージリソース
	 */
	public function getGDHandle ();

	/**
	 * 幅を返す
	 *
	 * @access public
	 * @return integer 幅
	 */
	public function getWidth ();

	/**
	 * 高さを返す
	 *
	 * @access public
	 * @return integer 高さ
	 */
	public function getHeight ();
}

/* vim:set tabstop=4: */
