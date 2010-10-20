<?php
/**
 * ThanxSuccessビュー
 *
 * @package jp.co.commons.forms
 * @subpackage UserForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class ThanxSuccessView extends BSSmartyView {
	public function execute () {
		if ($this->useragent->isMobile() || $this->useragent->isSmartPhone()) {
			$template = 'mobile_thanx';
		} else {
			$template = 'thanx';
		}
		$this->setTemplate($this->getModule()->getRecord()->getTemplateFile($template));
		$this->translator->register($this->getModule()->getRecord(), BSArray::POSITION_TOP);

		$this->setAttribute('has_image', $this->user->getAttribute('has_image'));
	}
}

/* vim:set tabstop=4: */
