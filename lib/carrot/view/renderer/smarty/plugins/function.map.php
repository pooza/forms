<?php
/**
 * @package org.carrot-framework
 * @subpackage view.renderer.smarty.plugins
 */

/**
 * GoogleMaps関数
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: function.map.php 1889 2010-02-28 10:52:44Z pooza $
 */
function smarty_function_map ($params, &$smarty) {
	$params = new BSArray($params);
	$service = new BSGoogleMapsService;
	if (!$geocode = $service->getGeocode($params['addr'])) {
		throw new BSGeocodeException('ジオコードが取得できません。');
	}

	$params['id'] = 'map_' . BSCrypt::getDigest($params['addr']);
	$element = BSGoogleMapsService::getScriptElement($geocode, $params);
	return $element->getContents();
}

/* vim:set tabstop=4: */
