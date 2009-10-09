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
			$params = array('max' => 2048);
			$manager->register($this->getName(), new BSStringValidator($params));
		}
		$params = array('choices' => $this->getChoices());
		$manager->register($this->getName(), new BSChoiceValidator($params));
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
}

/* vim:set tabstop=4 */