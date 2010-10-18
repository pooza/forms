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
	public function initialize () {
		if ($id = $this->request['id']) {
			$this->setRecordID($id);
		}
		foreach ($this->request->getParameters() as $key => $value) {
			if ($value == ChoiceField::EMPTY_VALUE) {
				$this->request[$key] = null;
			}
		}
		$this->request->setAttribute('form', $this->getRecord());
		$this->request->setAttribute('styleset', 'carrot.Detail');
		return true;
	}

	public function execute () {
		$answer = BSValidateManager::getInstance()->getFieldValues();
		foreach ($this->getRecord()->getFields() as $field) {
			if ($field->isFile()) {
				if ($info = $answer[$field->getName()]) {
					$file = $field->setTemporaryFile(new BSFile($info['tmp_name']));
					$info['tmp_name'] = $file->getPath();
					$info['field_type'] = $field->getFieldType()->getID();
					$answer[$field->getName()] = $info;
					if ($file instanceof BSImageContainer) {
						$file->clearImageCache();
					}
				} else {
					$field->clearTemporaryFile();
				}
			}
		}
		$this->user->setAttribute('answer', $answer);
		return $this->getRecord()->getURL('Confirm')->redirect();
	}

	public function getDefaultView () {
		if (!$this->getRecord() || !$this->getRecord()->isVisible()) {
			return $this->controller->getAction('not_found')->forward();
		}
		if ($answer = $this->user->getAttribute('answer')) {
			$this->request->setParameters($answer);
		} else if (!$this->request['submit']) {
			foreach ($this->getRecord()->getFields() as $field) {
				if (!!$field->getChoices()->count()) {
					$choice = $field->getChoices()->getIterator()->getFirst();
					$this->request[$field->getName()] = $choice;
				}
			}
		}
		foreach ($this->getRecord()->getFields() as $field) {
			if ($field->isFile()) {
				$field->clearTemporaryFile();
			}
		}

		$aff = new BSArray($this->user->getAttribute('aff'));
		foreach (array('s') as $key) {
			if (!BSString::isBlank($value = $this->request[$key])) {
				$aff[$key] = $value;
			}
		}
		$this->user->setAttribute('aff', $aff);

		return BSView::INPUT;
	}

	public function handleError () {
		if ($this->request->hasError('cookie')) {
			return $this->controller->getAction('cookie_disabled')->forward();
		}
		return $this->getDefaultView();
	}

	public function registerValidators () {
		if ($record = $this->getRecord()) {
			$record->registerValidators();
		}
	}
}

/* vim:set tabstop=4: */
