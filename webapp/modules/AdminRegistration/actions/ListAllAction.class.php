<?php
/**
 * ListAllアクション
 *
 * @package jp.co.commons.forms
 * @subpackage AdminRegistration
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class ListAllAction extends BSAction {
	public function execute () {
		$this->getModule()->clearParameterCache();
		return $this->getModule()->redirect();
	}
}

/* vim:set tabstop=4: */
