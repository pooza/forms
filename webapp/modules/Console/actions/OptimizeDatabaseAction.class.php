<?php
/**
 * OptimizeDatabaseアクション
 *
 * @package org.carrot-framework
 * @subpackage Console
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: OptimizeDatabaseAction.class.php 1599 2009-10-30 14:20:35Z pooza $
 */
class OptimizeDatabaseAction extends BSAction {
	public function initialize () {
		$this->request->addOption('d');
		$this->request->parse();
		return true;
	}

	public function execute () {
		if (BSString::isBlank($name = $this->request['d'])) {
			$name = 'default';
		}
		$db = BSDatabase::getInstance($name);
		$db->optimize();

		$message = new BSStringFormat('%sを最適化しました。');
		$message[] = $db;
		BSLogManager::getInstance()->put($message, $db);
		return BSView::NONE;
	}
}

/* vim:set tabstop=4: */
