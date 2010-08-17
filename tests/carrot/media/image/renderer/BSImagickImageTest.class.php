<?php
/**
 * @package org.carrot-framework
 */

/**
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSImagickImageTest.class.php 2286 2010-08-17 14:07:35Z pooza $
 * @abstract
 */
class BSImagickImageTest extends BSTest {

	/**
	 * 実行
	 *
	 * @access public
	 */
	public function execute () {
		$this->assert('__construct', $image = new BSImagickImage());
		$this->assert('getGDHandle', is_resource($image->getGDHandle()));
		$this->assert('resize', !$image->resize(16, 16));
		$this->assert('getWidth', $image->getWidth() == 16);
		$this->assert('getHeight', $image->getHeight() == 16);
		$this->assert('setType', !$image->setType('image/x-ico'));
		$this->assert('getType', $image->getType() == 'image/x-ico');
	}
}

/* vim:set tabstop=4: */
