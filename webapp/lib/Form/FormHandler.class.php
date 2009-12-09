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
		return new BSArray(array(
			'form_template',
			'confirm_template',
			'thanx_template',
			'mobile_form_template',
			'mobile_confirm_template',
			'mobile_thanx_template',
			'thanx_mail_template',
		));
	}
}

/* vim:set tabstop=4 */