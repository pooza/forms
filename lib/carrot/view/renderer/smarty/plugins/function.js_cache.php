<?php
/**
 * @package org.carrot-framework
 * @subpackage view.renderer.smarty.plugins
 */

/**
 * JavaScriptキャッシュ関数
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: function.js_cache.php 1773 2010-01-24 05:10:09Z pooza $
 */
function smarty_function_js_cache ($params, &$smarty) {
	$params = new BSArray($params);
	if (BSString::isBlank($params['name'])) {
		$params['name'] = 'carrot';
	}

	if (!$jsset = new BSJavaScriptSet($params['name'])) {
		return;
	}

	$url = BSURL::getInstance();
	$url['path'] =  '/carrotlib/js/cache/' . $jsset->getCacheFile()->getName();

	$element = new BSScriptElement;
	$element->setAttribute('src', $url->getContents());

	return $element->getContents();
}

/* vim:set tabstop=4: */
