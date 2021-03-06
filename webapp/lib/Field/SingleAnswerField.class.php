<?php
/**
 * @package jp.co.b-shock.forms
 */

/**
 * 単一回答フィールド
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class SingleAnswerField extends ChoiceField {
	protected $choicesGrouped;

	/**
	 * グループ化された選択肢を返す
	 *
	 * @access public
	 * @return BSArray 選択肢
	 */
	public function getGroupedChoices () {
		if (!$this->choicesGrouped) {
			$this->choicesGrouped = BSArray::create();
			$group = $this->choicesGrouped;
			$prefix = null;
			foreach (BSString::explode("\n", $this['choices']) as $choice) {
				if (BSString::isBlank($choice)) {
					continue;
				} else if (mb_ereg('^=(.*)$', $choice, $matches)) {
					$prefix = $matches[1];
					$this->choicesGrouped[$prefix] = $group = BSArray::create();
				} else if (mb_ereg('^-(.*)$', $choice, $matches)) {
					$group[self::EMPTY_VALUE] = $matches[1];
				} else {
					if (BSString::isBlank($prefix)) {
						$group[$choice] = $choice;
					} else {
						$group[$prefix . ':' . $choice] = $choice;
					}
				}
			}
		}
		return $this->choicesGrouped;
	}

	/**
	 * 統計
	 *
	 * @access public
	 * @return BSArray 統計結果
	 */
	public function getStatistics () {
		if (!$this->statistics) {
			$this->statistics = BSArray::create();

			$criteria = $this->createCriteriaSet();
			$criteria->register('field_id', $this);
			$sql = BSSQL::getSelectQueryString(
				['count(*) AS count', 'answer'],
				'registration_detail',
				$criteria,
				null,
				'answer'
			);
			foreach ($this->getDatabase()->query($sql) as $row) {
				$this->statistics[$row['answer']] = BSArray::create($row);
			}
			$this->summarizeStatistics();
		}
		return $this->statistics;
	}

	/**
	 * 全てのファイル属性
	 *
	 * @access protected
	 * @return BSArray ファイル属性の配列
	 */
	protected function getSerializableValues () {
		$values = parent::getSerializableValues();
		$values['choices_grouped'] = $this->getGroupedChoices();
		return $values;
	}
}

/* vim:set tabstop=4 */