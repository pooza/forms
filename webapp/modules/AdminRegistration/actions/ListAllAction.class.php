<?php
/**
 * ListAllアクション
 *
 * @package jp.co.b-shock.forms
 * @subpackage AdminRegistration
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class ListAllAction extends BSAction {
	public function execute () {
		$this->getModule()->clearParameterCache();
		return $this->getModule()->redirect();
	}
}

