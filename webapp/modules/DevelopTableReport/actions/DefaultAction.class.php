<?php
/**
 * Defaultアクション
 *
 * @package org.carrot-framework
 * @subpackage DevelopTableReport
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: DefaultAction.class.php 738 2008-12-12 00:59:09Z pooza $
 */
class DefaultAction extends BSAction {
	public function execute () {
		return $this->getModule()->getAction('DatabaseList')->forward();
	}
}

/* vim:set tabstop=4: */
