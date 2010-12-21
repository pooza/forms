<?php
/**
 * Listアクション
 *
 * @package jp.co.commons.forms
 * @subpackage AdminRegistration
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class ListAction extends BSPaginateTableAction {

	/**
	 * ページサイズを返す
	 *
	 * @access public
	 * @return integer ページサイズ
	 */
	protected function getPageSize () {
		return 20;
	}

	/**
	 * ソート順を返す
	 *
	 * @access protected
	 * @return string[] ソート順
	 */
	protected function getOrder () {
		return 'create_date DESC';
	}

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

			if (!BSString::isBlank($key = $this->request['key'])) {
				$this->criteria['key'] = $this->createCriteriaSet();
				$this->criteria['key']->setGlue('OR');
				foreach ($this->getModule()->getForm()->getFields() as $field) {
					$name = new BSStringFormat('a%02d');
					$name[] = $field->getID();
					$this->criteria['key']->register(
						$name->getContents(),
						'%' . $key . '%',
						'LIKE'
					);
				}
			}
		}
		return $this->criteria;
	}

	public function execute () {
		$this->request->setAttribute('registrations', $this->getRows());
		return BSView::INPUT;
	}

	public function handleError () {
		return $this->controller->getAction('not_found')->redirect();
	}

	public function validate () {
		return (parent::validate() && $this->getModule()->getForm());
	}
}

/* vim:set tabstop=4: */
