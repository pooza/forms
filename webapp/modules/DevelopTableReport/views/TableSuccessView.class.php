<?php
/**
 * TableSuccessビュー
 *
 * @package org.carrot-framework
 * @subpackage DevelopTableReport
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: TableSuccessView.class.php 851 2009-02-10 14:17:30Z pooza $
 */
class TableSuccessView extends BSSmartyView {
	public function execute () {
		$this->setAttribute('styleset', 'carrot.Detail');
	}
}

/* vim:set tabstop=4: */
