<?php
/**
 * @package org.carrot-framework
 * @subpackage filter
 */

/**
 * フィルタセット
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSFilterSet.class.php 1478 2009-09-12 06:39:22Z pooza $
 * @abstract
 */
class BSFilterSet extends BSArray {

	/**
	 * 実行
	 *
	 * @access public
	 */
	public function execute () {
		foreach ($this as $filter) {
			if ($filter->execute()) {
				exit;
			}
		}
	}

	/**
	 * フィルタを加える
	 *
	 * @access public
	 * @param BSFilter $filter フィルタ
	 */
	public function register (BSFilter $filter) {
		$this[$filter->getName()] = $filter;
	}

	/**
	 * グローバルフィルタをフィルタセットに加える
	 *
	 * @access public
	 * @param BSHost $server 対象サーバ
	 */
	public function loadGlobal (BSHost $server) {
		$this->load('filters/carrot');
		$this->load('filters/application');

		if ($file = BSConfigManager::getConfigFile('filters/' . $server->getName())) {
			$this->load($file);
		}
	}

	/**
	 * モジュールフィルタをフィルタセットに加える
	 *
	 * @access public
	 * @param BSModule $module モジュール
	 */
	public function loadModule (BSModule $module) {
		if ($file = $module->getConfigFile('filters')) {
			$this->load($file);
		}
	}

	/**
	 * アクションフィルタをフィルタセットに加える
	 *
	 * @access public
	 * @param BSAction $action アクション
	 */
	public function loadAction (BSAction $action) {
		$this->loadGlobal(BSController::getInstance()->getHost());
		$this->loadModule($action->getModule());
		foreach ((array)$action->getConfig('filters') as $row) {
			$row = new BSArray($row);
			if ($row['enabled']) {
				if (!$this[$row['class']]) {
					$filter = BSClassLoader::getInstance()->getObject($row['class']);
					$filter->initialize((array)$row['params']);
					$this->register($filter);
				}
			} else {
				$this->removeParameter($row['class']);
			}
		}
	}

	/**
	 * フィルタセットに加える
	 *
	 * @access private
	 * @param mixed $file 設定ファイル名、又はBSFileオブジェクト
	 */
	private function load ($file) {
		require(BSConfigManager::getInstance()->compile($file));
		foreach ((array)$objects as $filter) {
			$this->register($filter);
		}
	}
}

/* vim:set tabstop=4: */
