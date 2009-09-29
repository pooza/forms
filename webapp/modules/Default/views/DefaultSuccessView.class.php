<?php
/**
 * DefaultSuccessビュー
 *
 * @package org.carrot-framework
 * @subpackage Default
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: DefaultSuccessView.class.php 738 2008-12-12 00:59:09Z pooza $
 */
class DefaultSuccessView extends BSSmartyView {
	public function execute () {
		$this->setTemplate($this->request['document']);
	}
}

/* vim:set tabstop=4: */
