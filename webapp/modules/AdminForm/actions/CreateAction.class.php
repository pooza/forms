<?php
/**
 * Createアクション
 *
 * @package jp.co.commons.forms
 * @subpackage AdminForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class CreateAction extends BSRecordAction {

	/**
	 * レコードのフィールド値を配列で返す
	 *
	 * @access protected
	 * @return mixed[] フィールド値の連想配列
	 */
	protected function getRecordValues () {
		return array(
			'name' => $this->request['name'],
			'status' => $this->request['status'],
		);
	}

	public function execute () {
		try {
			$this->database->beginTransaction();
			$this->updateRecord();
			foreach (FormHandler::getAttachmentNames() as $name) {
				if ($info = $this->request[$name]) {
					$file = new BSFile($info['tmp_name']);
					$this->getRecord()->setAttachment($file, $info['name'], $name);
				}
			}
			$this->database->commit();
		} catch (Exception $e) {
			$this->database->rollBack();
			$this->request->setError($this->getTable()->getName(), $e->getMessage());
			return $this->handleError();
		}
		return $this->getModule()->getAction('Detail')->redirect();
	}

	public function getDefaultView () {
		if (!$this->request['submit']) {
			$this->request['status'] = 'hide';
		}
		return BSView::INPUT;
	}

	public function registerValidators () {
		$manager = BSValidateManager::getInstance();
		if ($this->request['status'] == 'show') {
			foreach (array('form', 'confirm', 'thanx', 'thanx_mail') as $name) {
				$manager->register($name . '_template', new BSEmptyValidator);
			}
		}
	}

	public function handleError () {
		return $this->getDefaultView();
	}
}

/* vim:set tabstop=4: */
