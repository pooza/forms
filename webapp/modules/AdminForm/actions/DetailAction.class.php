<?php
/**
 * Detailアクション
 *
 * @package jp.co.commons.forms
 * @subpackage AdminForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class DetailAction extends BSRecordAction {

	/**
	 * レコードのフィールド値を配列で返す
	 *
	 * @access protected
	 * @return mixed[] フィールド値の連想配列
	 */
	protected function getRecordValues () {
		return array(
			'name' => $this->request['name'],
			'email' => $this->request['email'],
			'status' => $this->request['status'],
		);
	}

	public function execute () {
		try {
			$this->database->beginTransaction();
			$this->updateRecord();
			$this->database->commit();
		} catch (Exception $e) {
			$this->database->rollBack();
			$this->request->setError($this->getTable()->getName(), $e->getMessage());
			return $this->handleError();
		}
		return $this->redirect();
	}

	public function getDefaultView () {
		if (!$this->getRecord()) {
			return $this->controller->getAction('not_found')->redirect();
		}
		return BSView::INPUT;
	}

	public function registerValidators () {
		$manager = BSValidateManager::getInstance();
		if ($this->request['status'] == 'show') {
			foreach (array('form', 'confirm', 'thanx', 'thanx_mail') as $name) {
				if (!$this->getRecord()->getAttachmentInfo($name . '_template')) {
					$manager->register($name . '_template', new BSEmptyValidator);
				}
			}
		}
	}

	public function handleError () {
		return $this->getDefaultView();
	}
}

/* vim:set tabstop=4: */
