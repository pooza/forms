<?php
/**
 * SummarySuccessViewビュー
 *
 * @package org.carrot-framework
 * @subpackage AdminMemcache
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: SummarySuccessView.class.php 1812 2010-02-03 15:15:09Z pooza $
 */
class SummarySuccessView extends BSSmartyView {
	public function execute () {
		$this->setAttribute('styleset', 'carrot.Detail');
	}
}

/* vim:set tabstop=4: */
