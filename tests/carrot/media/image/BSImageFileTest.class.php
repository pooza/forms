<?php
/**
 * @package org.carrot-framework
 */

/**
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSImageFileTest.class.php 2286 2010-08-17 14:07:35Z pooza $
 * @abstract
 */
class BSImageFileTest extends BSTest {

	/**
	 * 実行
	 *
	 * @access public
	 */
	public function execute () {
		$dir = BSFileUtility::getDirectory('root');
		$src = $dir->getEntry('www/carrotlib/images/button/pictogram.gif', 'BSImageFile');
		$dest = BSFileUtility::getTemporaryFile('ico');
		$dest->setContents($src->getContents());
		$this->assert('__construct', $dest = new BSImageFile($dest->getPath(), 'BSImagickImage'));
		$this->assert('setType', !$dest->getRenderer()->setType('image/x-ico'));
		$this->assert('getType', $dest->getRenderer()->getType() == 'image/x-ico');
		$dest->getRenderer()->resize(57, 57);
		$this->assert('getWidth', $dest->getRenderer()->getWidth() == 57);
		$this->assert('getHeight', $dest->getRenderer()->getHeight() == 57);
		$dest->save();
		$dest->delete();
	}
}

/* vim:set tabstop=4: */
