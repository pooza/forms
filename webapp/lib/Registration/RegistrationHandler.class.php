<?php
/**
 * @package jp.co.commons.forms
 */

/**
 * 応募テーブル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class RegistrationHandler extends BSTableHandler {
	const OVERWRITE_USER_AGENT = 128;
	const OVERWRITE_REMOTE_HOST = 256;
	const OVERWRITE_CREATE_DATE = 512;

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
		$value = new BSArray($values);
		if (BSString::isBlank($values['user_agent'])) {
			$values['user_agent'] = BSRequest::getInstance()->getUserAgent()->getName();
		}
		if (BSString::isBlank($values['remote_host'])) {
			$values['remote_host'] = BSRequest::getInstance()->getHost()->getName();
		}
		if (BSString::isBlank($values['create_date'])) {
			$values['create_date'] = BSDate::getNow('Y-m-d H:i:s');
		}
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