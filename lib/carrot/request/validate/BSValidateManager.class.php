<?php
/**
 * @package org.carrot-framework
 * @subpackage request.validate
 */

/**
 * バリデートマネージャ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSValidateManager.class.php 2433 2010-11-22 12:43:18Z pooza $
 */
class BSValidateManager implements IteratorAggregate {
	private $fields;
	private $request;
	static private $instance;

	/**
	 * @access private
	 */
	private function __construct () {
		$this->fields = new BSArray;
		$this->request = BSRequest::getInstance();
	}

	/**
	 * シングルトンインスタンスを返す
	 *
	 * @access public
	 * @return BSValidateManager インスタンス
	 * @static
	 */
	static public function getInstance () {
		if (!self::$instance) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * @access public
	 */
	public function __clone () {
		throw new BadFunctionCallException(__CLASS__ . 'はコピーできません。');
	}

	/**
	 * 実行
	 *
	 * @access public
	 */
	public function execute () {
		foreach ($this as $field => $validators) {
			foreach ($validators as $validator) {
				if (!BSEmptyValidator::isEmpty($this->request[$field])
					|| ($validator['fields'])
					|| ($validator instanceof BSEmptyValidator)) {

					if (!$validator->execute($this->request[$field])) {
						$this->request->setError($field, $validator->getError());
						break;
					}
				}
			}
		}
		return !$this->request->hasErrors();
	}

	/**
	 * フィールドにバリデータを登録
	 *
	 * @access public
	 * @param string $name フィールド名
	 * @param BSValidator $validator バリデータ
	 */
	public function register ($name, BSValidator $validator) {
		if (!$this->fields[$name]) {
			$this->fields[$name] = new BSArray;
		}
		$this->fields[$name][$validator->getName()] = $validator;
	}

	/**
	 * フィールド名を返す
	 *
	 * @access public
	 * @return BSArray フィールド名
	 */
	public function getFieldNames () {
		return $this->fields->getKeys();
	}

	/**
	 * フィールド値を返す
	 *
	 * @access public
	 * @return BSArray フィールド値
	 */
	public function getFieldValues () {
		$values = new BSArray;
		foreach ($this->getFieldNames() as $name) {
			$values[$name] = $this->request[$name];
		}
		return $values;
	}

	/**
	 * @access public
	 * @return BSIterator イテレータ
	 */
	public function getIterator () {
		return $this->fields->getIterator();
	}
}

/* vim:set tabstop=4: */
