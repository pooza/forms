<?php
/**
 * Defaultアクション
 *
 * @package org.carrot-framework
 * @subpackage Default
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: DefaultAction.class.php 1220 2009-05-24 12:40:47Z pooza $
 */
class DefaultAction extends BSAction {
	public function execute () {
		return BSView::SUCCESS;
	}

	public function handleError () {
		$url = BSURL::getInstance();
		$url['path'] = BS_HOME_HREF;
		return $url->redirect();
	}

	public function validate () {
		return $this->request->hasParameter('document');
	}
}

/* vim:set tabstop=4: */
