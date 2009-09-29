<?php
/**
 * @package org.carrot-framework
 * @subpackage view.renderer.smarty.plugins
 */

/**
 * 定数関数
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: function.const.php 1074 2009-04-18 09:42:46Z pooza $
 */
function smarty_function_const ($params, &$smarty) {
	return BSConstantHandler::getInstance()->getParameter($params['name']);
}

/* vim:set tabstop=4: */
