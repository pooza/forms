<?php
/**
 * Commitアクション
 *
 * @package jp.co.b-shock.forms
 * @subpackage UserForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class CommitAction extends BSRecordAction {
	public function execute () {
		try {
			$this->database->beginTransaction();
			$answer = new BSArray($this->user->getAttribute('answer'));
			$registration = $this->getRecord()->registerAnswer($answer);
			$registration->sendMail('thanx_mail');
			$registration->sendMail('Registration.registered');
			$this->database->commit();

			$this->user->setAttribute('has_image', !!$answer['image']['name']);
			$this->user->setAttribute('regid', $registration->getID());
			//$this->user->removeAttribute('answer');
		} catch (BSDatabaseException $e) {
			$this->database->rollback();
			return $this->handleError();
		} catch (BSMailException $e) {
			$this->database->rollback();
			return $this->handleError();
		}
		return $this->getRecord()->getURL('Thanx')->redirect();
	}

	public function getDefaultView () {
		return $this->handleError();
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

