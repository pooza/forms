<?php
/**
 * @package org.carrot-framework
 * @subpackage config.compiler
 */

/**
 * ディレクトリレイアウト設定コンパイラ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSLayoutConfigCompiler.class.php 738 2008-12-12 00:59:09Z pooza $
 */
class BSLayoutConfigCompiler extends BSConfigCompiler {
	public function execute (BSConfigFile $file) {
		$this->clearBody();
		foreach ($file->getResult() as $name => $params) {
			foreach ($params as $key => $value) {
				$line = sprintf(
					'$this->directories[%s][%s] = %s;',
					self::quote($name),
					self::quote($key),
					self::quote($value)
				);
				$line = parent::replaceConstants($line);
				$this->putLine($line);
			}
		}
		return $this->getBody();
	}
}

/* vim:set tabstop=4: */
