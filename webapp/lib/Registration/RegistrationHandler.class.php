<?php
/**
 * @package jp.co.b-shock.forms
 */

/**
 * 応募テーブル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class RegistrationHandler extends BSTableHandler {
	const OVERWRITE_USER_AGENT = 128;
	const OVERWRITE_REMOTE_HOST = 256;
	const OVERWRITE_CREATE_DATE = 512;

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
	 * ユーザーエージェントフィールド名
	 *
	 * @access public
	 * @return string ユーザーエージェントフィールド名
	 */
	public function getUserAgentField () {
		return 'user_agent';
	}

	/**
	 * リモートホストフィールド名
	 *
	 * @access public
	 * @return string リモートホストフィールド名
	 */
	public function getRemoteHostField () {
		return 'remote_host';
	}
}

/* vim:set tabstop=4 */