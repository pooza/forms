<?php
/**
 * @package org.carrot-framework
 * @subpackage view.renderer.smarty.plugins
 */

/**
 * 翻訳修飾子
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: modifier.translate.php 1079 2009-04-18 17:44:45Z pooza $
 */
function smarty_modifier_translate ($value, $dictionary = null, $language = null) {
	if (is_array($value)) {
		return $value;
	} else if ($value instanceof BSParameterHolder) {
		return $value->getParameters();
	} else if (!BSString::isBlank($value)) {
		return BSTranslateManager::getInstance()->execute($value, $dictionary, $language);
	}
}

/* vim:set tabstop=4: */
