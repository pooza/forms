<?php
/**
 * @package org.carrot-framework
 * @subpackage view.renderer.smarty.plugins
 */

/**
 * ケータイ絵文字関数
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: function.picto.php 1083 2009-04-19 03:32:33Z pooza $
 */
function smarty_function_picto ($params, &$smarty) {
	$pictogram = BSPictogram::getInstance($params['name']);
	return $pictogram->getContents();
}

/* vim:set tabstop=4: */
