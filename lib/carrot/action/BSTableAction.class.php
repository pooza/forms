<?php
/**
 * @package org.carrot-framework
 * @subpackage action
 */

/**
 * 一覧画面用 アクションひな形
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSTableAction.class.php 1555 2009-10-14 04:12:56Z pooza $
 * @abstract
 */
abstract class BSTableAction extends BSAction {
	protected $criteria;
	protected $order;
	protected $rows;
	protected $table;
	protected $page;

	/**
	 * 初期化
	 *
	 * Falseを返すと、例外が発生。
	 *
	 * @access public
	 * @return boolean 正常終了ならTrue
	 */
	public function initialize () {
		parent::initialize();
		$this->getModule()->clearRecordID();

		$params = $this->getDefaultParameters();
		$params->setParameters($this->getModule()->getParameterCache());
		$params->setParameters($this->request->getParameters());

		$this->request->setParameters($params->getParameters());
		$this->getModule()->setParameterCache($params);

		$this->assignStatusOptions();

		return true;
	}

	/**
	 * タイトルを返す
	 *
	 * @access public
	 * @return string タイトル
	 */
	public function getTitle () {
		if (BSString::isBlank($this->title)) {
			if (BSString::isBlank($this->title = $this->getConfig('title'))) {
				try {
					$this->title = $this->getModule()->getRecordClassName('ja') . '一覧';
				} catch (Exception $e) {
					$this->title = $this->getName();
				}
			}
		}
		return $this->title;
	}

	/**
	 * テーブルを返す
	 *
	 * @access public
	 * @return BSTableHandler テーブル
	 */
	public function getTable () {
		if (!$this->table) {
			$this->table = clone $this->getModule()->getTable();
			$this->table->setCriteria($this->getCriteria());
			$this->table->setOrder($this->getOrder());
		}
		return $this->table;
	}

	/**
	 * テーブルの内容を返す
	 *
	 * @access protected
	 * @return BSArray テーブルの内容
	 */
	protected function getRows () {
		if (!$this->isShowable()) {
			return array();
		}

		if (!$this->rows) {
			$this->rows = new BSArray;
			foreach ($this->getTable() as $record) {
				$this->rows[] = $record->getAttributes();
			}
		}
		return $this->rows;
	}

	/**
	 * デフォルトの検索条件を返す
	 *
	 * @access protected
	 * @return BSArray 検索条件
	 */
	protected function getDefaultParameters () {
		return new BSArray;
	}

	/**
	 * 検索条件を返す
	 *
	 * @access protected
	 * @return string[] 検索条件
	 */
	protected function getCriteria () {
		return array();
	}

	/**
	 * ソート順を返す
	 *
	 * @access protected
	 * @return string[] ソート順
	 */
	protected function getOrder () {
		return array();
	}

	/**
	 * リストを表示するか
	 *
	 * @access protected
	 * @return boolean 表示して良いならTrue
	 */
	protected function isShowable () {
		return !$this->request->hasErrors();
	}
}

/* vim:set tabstop=4: */
