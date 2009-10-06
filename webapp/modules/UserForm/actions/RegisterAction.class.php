<?php
/**
 * Registerアクション
 *
 * @package jp.co.commons.forms
 * @subpackage UserForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class RegisterAction extends BSRecordAction {
	public function execute () {
		$this->user->setAttribute('answer', BSValidateManager::getInstance()->getFieldValues());
		return $this->getModule()->getAction('Confirm')->redirect();
	}

	public function getDefaultView () {
		if (!$this->getRecord() || !$this->getRecord()->isVisible()) {
			return $this->controller->getNotFoundAction()->forward();
		}
		if ($answer = $this->user->getAttribute('answer')) {
			$this->request->setParameters($params);
		}
		return BSView::INPUT;
	}

	public function handleError () {
		return $this->getDefaultView();
	}

	public function registerValidators () {
		$this->getRecord()->registerValidators();
	}
}

/* vim:set tabstop=4: */
