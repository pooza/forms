<?php
/**
 * EmptySiteErrorビュー
 *
 * @package org.carrot-framework
 * @subpackage Default
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: EmptySiteErrorView.class.php 1980 2010-04-08 09:21:40Z pooza $
 */
class EmptySiteErrorView extends BSSmartyView {
	public function execute () {
		$this->setStatus(404);
	}
}

/* vim:set tabstop=4: */
