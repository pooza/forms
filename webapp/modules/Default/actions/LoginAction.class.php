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
	public function execute () {
		$this->user->addCredential(BSAdministratorRole::CREDENTIAL);
		if (BS_DEBUG) {
			$this->user->addCredential('Develop');
		}

		if (!BSString::isBlank($url = $this->user->getAttribute('RequestURL'))) {
			$url = BSURL::getInstance($url);
			$this->user->removeAttribute('RequestURL');
		} else {
			$url = BSURL::getInstance($this->controller->getConstant('ROOT_URL_HTTPS'));
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

	public function validate () {
		$role = BSAdministratorRole::getInstance();
		$email = BSMailAddress::getInstance($this->request['email']);
		if ($email->getContents() != $role->getMailAddress()->getContents()) {
			$this->request->setError('email', 'ユーザー又はパスワードが違います。');
		} else if (!$this->user->login($role, $this->request['password'])) {
			$this->request->setError('password', 'ユーザー又はパスワードが違います。');
		}
		return !$this->request->hasErrors();
	}
}

/* vim:set tabstop=4: */
