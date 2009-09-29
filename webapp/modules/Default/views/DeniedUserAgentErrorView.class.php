<?php
/**
 * DeniedUserAgentErrorビュー
 *
 * @package org.carrot-framework
 * @subpackage Default
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: DeniedUserAgentErrorView.class.php 1435 2009-09-05 12:44:09Z pooza $
 */
class DeniedUserAgentErrorView extends BSSmartyView {
	public function execute () {
		$this->setStatus(400);
	}
}

/* vim:set tabstop=4: */
