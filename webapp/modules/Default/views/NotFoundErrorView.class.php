<?php
/**
 * NotFoundErrorビュー
 *
 * @package org.carrot-framework
 * @subpackage Default
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: NotFoundErrorView.class.php 1812 2010-02-03 15:15:09Z pooza $
 */
class NotFoundErrorView extends BSSmartyView {
	public function execute () {
		$this->setStatus(404);
	}
}

/* vim:set tabstop=4: */
