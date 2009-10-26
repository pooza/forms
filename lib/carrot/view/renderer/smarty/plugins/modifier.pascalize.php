<?php
/**
 * @package org.carrot-framework
 * @subpackage view.renderer.smarty.plugins
 */

/**
 * pascalize修飾子
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: modifier.pascalize.php 1585 2009-10-26 07:47:39Z pooza $
 */
function smarty_modifier_pascalize ($value) {
	if (is_array($value)) {
		return $value;
	} else if ($value instanceof BSParameterHolder) {
		return $value->getParameters();
	} else if (!BSString::isBlank($value)) {
		return BSString::pascalize($value);
	}
	return $value;
}

/* vim:set tabstop=4: */
