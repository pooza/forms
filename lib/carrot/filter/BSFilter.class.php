<?php
/**
 * @package org.carrot-framework
 * @subpackage filter
 */

/**
 * 抽象フィルタ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSFilter.class.php 1812 2010-02-03 15:15:09Z pooza $
 * @abstract
 */
abstract class BSFilter extends BSParameterHolder {

	/**
	 * @access public
	 * @param string[] $params パラメータ配列
	 */
	public function __construct ($params = array()) {
		$this->initialize($params);
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
			case 'action':
				return BSController::getInstance()->getAction();
			default:
				throw new BSMagicMethodException('仮想プロパティ"%s"は未定義です。', $name);
		}
	}

	/**
	 * 初期化
	 *
	 * @access public
	 * @param mixed[] $params パラメータ
	 * @return boolean 初期化が成功すればTrue
	 */
	public function initialize ($params = array()) {
		$this->setParameters($params);
		return true;
	}

	/**
	 * フィルタ名を返す
	 *
	 * @access public
	 * @return string フィルタ名
	 */
	public function getName () {
		return get_class($this);
	}

	/**
	 * 実行
	 *
	 * @access public
	 * @return boolean 終了ならばTrue
	 */
	abstract public function execute ();
}

/* vim:set tabstop=4: */
