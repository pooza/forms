<?php
/**
 * Detailアクション
 *
 * @package jp.co.b-shock.forms
 * @subpackage AdminRegistration
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class DetailAction extends BSRecordAction {

	/**
	 * タイトルを返す
	 *
	 * @access public
	 * @return string タイトル
	 */
	public function getTitle () {
		return '応募:' . $this->getRecord()->getID();
	}

	public function execute () {
		$this->request->setAttribute('form', $this->getModule()->getForm());
		return BSView::SUCCESS;
	}

	public function handleError () {
		return $this->controller->getAction('not_found')->redirect();
	}

	public function validate () {
		return parent::validate() && $this->getModule()->getForm();
	}

	public function deny () {
		$this->user->setAttribute('RequestURL', $this->request->getURL()->getContents());
		return parent::deny();
	}
}

