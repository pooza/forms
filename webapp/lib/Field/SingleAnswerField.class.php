<?php
/**
 * @package jp.co.commons.forms
 */

/**
 * 単一回答フィールド
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class SingleAnswerField extends ChoiceField {

	/**
	 * 統計
	 *
	 * @access public
	 * @return BSArray 統計結果
	 */
	public function getStatistics () {
		if (!$this->statistics) {
			$this->statistics = new BSArray;

			$db = $this->getTable()->getDatabase();
			$criteria = $db->createCriteriaSet();
			$criteria->register('field_id', $this);
			$sql = BSSQL::getSelectQueryString(
				array('count(*) AS count', 'answer'),
				'registration_detail',
				$criteria,
				null,
				'answer'
			);
			foreach ($db->query($sql) as $row) {
				$this->statistics[$row['answer']] = new BSArray($row);
			}
			$this->summarizeStatistics();
		}
		return $this->statistics;
	}
}

/* vim:set tabstop=4 */