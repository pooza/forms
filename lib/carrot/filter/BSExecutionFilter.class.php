<?php
/**
 * @package org.carrot-framework
 * @subpackage filter
 */

/**
 * アクション実行
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSExecutionFilter.class.php 1521 2009-09-22 06:28:16Z pooza $
 */
class BSExecutionFilter extends BSFilter {
	public function execute () {
		$view = $this->executeAction();
		$this->executeView($view);
		return true;
	}

	/**
	 * アクションを実行する
	 *
	 * @access private
	 * @return string ビュー名、ビューが必要ない場合は空文字列
	 */
	private function executeAction () {
		if (!$this->action->isExecutable()) {
			return $this->action->getDefaultView();
		}

		if ($file = $this->action->getValidationFile()) {
			require(BSConfigManager::getInstance()->compile($file));
		}
		$this->action->registerValidators();

		if (!BSValidateManager::getInstance()->execute() || !$this->action->validate()) {
			return $this->action->handleError();
		}
		return $this->action->execute();
	}

	/**
	 * ビューを実行する
	 *
	 * @access private
	 * @param integer $name ビュー名
	 */
	private function executeView ($name) {
		$view = $this->action->getView($name);
		if (!$view->initialize()) {
			throw new BSInitializationException($view . 'が初期化できません。');
		}
		$view->execute();
		$view->render();
	}
}

/* vim:set tabstop=4: */
