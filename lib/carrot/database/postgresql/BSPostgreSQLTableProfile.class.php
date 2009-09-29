<?php
/**
 * @package org.carrot-framework
 * @subpackage database.postgresql
 */

/**
 * PostgreSQLテーブルのプロフィール
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSPostgreSQLTableProfile.class.php 738 2008-12-12 00:59:09Z pooza $
 */
class BSPostgreSQLTableProfile extends BSTableProfile {

	/**
	 * テーブルのフィールドリストを配列で返す
	 *
	 * @access public
	 * @return string[][] フィールドのリスト
	 */
	public function getFields () {
		if (!$this->fields) {
			$query = BSSQL::getSelectQueryString(
				'column_name,data_type,character_maximum_length,is_nullable,column_default',
				'information_schema.columns',
				$this->getCriteria(),
				'ordinal_position'
			);
			$this->fields = $this->database->query($query)->fetchAll();
		}
		return $this->fields;
	}

	/**
	 * テーブルの制約リストを配列で返す
	 *
	 * @access public
	 * @return string[][] 制約のリスト
	 */
	public function getConstraints () {
		if (!$this->constraints) {
			$query = BSSQL::getSelectQueryString(
				'constraint_name AS name,constraint_type AS type',
				'information_schema.table_constraints',
				$this->getCriteria(),
				'constraint_type=' . $this->database->quote('PRIMARY KEY') . ',constraint_name'
			);
			foreach ($this->database->query($query)->fetchAll() as $row) {
				$criteria = $this->getCriteria();
				$criteria[] = 'constraint_name=' . $this->database->quote($row['name']);
				$query = BSSQL::getSelectQueryString(
					'column_name',
					'information_schema.key_column_usage',
					$criteria,
					'ordinal_position'
				);
				if ($row['fields'] = $this->database->query($query)->fetchAll()) {
					$this->constraints[$row['name']] = $row;
				}
			}
		}
		return $this->constraints;
	}

	/**
	 * 抽出条件を返す
	 *
	 * @access protected
	 * @return string[] 抽出条件
	 */
	protected function getCriteria () {
		return array(
			'table_name=' . $this->database->quote($this->getName()),
		);
	}
}

/* vim:set tabstop=4: */
