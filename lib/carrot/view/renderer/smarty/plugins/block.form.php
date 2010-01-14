<?php
/**
 * @package org.carrot-framework
 * @subpackage view.renderer.smarty.plugins
 */

/**
 * form要素
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: block.form.php 1660 2009-12-09 10:49:20Z pooza $
 */
function smarty_block_form ($params, $contents, &$smarty) {
	$params = new BSArray($params);
	$useragent = $smarty->getUserAgent();
	$form = new BSFormElement(null, $useragent);
	$form->setBody($contents);

	if (BSString::isBlank($params['method'])) {
		$params['method'] = 'POST';
	}
	if (!!$params['send_submit_values']) {
		$form->addSubmitFields();
	}
	$form->setMethod($params['method']);
	if ($params['attachable'] && (!$useragent->isMobile() || $useragent->isAttachable())) {
		$form->setAttachable(true);
		if (!BSString::isBlank($size = $params['attachment_size'])) {
			$form->addHiddenField('MAX_FILE_SIZE', $size * 1024 * 1024);
		}
	}
	$form->setAction($params);

	$params->removeParameter('scheme');
	$params->removeParameter('method');
	$params->removeParameter('attachable');
	$params->removeParameter('path');
	$params->removeParameter('module');
	$params->removeParameter('action');
	$form->setAttributes($params);

	return $form->getContents();
}

/* vim:set tabstop=4: */
