<?php
/**
 * @package org.carrot-framework
 * @subpackage view.renderer.smarty.plugins
 */

/**
 * 年齢修飾子
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: modifier.date2age.php 1763 2010-01-18 01:14:33Z pooza $
 */
function smarty_modifier_date2age ($value) {
	if (is_array($value)) {
		return $value;
	} else if ($value instanceof BSParameterHolder) {
		return $value->getParameters();
	} else if (!BSString::isBlank($value)) {
		if ($date = BSDate::getInstance($value)) {
			return $date->getAge();
		}
	}
}

/* vim:set tabstop=4: */
