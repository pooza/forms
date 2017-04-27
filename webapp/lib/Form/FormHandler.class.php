<?php
/**
 * @package jp.co.b-shock.forms
 */

/**
 * フォームテーブル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class FormHandler extends BSTableHandler {
	use BSSortableTable;

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
	 * レコード追加
	 *
	 * @access public
	 * @param mixed $values 値
	 * @param integer $flags フラグのビット列
	 *   BSDatabase::WITH_LOGGING ログを残さない
	 * @return string レコードの主キー
	 */
	public function createRecord ($values, $flags = null) {
		$id = parent::createRecord($values, $flags);
		$record = $this->getRecord($id);
		$record->touch();
		return $id;
	}

	/**
	 * 添付ファイル名を全てを返す
	 *
	 * @access public
	 * @return BSArray 添付ファイル名
	 * @static
	 */
	static public function getAttachmentNames () {
		return new BSArray([
			'pc_form_template',
			'pc_confirm_template',
			'pc_thanx_template',
			'mobile_form_template',
			'mobile_confirm_template',
			'mobile_thanx_template',
			'smartphone_form_template',
			'smartphone_confirm_template',
			'smartphone_thanx_template',
			'thanx_mail_template',
		]);
	}
}

/* vim:set tabstop=4 */