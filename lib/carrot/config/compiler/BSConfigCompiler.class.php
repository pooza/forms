<?php
/**
 * @package org.carrot-framework
 * @subpackage config.compiler
 */

/**
 * 抽象設定コンパイラ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSConfigCompiler.class.php 1737 2010-01-02 12:19:26Z pooza $
 */
abstract class BSConfigCompiler extends BSParameterHolder {
	private $body;

	/**
	 * @access public
	 * @param string[] $parameters パラメータ
	 */
	public function __construct ($parameters = array()) {
		$this->initialize($parameters);
	}

	/**
	 * @access public
	 * @param string $name プロパティ名
	 * @return mixed 各種オブジェクト
	 */
	public function __get ($name) {
		switch ($name) {
			case 'controller':
				return BSController::getInstance();
			case 'request':
				return BSRequest::getInstance();
			case 'user':
				return BSUser::getInstance();
			default:
				throw new BSMagicMethodException('仮想プロパティ"%s"は未定義です。', $name);
		}
	}

	/**
	 * 初期化
	 *
	 * @access public
	 * @param string[] $parameters パラメータ
	 * @return boolean 成功ならばTrue
	 * @static
	 */
	public function initialize ($parameters = array()) {
		$this->setParameters($parameters);
	}

	/**
	 * 実行
	 *
	 * @access public
	 * @param BSConfigFile $file 設定ファイル
	 * @abstract
	 */
	abstract public function execute (BSConfigFile $file);

	/**
	 * コンパイル後のphpステートメントを返す
	 *
	 * @access protected
	 * @return string コンパイル結果
	 */
	protected function getBody () {
		return $this->body->join("\n");
	}

	/**
	 * phpステートメントを初期化
	 *
	 * @access protected
	 */
	protected function clearBody () {
		$this->body = new BSArray;
		$this->putLine('<?php');
		$this->putLine('// auth-generated by ' . get_class($this));
		$this->putLine('// date: ' . date('Y/m/d H:i:s'));
	}

	/**
	 * phpステートメントの末尾に1行追加
	 *
	 * @access public
	 * @param string $line phpステートメント
	 */
	protected function putLine ($line) {
		if ($line instanceof BSStringFormat) {
			$line = $line->getContents();
		}
		$this->body[] = $line;
	}

	/**
	 * 文字列のクォート
	 *
	 * @access public
	 * @param string $value 置換対象
	 * @return string 置換結果
	 * @static
	 */
	static public function quote ($value) {
		if (BSArray::isArray($value) || ($value instanceof BSParameterHolder)) {
			$body =  new BSArray;
			foreach ($value as $key => $item) {
				$body[] = sprintf('%s => %s', self::quote($key), self::quote($item));
			}
			return sprintf('array(%s)', $body->join(', '));
		} else {
			$value = trim($value);
			switch (BSString::toLower($value)) {
				case null:
					return 'null';
				case 'on':
				case 'yes':
				case 'true':
					return 'true';
				case 'off':
				case 'no':
				case 'false':
					return 'false';
				default:
					if (is_numeric($value)) {
						return $value;
					} else {
						$value = str_replace("\\", "\\\\", $value);
						$value = str_replace("%'", "\"", $value);
						$value = str_replace("'", "\\'", $value);
						return "'" . $value . "'";
					}
			}
		}
	}

	/**
	 * 定数で置換
	 *
	 * @access protected
	 * @param string $value 置換対象
	 * @return string 置換結果
	 * @static
	 */
	static protected function replaceConstants ($value) {
		$value = str_replace('%%', '##PERCENT##', $value);
		$constants = BSConstantHandler::getInstance();
		foreach (BSString::eregMatchAll('%([_[:alnum:]]+)%', $value) as $matches) {
			$value = str_replace($matches[0], $constants[$matches[1]], $value);
		}
		$value = str_replace('##PERCENT##', '%', $value);
		return $value;
	}
}

/* vim:set tabstop=4: */
