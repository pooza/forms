<?php
/**
 * Listアクション
 *
 * @package jp.co.b-shock.forms
 * @subpackage AdminField
 * @author 小石達也 <tkoishi@b-shock.co.jp>
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
			$this->criteria = $this->createCriteriaSet();
			$this->criteria->register('form_id', $this->getModule()->getForm());
		}
		return $this->criteria;
	}

	public function getRows () {
		if (!$this->rows) {
			$this->rows = new BSArray;
			foreach ($this->getTable() as $record) {
				$values = $record->getAttributes();
				$values['has_statistics'] = !!$record->getChoices()->count();
				$values['is_file'] = $record->isFile();
				$this->rows[] = $values;
			}
		}
		return $this->rows;
	}

	public function execute () {
		$this->request->setAttribute('fields', $this->getRows());
		return BSView::INPUT;
	}
}

/* vim:set tabstop=4: */
