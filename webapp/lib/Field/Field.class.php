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
		$values = $this->getAttributes();
		$values['is_file'] = $this->isFile();
		return $values;
	}
}

/* vim:set tabstop=4 */