<?php
/**
 * @package org.carrot-framework
 * @subpackage view.renderer.smarty.plugins
 */

/**
 * キャッシュ画像関数
 *
 * BSImageCacheHandlerのフロントエンド
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: function.image_cache.php 1807 2010-02-03 03:45:49Z pooza $
 */
function smarty_function_image_cache ($params, &$smarty) {
	$caches = BSImageCacheHandler::getInstance();
	$params = new BSArray($params);
	$flags = $caches->convertFlags($params['flags']);
	if (!$container = $caches->getContainer($params)) {
		return null;
	} else if (!$info = $container->getImageInfo($params['size'], $params['pixel'], $flags)) {
		return null;
	}

	$element = $caches->getImageElement($info);
	$element->registerStyleClass($params['style_class']);
	$element->setID($params['container_id']);

	switch ($mode = BSString::toLower($params['mode'])) {
		case 'size':
			return $info['pixel_size'];
		case 'pixel_size':
		case 'width':
		case 'height':
		case 'url':
			return $info[$mode];
		case 'lightbox':
		case 'thickbox':
		case 'multibox':
			$anchor = BSClassLoader::getInstance()->getObject($mode, 'AnchorElement');
			$element = $element->wrap($anchor);
			$element->setImageGroup($params['group']);
			$element->setCaption($info['alt']);
			$flags = $caches->convertFlags($params['flags_full']);
			$element->setImage($container, $params['size'], $params['pixel_full'], $flags);
			break;
	}
	return $element->getContents();
}

/* vim:set tabstop=4: */
