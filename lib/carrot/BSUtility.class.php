<?php
/**
 * @package org.carrot-framework
 */

/**
 * ユーティリティ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSUtility.class.php 2218 2010-07-18 16:40:02Z pooza $
 */
class BSUtility {

	/**
	 * @access private
	 */
	private function __construct () {
	}

	/**
	 * 絶対パスか？
	 *
	 * @access public
	 * @param string $path パス
	 * @return boolean 絶対パスならTrue
	 * @static
	 */
	static public function isPathAbsolute ($path) {
		if ($path[0] == DIRECTORY_SEPARATOR) {
			return true;
		} else if (strpos($path, '..') !== false) {
			return false;
		}
		return !!mb_ereg('^[[:alpha:]]:' . preg_quote(DIRECTORY_SEPARATOR) . '.+', $path);
	}

	/**
	 * ユニークなIDを生成して返す
	 *
	 * @access public
	 * @return string ユニークなID
	 * @static
	 */
	static public function getUniqueID () {
		return BSCrypt::getDigest(array(
			BSDate::getNow('YmdHis'),
			uniqid(BSNumeric::getRandom(), true),
		));
	}

	/**
	 * エラーチェックなしでインクルード
	 *
	 * @access public
	 * @param string $path インクルードするファイルのパス、又はBSFileオブジェクト
	 * @static
	 */
	static public function includeFile ($file) {
		if (($file instanceof BSFile) == false) {
			$file = BSString::stripControlCharacters($file);
			$file = mb_ereg_replace('\\.php$', '', $file) . '.php';
			if (!self::isPathAbsolute($file)) {
				$file = BS_LIB_DIR . DIRECTORY_SEPARATOR . $file;
			}
			$file = new BSFile($file);
		}
		if (!$file->isReadable()) {
			throw new BSFileException($file . 'はインクルードできません。');
		}

		ini_set('display_errors', 0);
		require_once($file->getPath());
		ini_restore('display_errors');
	}

	/**
	 * オブジェクトメソッドを実行
	 *
	 * @access public
	 * @param object $object オブジェクト
	 * @param string $method 関数名
	 * @param mixed[] $values 引数
	 * @return mixed メソッドの返値
	 * @static
	 */
	static public function executeMethod ($object, $method, $values = array()) {
		if (is_string($object)) {
			$object = BSClassLoader::getInstance()->getClass($object);
		}
		if (!method_exists($object, $method)) {
			$message = new BSStringFormat('クラス "%s" のメソッド "%s" が未定義です。');
			$message[] = get_class($object);
			$message[] = $method;
			throw new BadFunctionCallException($message);
		}
		return call_user_func_array(array($object, $method), $values);
	}
}

/* vim:set tabstop=4: */
