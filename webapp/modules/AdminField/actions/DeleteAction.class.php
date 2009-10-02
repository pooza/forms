<?php
/**
 * Deleteアクション
 *
 * @package jp.co.commons.forms
 * @subpackage AdminField
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class DeleteAction extends BSRecordAction {
	public function execute () {
		try {
			$this->database->beginTransaction();
			$this->getRecord()->delete();
			$this->database->commit();
		} catch (Exception $e) {
			$this->database->rollBack();
			$this->request->setError($this->getTable()->getName(), $e->getMessage());
			return $this->getModule()->getAction('Detail')->forward();
		}

		$url = BSModule::getInstance('AdminEvent')->getAction('Detail')->getURL();
		$url->setParameter('pane', 'FieldList');
		return $url->redirect();
	}
}

/* vim:set tabstop=4: */
