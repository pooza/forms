<?php
/**
 * @package org.carrot-framework
 * @subpackage view.renderer.smarty.plugins
 */

/**
 * UserAgent種別修飾子
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: modifier.sanitize.php 1079 2009-04-18 17:44:45Z pooza $
 */
function smarty_modifier_user_agent_type ($value) {
	if (is_array($value)) {
		return $value;
	} else if ($value instanceof BSParameterHolder) {
		return $value->getParameters();
	} else if (!BSString::isBlank($value)) {
		if ($useragent = BSUserAgent::getInstance($value)) {
			return $useragent->getType();
		}
	}
}

/* vim:set tabstop=4: */
