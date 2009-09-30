<?php
/**
 * @package jp.co.commons.forms
 */

/**
 * フォームテーブル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class FormHandler extends BSTableHandler {

	/**
	 * レコード追加
	 *
	 * @access public
	 * @param mixed[] $values 値
	 * @param integer $flags フラグのビット列
	 *   BSDatabase::WITH_LOGGING ログを残さない
	 * @return string レコードの主キー
	 */
	public function createRecord ($values, $flags = BSDatabase::WITH_LOGGING) {
		$values['create_date'] = BSDate::getNow('Y-m-d H:i:s');
		$values['update_date'] = BSDate::getNow('Y-m-d H:i:s');
		return parent::createRecord($values, $flags);
	}

	/**
	 * レコード追加可能か？
	 *
	 * @access protected
	 * @return boolean レコード追加可能ならTrue
	 */
	protected function isInsertable () {
		return true;
	}

	/**
	 * オートインクリメントのテーブルか？
	 *
	 * @access public
	 * @return boolean オートインクリメントならTrue
	 */
	public function isAutoIncrement () {
		return true;
	}
}

/* vim:set tabstop=4 */