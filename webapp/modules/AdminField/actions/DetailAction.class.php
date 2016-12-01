<?php
/**
 * Detailアクション
 *
 * @package jp.co.b-shock.forms
 * @subpackage AdminField
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class DetailAction extends BSRecordAction {

	/**
	 * レコードのフィールド値を配列で返す
	 *
	 * @access protected
	 * @return mixed[] フィールド値の連想配列
	 */
	protected function getRecordValues () {
		return [
			'name' => $this->request['name'],
			'label' => $this->request['label'],
			'field_type_id' => $this->request['field_type_id'],
			'choices' => $this->request['choices'],
			'required' => (int)$this->request['required'],
			'has_confirm_field' => (int)$this->request['has_confirm_field'],
			'status' => $this->request['status'],
		];
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
		$this->request->setAttribute('form', $this->getModule()->getForm());
		return BSView::INPUT;
	}

	public function handleError () {
		return $this->getDefaultView();
	}
}

/* vim:set tabstop=4: */
