<?php
/**
 * @package org.carrot-framework
 */

/**
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSUtilityTest.class.php 2434 2010-11-22 12:48:48Z pooza $
 * @abstract
 */
class BSUtilityTest extends BSTest {

	/**
	 * 実行
	 *
	 * @access public
	 */
	public function execute () {
		$this->assert('isPathAbsolute_1', BSUtility::isPathAbsolute('/etc/hosts'));
		$this->assert('isPathAbsolute_2', !BSUtility::isPathAbsolute('www/.htaccess'));
		$this->assert('getUniqueID', BSUtility::getUniqueID() != BSUtility::getUniqueID());
		$this->assert('includeFile_1', !BSUtility::includeFile('spyc'));
		$this->assert('includeFile_2', !BSUtility::includeFile(
			new BSFile(BS_LIB_DIR . '/jsmin.php')
		));
		$this->assert('executeMethod_1', BSUtility::executeMethod(
			'BSUtility', 'isPathAbsolute', array('/etc/hosts')
		));
		$this->assert('executeMethod_2', !BSUtility::executeMethod(
			'BSUtility', 'isPathAbsolute', array('www/.htaccess')
		));
	}
}

/* vim:set tabstop=4: */
