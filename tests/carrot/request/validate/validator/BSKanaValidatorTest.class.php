<?php
/**
 * @package org.carrot-framework
 */

/**
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSKanaValidatorTest.class.php 2448 2011-01-02 06:16:45Z pooza $
 * @abstract
 */
class BSKanaValidatorTest extends BSTest {

	/**
	 * 実行
	 *
	 * @access public
	 */
	public function execute () {
		$this->assert('__construct', $validator = new BSKanaValidator);
		$this->assert('execute', $validator->execute('アイウエオ'));
		$this->assert('execute', $validator->execute('あいうえお'));
		$this->assert('execute', !$validator->execute('english'));
		$this->assert('execute', $validator->execute("\n"));
	}
}

/* vim:set tabstop=4: */
