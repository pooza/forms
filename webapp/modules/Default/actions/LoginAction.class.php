<?php
/**
 * Loginアクション
 *
 * @package jp.co.b-shock.forms
 * @subpackage Default
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class LoginAction extends BSAction {
	private function auth (BSUserIdentifier $role) {
		$email = BSMailAddress::create($this->request['email']);
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
			$url = BSURL::create($url);
			$this->user->removeAttribute('RequestURL');
		} else {
			$url = BSModule::getInstance('AdminForm')->createURL();
		}
		return $url->redirect();
	}

	public function getDefaultView () {
		$this->user->logout();
		return BSView::INPUT;
	}

	public function handleError () {
		return $this->getDefaultView();
	}
}

