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
			$criteria->register('form_id', $this['from_id']);
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
	}
}

/* vim:set tabstop=4 */