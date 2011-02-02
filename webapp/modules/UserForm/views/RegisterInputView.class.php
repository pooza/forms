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
		$record = $this->getModule()->getRecord();
		if ($this->useragent->isSmartPhone() && $record['smartphone_form_template']) {
			$this->setTemplate($record->getTemplate('smartphone_form'));
		} else if ($this->useragent->isMobile() && $record['mobile_form_template']) {
			$this->setTemplate($record->getTemplate('mobile_form'));
		} else {
			$this->setTemplate($record->getTemplate('pc_form'));
		}
		$this->translator->register($record, BSArray::POSITION_TOP);
	}
}

/* vim:set tabstop=4: */
