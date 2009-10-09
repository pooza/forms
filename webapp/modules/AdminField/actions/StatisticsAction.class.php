<?php
/**
 * Statisticsアクション
 *
 * @package jp.co.commons.forms
 * @subpackage AdminField
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class StatisticsAction extends BSRecordAction {
	public function execute () {
		$this->request->setAttribute('statistics', $this->getRecord()->getStatistics());
		$this->request->setAttribute('form', $this->getModule()->getForm());
		return BSView::SUCCESS;
	}

	public function handleError () {
		return $this->controller->getNotFoundAction()->redirect();
	}

	public function validate () {
		return parent::validate() && ($this->getRecord() instanceof ChoiceField);
	}
}

/* vim:set tabstop=4: */
