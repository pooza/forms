<?php
/**
 * Commitアクション
 *
 * @package jp.co.commons.forms
 * @subpackage UserForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class CommitAction extends BSRecordAction {
	public function execute () {
		try {
			$this->database->beginTransaction();
////////////
			$this->database->commit();
		} catch (BSDatabaseException $e) {
			$this->database->rollback();
			return $this->handleError();
		} catch (BSMailException $e) {
			$this->database->rollback();
			return $this->handleError();
		}
		$this->user->removeAttribute('answer');
		return $this->getModule()->getAction('Thanx')->redirect();
	}

	public function getDefaultView () {
		return $this->handleError();
	}

	public function handleError () {
		return $this->getRecord()->redirect();
	}

	public function validate () {
		return (parent::validate() && $this->user->getAttribute('answer'));
	}
}

/* vim:set tabstop=4: */
