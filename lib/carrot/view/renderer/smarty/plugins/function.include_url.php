<?php
/**
 * @package org.carrot-framework
 * @subpackage view.renderer.smarty.plugins
 */

/**
 * 外部コンテンツをインクルード
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: function.include_url.php 1812 2010-02-03 15:15:09Z pooza $
 */
function smarty_function_include_url ($params, &$smarty) {
	$params = new BSArray($params);

	if (BSString::isBlank($params['src'])) {
		$url = BSURL::getInstance($params, 'carrot');
	} else {
		$url = BSURL::getInstance($params['src']);
	}
	if (!$url) {
		return null;
	}

	if (!$url['host']->isForeign(BSController::getInstance()->getHost())) {
		if ($useragent = $smarty->getUserAgent()) {
			$url->setParameters($useragent->getQuery());
		}
	}
	return $url->fetch();
}

/* vim:set tabstop=4: */
