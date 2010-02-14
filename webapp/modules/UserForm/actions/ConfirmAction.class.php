<?php
/**
 * Confirmアクション
 *
 * @package jp.co.commons.forms
 * @subpackage UserForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class ConfirmAction extends BSRecordAction {
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
		return BSView::INPUT;
	}

	public function handleError () {
		if ($this->getRecord()) {
			return $this->getRecord()->redirect();
		} else {
			return $this->controller->getAction('not_found')->forward();
		}
	}

	public function validate () {
		return (parent::validate() && $this->user->getAttribute('answer'));
	}
}

/* vim:set tabstop=4: */

