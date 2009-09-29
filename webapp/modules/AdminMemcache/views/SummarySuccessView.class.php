<?php
/**
 * SummarySuccessViewビュー
 *
 * @package org.carrot-framework
 * @subpackage AdminMemcache
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: SummarySuccessView.class.php 956 2009-03-07 09:15:54Z pooza $
 */
class SummarySuccessView extends BSSmartyView {
	public function execute () {
		$this->setAttribute('styleset', 'carrot.Detail');
	}
}

/* vim:set tabstop=4: */
