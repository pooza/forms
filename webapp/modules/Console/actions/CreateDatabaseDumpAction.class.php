<?php
/**
 * CreateDatabaseDumpアクション
 *
 * @package org.carrot-framework
 * @subpackage Console
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: CreateDatabaseDumpAction.class.php 1599 2009-10-30 14:20:35Z pooza $
 */
class CreateDatabaseDumpAction extends BSAction {
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
		$db->createDumpFile();

		$message = new BSStringFormat('%sのダンプを作成しました。');
		$message[] = $db;
		BSLogManager::getInstance()->put($message, $db);
		return BSView::NONE;
	}
}

/* vim:set tabstop=4: */
