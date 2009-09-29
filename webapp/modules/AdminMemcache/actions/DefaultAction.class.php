<?php
/**
 * Defaultアクション
 *
 * @package org.carrot-framework
 * @subpackage AdminMemcache
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: DefaultAction.class.php 956 2009-03-07 09:15:54Z pooza $
 */
class DefaultAction extends BSAction {
	public function execute () {
		return $this->getModule()->getAction('Summary')->forward();
	}
}

/* vim:set tabstop=4: */
