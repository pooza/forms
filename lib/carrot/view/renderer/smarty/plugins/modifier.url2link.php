<?php
/**
 * @package org.carrot-framework
 * @subpackage view.renderer.smarty.plugins
 */

/**
 * URL変換修飾子
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: modifier.url2link.php 1622 2009-11-19 07:42:56Z pooza $
 */
function smarty_modifier_url2link ($value) {
	if (is_array($value)) {
		return $value;
	} else if ($value instanceof BSParameterHolder) {
		return $value->getParameters();
	} else if (!BSString::isBlank($value)) {
		return mb_ereg_replace(
			'https?://[-_.!~*\'()a-zA-Z0-9;/?:@&=+$,%#]+',
			'<a href="\\0" target="_blank">\\0</a>',
			$value
		);
	}
}

/* vim:set tabstop=4: */
