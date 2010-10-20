<?php
/**
 * RegisterInputビュー
 *
 * @package jp.co.commons.forms
 * @subpackage UserForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class RegisterInputView extends BSSmartyView {
	public function execute () {
		if ($this->useragent->isMobile() || $this->useragent->isSmartPhone()) {
			$template = 'mobile_form';
		} else {
			$template = 'form';
		}
		$this->setTemplate($this->getModule()->getRecord()->getTemplateFile($template));
		$this->translator->register($this->getModule()->getRecord(), BSArray::POSITION_TOP);
	}
}

/* vim:set tabstop=4: */
