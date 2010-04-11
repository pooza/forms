<?php
/**
 * @package org.carrot-framework
 * @subpackage controller
 */

/**
 * コンソールコントローラー
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSConsoleController.class.php 1985 2010-04-11 02:18:21Z pooza $
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
}

/* vim:set tabstop=4: */
