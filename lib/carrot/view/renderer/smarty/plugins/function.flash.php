<?php
/**
 * @package org.carrot-framework
 * @subpackage view.renderer.smarty.plugins
 */

/**
 * Flashムービー関数
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: function.flash.php 1799 2010-02-01 08:10:40Z pooza $
 */
function smarty_function_flash ($params, &$smarty) {
	$params = new BSArray($params);
	$mode = BSString::toLower($params['mode']);

	if (!$file = BSFlashUtility::getFile($params)) {
		return null;
	}

	switch ($mode) {
		case 'size':
			return $file['pixel_size'];
		case 'width':
		case 'height':
			return $file[$mode];
		default:
			if (BSString::isBlank($params['href_prefix'])) {
				if ($record = BSController::getInstance()->getModule()->searchRecord($params)) {
					$url = BSFileUtility::getURL('swf');
					$url['path'] .= $record->getTable()->getDirectory()->getName() . '/';
					$params['href_prefix'] = $url['path'];
				}
			}
			return $file->getImageElement($params)->getContents();
	}
}

/* vim:set tabstop=4: */
