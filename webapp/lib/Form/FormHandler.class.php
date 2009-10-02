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

	/**
	 * 添付ファイル名を全てを返す
	 *
	 * @access public
	 * @return BSArray 添付ファイル名名
	 * @static
	 */
	static public function getAttachmentNames () {
		return new BSArray(array('form_template', 'confirm_template'));
	}
}

/* vim:set tabstop=4 */