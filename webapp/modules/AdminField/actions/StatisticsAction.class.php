<?php
/**
 * Statisticsアクション
 *
 * @package jp.co.b-shock.forms
 * @subpackage AdminField
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class StatisticsAction extends BSRecordAction {
	public function execute () {
		$this->request->setAttribute('statistics', $this->getRecord()->getStatistics());
		$this->request->setAttribute('form', $this->getModule()->getForm());
		return BSView::SUCCESS;
	}

	public function handleError () {
		return $this->controller->getAction('not_found')->redirect();
	}

	public function validate () {
		return parent::validate() && ($this->getRecord() instanceof ChoiceField);
	}
}

/* vim:set tabstop=4: */
