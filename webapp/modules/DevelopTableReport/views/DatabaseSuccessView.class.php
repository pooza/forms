<?php
/**
 * DatabaseSuccessビュー
 *
 * @package org.carrot-framework
 * @subpackage DevelopTableReport
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: DatabaseSuccessView.class.php 738 2008-12-12 00:59:09Z pooza $
 */
class DatabaseSuccessView extends BSSmartyView {
	public function execute () {
		$this->setAttribute('styleset', 'carrot.Detail');
	}
}

/* vim:set tabstop=4: */
