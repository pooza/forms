<?php
/**
 * @package org.carrot-framework
 * @subpackage view.renderer.smarty.plugins
 */

/**
 * qrcode修飾子
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: modifier.truncate.php 1102 2009-04-26 07:06:58Z pooza $
 */
function smarty_modifier_qrcode ($value) {
	$url = BSURL::getInstance(null, 'BSCarrotURL');
	$url['module'] = 'Default';
	$url['action'] = 'QRCode';
	$url->setParameter('value', $value);

	$element = new BSImageElement;
	$element->setURL($url);
	return $element->getContents();
}

/* vim:set tabstop=4: */
