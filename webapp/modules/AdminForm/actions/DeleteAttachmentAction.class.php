<?php
/**
 * DeleteAttachmentアクション
 *
 * @package jp.co.b-shock.forms
 * @subpackage AdminForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class DeleteAttachmentAction extends BSRecordAction {
	public function execute () {
		if ($file = $this->getRecord()->getAttachment($this->request['name'])) {
			$file->delete();
			$this->getRecord()->touch();
		}

		$url = $this->getModule()->getAction('Detail')->createURL();
		$url->setParameter('pane', 'DetailForm');
		return $url->redirect();
	}

	public function handleError () {
		return $this->controller->getAction('not_found')->forward();
	}
}

/* vim:set tabstop=4: */
