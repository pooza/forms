<?php
/**
 * @package org.carrot-framework
 * @subpackage view.renderer.smarty.plugins
 */

/**
 * バイナリサイズ修飾子
 *
 * ファイルサイズ等に利用。
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: modifier.binary_size_format.php 1119 2009-04-28 12:47:26Z pooza $
 */
function smarty_modifier_binary_size_format ($value) {
	if (is_array($value)) {
		return $value;
	} else if ($value instanceof BSParameterHolder) {
		return $value->getParameters();
	} else if (!BSString::isBlank($value)) {
		return BSNumeric::getBinarySize($value);
	}
}

/* vim:set tabstop=4: */
