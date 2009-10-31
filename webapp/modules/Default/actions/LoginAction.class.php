<?php
/**
 * Loginアクション
 *
 * @package jp.co.commons.forms
 * @subpackage Default
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class LoginAction extends BSAction {
	private function auth (BSUserIdentifier $role) {
		$email = BSMailAddress::getInstance($this->request['email']);
		if ($email->getContents() == $role->getMailAddress()->getContents()) {
			if ($this->user->login($role, $this->request['password'])) {
				return true;
			}
		}
		return false;
	}

	public function execute () {
		if ($this->auth(BSAdministratorRole::getInstance())) {
			$this->user->addCredential('AdminEdit');
		}
		if ($this->auth(BSAuthorRole::getInstance())) {
			$this->user->addCredential(BSAdministratorRole::CREDENTIAL);
		}

		if (!$this->user->hasCredential(BSAdministratorRole::CREDENTIAL)) {
			$this->request->setError('password', '認証に失敗しました。');
			return $this->handleError();
		}

		if (!BSString::isBlank($url = $this->user->getAttribute('RequestURL'))) {
			$url = BSURL::getInstance($url);
			$this->user->removeAttribute('RequestURL');
		} else {
			$url = BSURL::getInstance($this->controller->getAttribute('ROOT_URL_HTTPS'));
			$url['path'] = '/AdminForm/';
		}
		return $url->redirect();
	}

	public function getDefaultView () {
		//$this->user->clearAttributes();
		//$this->user->clearCredentials();
		return BSView::INPUT;
	}

	public function handleError () {
		return $this->getDefaultView();
	}
}

/* vim:set tabstop=4: */
