<?php
/**
 * @package org.carrot-framework
 * @subpackage config.file
 */

/**
 * ルート設定ファイル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSRootConfigFile.class.php 759 2008-12-31 09:34:29Z pooza $
 */
class BSRootConfigFile extends BSConfigFile {
	private $compiler;

	/**
	 * コンパイラを返す
	 *
	 * @access public
	 * @return BSConfigCompiler コンパイラ
	 */
	public function getCompiler () {
		if (!$this->compiler) {
			$this->compiler = new BSObjectRegisterConfigCompiler;
		}
		return $this->compiler;
	}
}

/* vim:set tabstop=4: */
