<?php
/**
 * DetailSuccessビュー
 *
 * @package jp.co.b-shock.forms
 * @subpackage AdminRegistration
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class DetailSuccessView extends BSSmartyView {
	public function execute () {
		$this->translator->register($this->getModule()->getForm(), BSArray::POSITION_TOP);
	}
}

/* vim:set tabstop=4: */
