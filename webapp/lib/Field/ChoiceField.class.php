<?php
/**
 * @package jp.co.b-shock.forms
 */

/**
 * 選択フィールド
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @abstract
 */
abstract class ChoiceField extends Field {
	protected $choices;
	protected $statistics;
	const EMPTY_VALUE = '__EMPTY__';

	/**
	 * バリデータ登録
	 *
	 * @access public
	 */
	public function registerValidators () {
		$manager = BSValidateManager::getInstance();
		if ($this['required']) {
			$params = array('required_msg' => '選ばれていません。');
			$manager->register($this->getName(), new BSEmptyValidator($params));
			$params = array('max' => 256);
			$manager->register($this->getName(), new BSStringValidator($params));
		}

		$choices = clone $this->getChoices();
		$choices->removeParameter(self::EMPTY_VALUE);
		$params = array('choices' => $choices, 'choices_error' => '空欄、又は正しくありません。');
		$manager->register($this->getName(), new BSChoiceValidator($params));
	}

	/**
	 * 選択肢を返す
	 *
	 * @access public
	 * @return BSArray 選択肢
	 */
	public function getChoices () {
		if (!$this->choices) {
			$this->choices = new BSArray;
			$prefix = null;
			foreach (BSString::explode("\n", $this['choices']) as $choice) {
				if (BSString::isBlank($choice)) {
					continue;
				} else if (mb_ereg('^=(.*)$', $choice, $matches)) {
					$prefix = $matches[1] . ':';
				} else if (mb_ereg('^-(.*)$', $choice, $matches)) {
					$this->choices[self::EMPTY_VALUE] = $matches[1];
				} else {
					$value = $prefix . $choice;
					$this->choices[$value] = $value;
				}
			}
			$this->choices->uniquize();
		}
		return $this->choices;
	}

	/**
	 * 統計を集計
	 *
	 * @access protected
	 */
	protected function summarizeStatistics () {
		if (!$this->statistics) {
			$this->getStatistics();
		}

		$total = $this->getForm()->getRegistrations()->count();
		foreach ($this->statistics as $row) {
			$row['percentage'] = $row['count'] / $total;
		}
		$this->statistics->sort();
	}

	/**
	 * 全てのファイル属性
	 *
	 * @access protected
	 * @return BSArray ファイル属性の配列
	 */
	protected function getSerializableValues () {
		$values = parent::getSerializableValues();
		$values['choices'] = $this->getChoices();
		return $values;
	}
}

/* vim:set tabstop=4 */