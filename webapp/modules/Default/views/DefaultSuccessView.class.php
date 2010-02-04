<?php
/**
 * DefaultSuccessビュー
 *
 * @package org.carrot-framework
 * @subpackage Default
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: DefaultSuccessView.class.php 1812 2010-02-03 15:15:09Z pooza $
 */
class DefaultSuccessView extends BSSmartyView {
	public function execute () {
		$this->setTemplate($this->request['document']);
	}
}

/* vim:set tabstop=4: */
