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
		$this->setTemplate($this->getModule()->getRecord()->getTemplateFile('confirm'));
		$this->translator->register($this->getModule()->getRecord()->getFields());
	}
}

/* vim:set tabstop=4: */
