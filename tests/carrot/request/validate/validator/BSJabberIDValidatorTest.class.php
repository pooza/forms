<?php
/**
 * @package org.carrot-framework
 */

/**
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSJabberIDValidatorTest.class.php 2448 2011-01-02 06:16:45Z pooza $
 * @abstract
 */
class BSJabberIDValidatorTest extends BSTest {

	/**
	 * 実行
	 *
	 * @access public
	 */
	public function execute () {
		$this->assert('__construct', $validator = new BSJabberIDValidator);
		$this->assert('execute', $validator->execute('tatsuya.koishi@gmail.com'));
		$this->assert('execute', $validator->execute('tatsuya.koishi@gmail.com/Home'));
		$this->assert('execute', !$validator->execute('tatsuya.koishi@gmail.com&&&&'));
	}
}

/* vim:set tabstop=4: */
