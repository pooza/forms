<?php
/**
 * NotFoundErrorビュー
 *
 * @package org.carrot-framework
 * @subpackage Default
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: NotFoundErrorView.class.php 1435 2009-09-05 12:44:09Z pooza $
 */
class NotFoundErrorView extends BSSmartyView {
	public function execute () {
		$this->setStatus(404);
	}
}

/* vim:set tabstop=4: */
