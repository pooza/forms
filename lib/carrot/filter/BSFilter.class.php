<?php
/**
 * @package org.carrot-framework
 * @subpackage filter
 */

/**
 * 抽象フィルタ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSFilter.class.php 2433 2010-11-22 12:43:18Z pooza $
 * @abstract
 */
abstract class BSFilter extends BSParameterHolder {
	protected $controller;
	protected $request;
	protected $user;
	protected $action;

	/**
	 * @access public
	 * @param string[] $params パラメータ配列
	 */
	public function __construct ($params = array()) {
		$this->controller = BSController::getInstance();
		$this->request = BSRequest::getInstance();
		$this->user = BSUser::getInstance();
		$this->action = $this->controller->getAction();
		$this->initialize($params);
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
