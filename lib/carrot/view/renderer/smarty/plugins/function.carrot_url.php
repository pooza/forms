<?php
/**
 * @package org.carrot-framework
 * @subpackage view.renderer.smarty.plugins
 */

/**
 * CarrotアプリケーションのURLを貼り付ける関数
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: function.carrot_url.php 1812 2010-02-03 15:15:09Z pooza $
 */
function smarty_function_carrot_url ($params, &$smarty) {
	$params = new BSArray($params);

	if (BSString::isBlank($params['contents'])) {
		$url = BSURL::getInstance($params, 'carrot');
	} else {
		$url = BSURL::getInstance($params['contents']);
	}

	if ($useragent = $smarty->getUserAgent()) {
		$url->setParameters($useragent->getQuery());
	}

	return $url->getContents();
}

/* vim:set tabstop=4: */
