<?php
/**
 * Duplicateアクション
 *
 * @package jp.co.b-shock.forms
 * @subpackage AdminForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class DuplicateAction extends BSRecordAction {
	public function execute () {
		try {
			$this->database->beginTransaction();
			$this->getRecord()->duplicate();
			$this->database->commit();
		} catch (Exception $e) {
			$this->database->rollBack();
			$this->request->setError($this->getTable()->getName(), $e->getMessage());
			return $this->getModule()->getAction('Detail')->forward();
		}
		return $this->getModule()->redirect();
	}
}

/* vim:set tabstop=4: */
