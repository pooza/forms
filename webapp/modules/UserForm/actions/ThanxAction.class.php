<?php
/**
 * Thanxアクション
 *
 * @package jp.co.b-shock.forms
 * @subpackage UserForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class ThanxAction extends BSRecordAction {
	public function initialize () {
		if ($id = $this->request['id']) {
			$this->request->removeParameter('id');
		}
		parent::initialize();
		if ($this->getRecord() && ($id != $this->getRecord()->getID())) {
			$this->getModule()->clearRecordID();
			$this->user->removeAttribute('answer');
		}
		return true;
	}

	public function execute () {
		$this->request->setAttribute('answer', $this->user->getAttribute('answer'));
		$this->user->removeAttribute('answer');
		$this->request->setAttribute('aff', $this->user->getAttribute('aff'));
		$this->user->removeAttribute('aff');
		return BSView::SUCCESS;
	}

	public function handleError () {
		if ($this->getRecord()) {
			return $this->getRecord()->redirect();
		} else {
			return $this->controller->getAction('not_found')->forward();
		}
	}
}


