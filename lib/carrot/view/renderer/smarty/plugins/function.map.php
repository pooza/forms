<?php
/**
 * @package org.carrot-framework
 * @subpackage view.renderer.smarty.plugins
 */

/**
 * GoogleMaps関数
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: function.map.php 2175 2010-06-27 07:15:45Z pooza $
 */
function smarty_function_map ($params, &$smarty) {
	$params = new BSArray($params);
	try {
		$service = new BSGoogleMapsService;
		$service->setUserAgent($smarty->getUserAgent());
		$element = $service->getElement($params['addr'], $params);
	} catch (Exception $e) {
		$element = new BSDivisionElement;
		$span = $element->addElement(new BSSpanElement);
		$span->registerStyleClass('alert');
		$span->setBody('ジオコードが取得できません。');
	}
	return $element->getContents();
}

/* vim:set tabstop=4: */
