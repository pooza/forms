<?php
/**
 * @package org.carrot-framework
 * @subpackage database.table
 */

/**
 * ソート可能なテーブル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSSortableTableHandler.class.php 1584 2009-10-26 07:41:43Z pooza $
 * @abstract
 */
abstract class BSSortableTableHandler extends BSTableHandler {

	/**
	 * @access public
	 * @param mixed $criteria 抽出条件
	 * @param mixed $order ソート順
	 */
	public function __construct ($criteria = null, $order = null) {
		if (!$order) {
			$order = array(
				$this->getRankField(),
				$this->getKeyField(),
			);
			$order = implode(',', $order);
		}
		parent::__construct($criteria, $order);
	}

	/**
	 * レコード追加可能か？
	 *
	 * @access protected
	 * @return boolean レコード追加可能ならTrue
	 */
	protected function isInsertable () {
		return true;
	}

	/**
	 * オートインクリメントのテーブルか？
	 *
	 * @access public
	 * @return boolean オートインクリメントならTrue
	 */
	public function isAutoIncrement () {
		return true;
	}

	/**
	 * レコード追加
	 *
	 * @access public
	 * @param mixed[] $values 値
	 * @param integer $flags フラグのビット列
	 *   BSDatabase::WITH_LOGGING ログを残さない
	 * @return string レコードの主キー
	 */
	public function createRecord ($values, $flags = BSDatabase::WITH_LOGGING) {
		$values['create_date'] = BSDate::getNow('Y-m-d H:i:s');
		$values['update_date'] = BSDate::getNow('Y-m-d H:i:s');
		$values[$this->getRankField()] = $this->getNextRank();
		return parent::createRecord($values, $flags);
	}

	/**
	 * 次の順位を返す
	 *
	 * @access public
	 * @return integer 順位
	 */
	public function getNextRank () {
		$sql = BSSQL::getSelectQueryString(
			'max(' . $this->getRankField() . ') as last_rank',
			$this->getName(),
			$this->getCriteria()
		);
		$row = $this->getDatabase()->query($sql)->fetch();
		return $row['last_rank'] + 1;
	}

	/**
	 * 順位フィールド名
	 *
	 * @access public
	 * @return string 順位フィールド名
	 */
	public function getRankField () {
		return 'rank';
	}

	/**
	 * 状態フィールド名
	 *
	 * @access public
	 * @return string 状態フィールド名
	 */
	public function getStatusField () {
		return 'status';
	}

	/**
	 * 順位をクリア
	 *
	 * @access public
	 */
	public function clearRanks () {
		if (!$criteria = $this->getCriteria()) {
			$criteria = $this->getKeyField() . ' IS NOT NULL';
		}

		$sql = BSSQL::getUpdateQueryString(
			$this->getName(),
			array($this->getRankField() => 0),
			$criteria
		);
		BSDatabase::getInstance()->exec($sql);
	}
}

/* vim:set tabstop=4: */

