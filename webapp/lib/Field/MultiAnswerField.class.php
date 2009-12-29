<?php
/**
 * @package jp.co.commons.forms
 */

/**
 * 複数回答フィールド
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class MultiAnswerField extends ChoiceField {

	/**
	 * 統計
	 *
	 * @access public
	 * @return BSArray 統計結果
	 */
	public function getStatistics () {
		if (!$this->statistics) {
			$this->statistics = new BSArray;

			$criteria = $this->createCriteriaSet();
			$criteria->register('field_id', $this);
			$sql = BSSQL::getSelectQueryString('answer', 'registration_detail', $criteria);
			foreach ($this->getDatabase()->query($sql) as $row) {
				foreach (BSString::explode("\n", $row['answer'])->trim() as $answer) {
					if (!$this->statistics[$answer]) {
						$this->statistics[$answer] = new BSArray(array(
							'answer' => $answer,
							'count' => 0,
						));
					}
					$this->statistics[$answer]['count'] += 1;
				}
			}
			$this->summarizeStatistics();
		}
		return $this->statistics;
	}
}

/* vim:set tabstop=4 */