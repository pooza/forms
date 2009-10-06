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
			'status' => $this->request['status'],
		);
	}

	public function execute () {
		try {
			$this->database->beginTransaction();
			foreach (FormHandler::getAttachmentNames() as $name) {
				if ($info = $this->request[$name]) {
					$file = new BSFile($info['tmp_name']);
					$this->getRecord()->setAttachment($file, $info['name'], $name);
				}
			}
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
		return BSView::INPUT;
	}

	public function registerValidators () {
		$manager = BSValidateManager::getInstance();
		if ($this->request['status'] == 'show') {
			if (!$this->getRecord()->getAttachmentInfo('form_template')) {
				$manager->register('form_template', new BSEmptyValidator);
			}
			if (!$this->getRecord()->getAttachmentInfo('confirm_template')) {
				$manager->register('confirm_template', new BSEmptyValidator);
			}
			if (!$this->getRecord()->getAttachmentInfo('thanx_template')) {
				$manager->register('thanx_template', new BSEmptyValidator);
			}
		}
	}

	public function handleError () {
		return $this->getDefaultView();
	}
}

/* vim:set tabstop=4: */
