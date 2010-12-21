<?php
/**
 * @package jp.co.commons.forms
 */

/**
 * フィールドレコード
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class Field extends BSSortableRecord implements BSValidatorContainer {

	/**
	 * 親レコードを返す
	 *
	 * @access public
	 * @return BSRecord 親レコード
	 */
	public function getParent () {
		return $this->getForm();
	}

	/**
	 * 削除可能か？
	 *
	 * @access protected
	 * @return boolean 削除可能ならTrue
	 */
	protected function isDeletable () {
		return $this->getForm()->isDeletable();
	}

	/**
	 * ファイル項目か？
	 *
	 * @access public
	 * @return boolean ファイル項目ならTrue
	 */
	public function isFile () {
		return false;
	}

	/**
	 * 同種のレコードを返す
	 *
	 * @access protected
	 * @return BSSortableTableHandler テーブル
	 */
	protected function getSimilars () {
		if (!$this->similars) {
			$this->similars = new FieldHandler;
			$this->similars->getCriteria()->register('form_id', $this->getForm());
		}
		return $this->similars;
	}

	/**
	 * バリデータ登録
	 *
	 * @access public
	 */
	public function registerValidators () {
		$manager = BSValidateManager::getInstance();
		if ($this['required']) {
			$manager->register($this->getName(), new BSEmptyValidator);
		}
		if ($this['has_confirm_field']) {
			$params = array('field' => $this->getName() . '_confirm');
			$manager->register($this->getName(), new BSPairValidator($params));
		}
		$params = array('max' => 2048);
		$manager->register($this->getName(), new BSStringValidator($params));
	}

	/**
	 * 選択肢を返す
	 *
	 * @access public
	 * @return BSArray 選択肢
	 */
	public function getChoices () {
		return new BSArray;
	}

	/**
	 * 統計を返す
	 *
	 * @access public
	 * @return BSArray 統計結果
	 */
	public function getStatistics () {
		return new BSArray;
	}

	/**
	 * 全てのファイル属性
	 *
	 * @access protected
	 * @return BSArray ファイル属性の配列
	 */
	protected function getFullAttributes () {
		$values = parent::getFullAttributes();
		$values['is_file'] = $this->isFile();
		return $values;
	}
}

/* vim:set tabstop=4 */