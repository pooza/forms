<?php
/**
 * @package org.carrot-framework
 * @subpackage config.compiler
 */

/**
 * 絵文字用設定コンパイラ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSPictogramConfigCompiler.class.php 1086 2009-04-20 06:54:40Z pooza $
 */
class BSPictogramConfigCompiler extends BSDefaultConfigCompiler {

	/**
	 * 設定配列をシリアライズできる内容に修正
	 *
	 * @access protected
	 * @param mixed[] $config 対象
	 * @return mixed[] 変換後
	 */
	protected function getContents ($config) {
		$pictograms = array();
		foreach ((array)$config as $entry) {
			foreach ($entry['names'] as $name) {
				$pictograms['codes'][$name] = $entry['pictograms'];
				$code = $entry['pictograms'][BSMobileCarrier::DEFAULT_CARRIER];
				$pictograms['names'][$code][] = $name;
			}
		}
		return $pictograms;
	}
}

/* vim:set tabstop=4: */
