<?php
/**
 * ConfirmInputビュー
 *
 * @package jp.co.commons.forms
 * @subpackage UserForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class ConfirmInputView extends BSSmartyView {
	public function execute () {
		$this->setAttribute('answer', $this->user->getAttribute('answer'));
		if ($this->useragent->isMobile()) {
			$template = 'mobile_confirm';
		} else {
			$template = 'confirm';
		}
		$this->setTemplate($this->getModule()->getRecord()->getTemplateFile($template));
		$this->translator->register($this->getModule()->getRecord(), BSArray::POSITION_TOP);
	}
}

/* vim:set tabstop=4: */
