<?php
/**
 * @package jp.co.b-shock.carrot
 * @subpackage platform
 */

/**
 * 抽象プラットフォーム
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @abstract
 */
abstract class BSPlatform extends BSParameterHolder {

	/**
	 * @access protected
	 * @param string[] $params パラメータ配列
	 * @param string $uname uname文字列
	 */
	protected function __construct ($params) {
		$this->setParameters($params);
	}

	/**
	 * インスタンスを生成して返す
	 *
	 * @access public
	 * @param string $name プラットフォーム名
	 * @return BSPlatform インスタンス
	 * @static
	 */
	static public function create ($name) {
		try {
			$class = BSLoader::getInstance()->getClass($name, 'Platform');
		} catch (Exception $e) {
			$class = 'BSDefaultPlatform';
		}
		return new $class([
			'name' => $name,
			'version' => php_uname('r'),
		]);
	}

	/**
	 * 名前を返す
	 *
	 * @access public
	 * @return string プラットフォーム名
	 */
	public function getName () {
		return $this['name'];
	}

	/**
	 * 定数を取得して返す
	 *
	 * @access public
	 * @params BSParameterHolder $keys キーの配列
	 * @params BSConstantHandler $handler 定数ハンドラー
	 * @return BSArray 定数の配列
	 */
	public function getConstants (BSParameterHolder $keys, BSConstantHandler $handler = null) {
		if (!$handler) {
			$handler = new BSConstantHandler;
		}
		$suffixes = BSArray::create([
			'_' . $this->getName(),
			'_default',
			null,
		]);

		$constants = BSArray::create();
		foreach ($keys as $key) {
			foreach ($suffixes as $suffix) {
				if (!BSString::isBlank($value = $handler[$key . $suffix])) {
					$constants[$key] = $value;
					break;
				}
			}
		}
		return $constants;
	}

	/**
	 * ファイルをリネーム
	 *
	 * @access public
	 * @param BSDirectoryEntry $file 対象ファイル
	 * @param string $path リネーム後のパス
	 */
	public function renameFile (BSDirectoryEntry $file, $path) {
		if (!rename($file->getPath(), $path)) {
			throw new BSFileException($this . 'を移動できません。');
		}
	}

	/**
	 * ファイルの内容から、メディアタイプを返す
	 *
	 * @access public
	 * @return string メディアタイプ
	 */
	public function analyzeFile (BSFile $file) {
		return rtrim(exec('file -b --mime-type ' . $file->getPath()));
	}

	/**
	 * ディレクトリを返す
	 *
	 * @access public
	 * @param string $name ディレクトリ名
	 * @return BSDirectory ディレクトリ
	 */
	public function getDirectory ($name) {
		$constants = new BSConstantHandler($name);
		foreach ([$this->getName(), 'default'] as $suffix) {
			if (!BSString::isBlank($path = $constants['dir_' . $suffix])) {
				return new BSDirectory($path);
			}
		}
	}

	/**
	 * プロセスのオーナーを返す
	 *
	 * @access public
	 * @return string プロセスオーナーのユーザー名
	 */
	public function getProcessOwner () {
		$constants = new BSConstantHandler('app_process');
		foreach ([$this->getName(), 'default'] as $suffix) {
			if (!BSString::isBlank($owner = $constants['uid_' . $suffix])) {
				return $owner;
			}
		}
	}
}

