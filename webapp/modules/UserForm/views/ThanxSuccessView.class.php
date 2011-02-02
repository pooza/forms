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
		$record = $this->getModule()->getRecord();
		if ($this->useragent->isSmartPhone() && $record['smartphone_thanx_template']) {
			$this->setTemplate($record->getTemplate('smartphone_thanx'));
		} else if ($this->useragent->isMobile() && $record['mobile_thanx_template']) {
			$this->setTemplate($record->getTemplate('mobile_thanx'));
		} else {
			$this->setTemplate($record->getTemplate('pc_thanx'));
		}
		$this->translator->register($record, BSArray::POSITION_TOP);

		$this->setAttribute('has_image', $this->user->getAttribute('has_image'));
	}
}

/* vim:set tabstop=4: */
