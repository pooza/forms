<?php
/**
 * @package jp.co.commons.forms
 */

/**
 * 選択フィールド
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 * @abstract
 */
abstract class ChoiceField extends Field {
	protected $choices;
	protected $choicesGrouped;
	protected $statistics;

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
		$params = array('choices' => $this->getChoices());
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
	 * グループ化された選択肢を返す
	 *
	 * @access public
	 * @return BSArray 選択肢
	 */
	public function getGroupedChoices () {
		if (!$this->choicesGrouped) {
			$this->choicesGrouped = new BSArray;
			$group = $this->choicesGrouped;
			$prefix = null;
			foreach (BSString::explode("\n", $this['choices']) as $choice) {
				if (BSString::isBlank($choice)) {
					continue;
				} else if (mb_ereg('^=(.*)$', $choice, $matches)) {
					$prefix = $matches[1];
					$this->choicesGrouped[$prefix] = $group = new BSArray;
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
	protected function getFullAttributes () {
		$values = parent::getFullAttributes();
		$values['choices'] = $this->getChoices();
		$values['choices_grouped'] = $this->getGroupedChoices();
		return $values;
	}
}

/* vim:set tabstop=4 */