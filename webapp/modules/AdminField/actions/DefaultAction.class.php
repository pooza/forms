<?php
/**
 * Defaultアクション
 *
 * @package jp.co.b-shock.forms
 * @subpackage AdminField
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class DefaultAction extends BSAction {
	public function execute () {
		return $this->getModule()->getAction('List')->forward();
	}
}

/* vim:set tabstop=4: */
