<?php
/**
 * @package org.carrot-framework
 * @subpackage controller
 */

/**
 * コンソールコントローラー
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSConsoleController.class.php 1973 2010-04-07 02:27:22Z pooza $
 */
class BSConsoleController extends BSController {

	/**
	 * @access protected
	 */
	protected function __construct () {
		parent::__construct();
		if (BSString::isBlank($this->request[self::MODULE_ACCESSOR])) {
			$this->request[self::MODULE_ACCESSOR] = 'Console';
		}
	}

	/**
	 * @access public
	 */
	public function __clone () {
		throw new BadFunctionCallException(__CLASS__ . 'はコピーできません。');
	}
}

/* vim:set tabstop=4: */
