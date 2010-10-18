<?php
/**
 * Thanxアクション
 *
 * @package jp.co.commons.forms
 * @subpackage UserForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
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

/* vim:set tabstop=4: */

