<?php
/**
 * @package jp.co.b-shock.forms
 */

/**
 * フィールドテーブル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class FieldHandler extends BSSortableTableHandler {

	/**
	 * レコードを返す
	 *
	 * @access public
	 * @param mixed[] $key 検索条件
	 * @return BSRecord レコード
	 */
	public function getRecord ($key) {
		if (!$record = parent::getRecord($key)) {
			return null;
		}

		$class = $this->loader->getClass($record['field_type_id'], 'Field');
		return new $class($this, $record->getAttributes()->getParameters());
	}
}

/* vim:set tabstop=4 */