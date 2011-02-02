<?php
/**
 * Thanxビュー
 *
 * @package jp.co.commons.forms
 * @subpackage UserForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class ThanxView extends BSSmartyView {
	public function execute () {
		if ($file = $this->getModule()->getTemplate('thanx')) {
			$this->setTemplate($file);
		}
		$this->translator->register($this->getModule()->getRecord(), BSArray::POSITION_TOP);

		$this->setAttribute('has_image', $this->user->getAttribute('has_image'));
	}
}

/* vim:set tabstop=4: */
