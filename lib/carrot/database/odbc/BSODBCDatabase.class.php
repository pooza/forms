<?php
/**
 * @package org.carrot-framework
 * @subpackage database.odbc
 */

/**
 * DOBCデータベース接続
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSODBCDatabase.class.php 1812 2010-02-03 15:15:09Z pooza $
 */
class BSODBCDatabase extends BSDatabase {

	/**
	 * 接続
	 *
	 * @access protected
	 * @name string $name データベース名
	 * @return BSODBCDatabase インスタンス
	 * @static
	 */
	static protected function connect ($name) {
		foreach (self::getPasswords($name) as $password) {
			try {
				$db = new BSODBCDatabase(
					$constants['PDO_' . $name . '_DSN'],
					$constants['PDO_' . $name . '_UID'],
					$password
				);
				$db->setName($name);
				return $db;
			} catch (Exception $e) {
			}
		}
		throw new BSDatabaseException('データベース "%s" に接続できません。', $name);
	}

	/**
	 * 文字列をクォート
	 *
	 * @access public
	 * @param string $string 対象文字列
	 * @param string $type クォートのタイプ
	 * @return string クォート後の文字列
	 */
	public function quote ($string, $type = PDO::PARAM_STR) {
		return '\'' . addslashes($string) . '\'';
	}

	/**
	 * テーブル名のリストを配列で返す
	 *
	 * @access public
	 * @return BSArray テーブル名のリスト
	 */
	public function getTableNames () {
		return new BSArray;
	}
}

/* vim:set tabstop=4: */
