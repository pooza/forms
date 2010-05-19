<?php
/**
 * @package org.carrot-framework
 * @subpackage view.renderer.smarty.plugins
 */

/**
 * GoogleAnalytics関数
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: function.analytics.php 2078 2010-05-14 07:37:54Z pooza $
 */
function smarty_function_analytics ($params, &$smarty) {
	$params = new BSArray($params);
	$service = BSGoogleAnalyticsService::getInstance();
	if ($id = $params['id']) {
		$service->setID($id);
	}
	return $service->getTrackingCode();
}

/* vim:set tabstop=4: */
