<?php
/**
 * @package org.carrot-framework
 */

/**
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSEnglishValidatorTest.class.php 2448 2011-01-02 06:16:45Z pooza $
 * @abstract
 */
class BSEnglishValidatorTest extends BSTest {

	/**
	 * 実行
	 *
	 * @access public
	 */
	public function execute () {
		$this->assert('__construct', $validator = new BSEnglishValidator);
		$this->assert('execute', $validator->execute('english'));
		$this->assert('execute', $validator->execute("\n"));
		$this->assert('execute', !$validator->execute('日本語'));
	}
}

/* vim:set tabstop=4: */
