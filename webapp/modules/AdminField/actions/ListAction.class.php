<?php
/**
 * Listアクション
 *
 * @package jp.co.commons.forms
 * @subpackage AdminField
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class ListAction extends BSTableAction {

	/**
	 * 検索条件を返す
	 *
	 * @access protected
	 * @return string[] 検索条件
	 */
	protected function getCriteria () {
		if (!$this->criteria) {
			$this->criteria = $this->getTable()->getDatabase()->createCriteriaSet();
			$this->criteria->register('form_id', $this->getModule()->getForm());
		}
		return $this->criteria;
	}

	public function execute () {
		$this->request->setAttribute('fields', $this->getRows());
		return BSView::INPUT;
	}
}

/* vim:set tabstop=4: */
