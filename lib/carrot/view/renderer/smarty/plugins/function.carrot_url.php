<?php
/**
 * @package org.carrot-framework
 * @subpackage view.renderer.smarty.plugins
 */

/**
 * CarrotアプリケーションのURLを貼り付ける関数
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: function.carrot_url.php 1641 2009-11-27 13:11:29Z pooza $
 */
function smarty_function_carrot_url ($params, &$smarty) {
	$params = new BSArray($params);

	if (BSString::isBlank($params['contents'])) {
		$url = BSURL::getInstance($params, 'BSCarrotURL');
	} else {
		$url = BSURL::getInstance($params['contents']);
	}

	if (($useragent = $smarty->getUserAgent()) && $useragent->isMobile()) {
		$url->setParameters($useragent->getAttribute('query'));
	}

	return $url->getContents();
}

/* vim:set tabstop=4: */
