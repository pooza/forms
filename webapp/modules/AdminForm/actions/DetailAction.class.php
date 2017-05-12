<?php
/**
 * Detailアクション
 *
 * @package jp.co.b-shock.forms
 * @subpackage AdminForm
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
			'email' => $this->request['email'],
			'pc_form_template' => $this->request['pc_form_template'],
			'pc_confirm_template' => $this->request['pc_confirm_template'],
			'pc_thanx_template' => $this->request['pc_thanx_template'],
			'mobile_form_template' => $this->request['mobile_form_template'],
			'mobile_confirm_template' => $this->request['mobile_confirm_template'],
			'mobile_thanx_template' => $this->request['mobile_thanx_template'],
			'smartphone_form_template' => $this->request['smartphone_form_template'],
			'smartphone_confirm_template' => $this->request['smartphone_confirm_template'],
			'smartphone_thanx_template' => $this->request['smartphone_thanx_template'],
			'thanx_mail_template' => $this->request['thanx_mail_template'],
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
		return BSView::INPUT;
	}

	public function handleError () {
		return $this->getDefaultView();
	}
}

