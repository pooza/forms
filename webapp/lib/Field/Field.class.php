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
	private $alikeRecords;
	protected $choices;

	/**
	 * 更新
	 *
	 * @access public
	 * @param string[] $values 更新する値
	 * @param integer $flags フラグのビット列
	 *   BSDatabase::WITH_LOGGING ログを残さない
	 */
	public function update ($values, $flags = BSDatabase::WITH_LOGGING) {
		parent::update($values, $flags);
		$this->getForm()->touch();
	}

	/**
	 * 削除
	 *
	 * @access public
	 * @param integer $flags フラグのビット列
	 *   BSDatabase::WITH_LOGGING ログを残さない
	 */
	public function delete ($flags = BSDatabase::WITH_LOGGING) {
		$this->getForm()->touch();
		parent::delete($flags);
	}

	/**
	 * 同種のレコードを返す
	 *
	 * @access public
	 * @return SortableTableHandler テーブル
	 */
	public function getAlikeRecords () {
		if (!$this->alikeRecords) {
			$criteria = $this->getTable()->getDatabase()->createCriteriaSet();
			$criteria->register('form_id', $this['form_id']);
			$this->alikeRecords = new FieldHandler($criteria);
		}
		return $this->alikeRecords;
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
		if (!$this->choices) {
			$this->choices = BSString::explode("\n", $this['choices']);
			$this->choices->uniquize()->trim();
		}
		return $this->choices;
	}

	/**
	 * アサインすべき値を返す
	 *
	 * @access public
	 * @return mixed アサインすべき値
	 */
	public function getAssignValue () {
		$values = $this->getAttributes();
		$values['choices'] = $this->getChoices();
		return $values;
	}
}

/* vim:set tabstop=4 */