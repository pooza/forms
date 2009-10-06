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
			$account = AccountHandler::getCurrentAccount();
			$account->subscribe(
				$this->getRecord(),
				$this->user->getAttribute('answer'),
				$this->user->getAttribute('enquete')
			);
			$params = new BSArray(array(
				'form' => $this->getRecord(),
			));
			$account->sendMail('Form', $params);
			$this->database->commit();
		} catch (BSDatabaseException $e) {
			$this->database->rollback();
			return $this->handleError();
		} catch (BSMailException $e) {
			$this->database->rollback();
			return $this->handleError();
		}
		return $this->getModule()->getAction('Thanx')->redirect();
	}

	public function getDefaultView () {
		return $this->handleError();
	}

	public function handleError () {
		return $this->getRecord()->redirect();
	}

	public function validate () {
		if (AccountHandler::getCurrentAccount()->isRegisterd($this->getRecord())) {
			return false;
		} else if (!$this->user->getAttribute('answer')) {
			return false;
		}
		return true;
	}

	public function getRequestMethods () {
		return BSRequest::POST;
	}
}

/* vim:set tabstop=4: */
