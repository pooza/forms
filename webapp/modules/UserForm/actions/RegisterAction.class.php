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
		$answer = BSValidateManager::getInstance()->getFieldValues();
		foreach ($this->getRecord()->getFields() as $field) {
			if ($field->isFile()) {
				if ($info = $answer[$field->getName()]) {
					$file = $field->setTemporaryFile(new BSFile($info['tmp_name']));
					$info['tmp_name'] = $file->getPath();
					$info['field_type'] = $field->getFieldType()->getID();
					$answer[$field->getName()] = $info;
				} else {
					$field->clearTemporaryFile();
				}
			}
		}
		$this->user->setAttribute('answer', $answer);
		return $this->getModule()->getAction('Confirm')->redirect();
	}

	public function getDefaultView () {
		if (!$this->getRecord() || !$this->getRecord()->isVisible()) {
			return $this->controller->getAction('not_found')->forward();
		}
		if ($answer = $this->user->getAttribute('answer')) {
			$this->request->setParameters($answer);
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
