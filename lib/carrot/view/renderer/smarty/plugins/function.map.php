<?php
/**
 * @package org.carrot-framework
 * @subpackage view.renderer.smarty.plugins
 */

/**
 * GoogleMaps関数
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: function.map.php 1874 2010-02-18 10:33:41Z pooza $
 */
function smarty_function_map ($params, &$smarty) {
	$params = new BSArray($params);
	$service = new BSGoogleMapsService;
	if (!$geocode = $service->getGeocode($params['addr'])) {
		throw new BSGeocodeException('ジオコードが取得できません。');
	}

	$params['id'] = 'map_' . BSCrypt::getSHA1($params['addr'] . BS_CRYPT_SALT);
	$element = BSGoogleMapsService::getScriptElement($geocode, $params);
	return $element->getContents();
}

/* vim:set tabstop=4: */
