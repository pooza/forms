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

		$record = $this->getModule()->getRecord();
		if ($this->useragent->isSmartPhone() && $record['smartphone_confirm_template']) {
			$this->setTemplate($record->getTemplateFile('smartphone_confirm'));
		} else if ($this->useragent->isMobile() && $record['mobile_confirm_template']) {
			$this->setTemplate($record->getTemplateFile('mobile_confirm'));
		} else {
			$this->setTemplate($record->getTemplateFile('pc_confirm'));
		}
		$this->translator->register($record, BSArray::POSITION_TOP);
	}
}

/* vim:set tabstop=4: */
