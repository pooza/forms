<?php
/**
 * PingSuccessビュー
 *
 * @package org.carrot-framework
 * @subpackage Default
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: PingSuccessView.class.php 1420 2009-09-03 10:10:44Z pooza $
 */
class PingSuccessView extends BSView {
	public function execute () {
		$this->setStatus(200);
		$this->setRenderer(new BSPlainTextRenderer);
		$this->renderer->setContents('OK');
	}
}

/* vim:set tabstop=4: */
