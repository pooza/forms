<?php
/**
 * CookieDisabledErrorビュー
 *
 * @package org.carrot-framework
 * @subpackage Default
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: CookieDisabledErrorView.class.php 1886 2010-02-28 04:45:35Z pooza $
 */
class CookieDisabledErrorView extends BSSmartyView {
	public function execute () {
		$this->setStatus(400);
	}
}

/* vim:set tabstop=4: */
