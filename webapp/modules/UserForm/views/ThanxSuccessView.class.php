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
		$this->setTemplate($this->getModule()->getRecord()->getTemplateFile('thanx'));
		$this->translator->register($this->getModule()->getRecord());
	}
}

/* vim:set tabstop=4: */