<?php
/**
 * DatabaseSuccessビュー
 *
 * @package org.carrot-framework
 * @subpackage DevelopTableReport
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: DatabaseSuccessView.class.php 1812 2010-02-03 15:15:09Z pooza $
 */
class DatabaseSuccessView extends BSSmartyView {
	public function execute () {
		$this->setAttribute('styleset', 'carrot.Detail');
	}
}

/* vim:set tabstop=4: */
