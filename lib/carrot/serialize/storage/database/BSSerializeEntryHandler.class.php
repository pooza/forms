<?php
/**
 * @package org.carrot-framework
 * @subpackage serialize.storage.database
 */

/**
 * シリアライズテーブル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSSerializeEntryHandler.class.php 944 2009-02-28 09:49:04Z pooza $
 */
class BSSerializeEntryHandler extends BSTableHandler {

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
	 * テーブル名を返す
	 *
	 * @access public
	 * @return string テーブル名
	 */
	public function getName () {
		return BSDatabaseSerializeStorage::TABLE_NAME;
	}

	/**
	 * データベースを返す
	 *
	 * @access public
	 * @return BSDatabase データベース
	 */
	public function getDatabase () {
		return BSDatabase::getInstance('serialize');
	}

	/**
	 * スキーマを返す
	 *
	 * @access public
	 * @return BSArray フィールド情報の配列
	 */
	public function getSchema () {
		return new BSArray(array(
			'id' => 'varchar(128) NOT NULL PRIMARY KEY',
			'update_date' => 'timestamp NOT NULL',
			'data' => 'TEXT',
		));
	}
}

/* vim:set tabstop=4: */
