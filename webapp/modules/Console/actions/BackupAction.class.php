<?php
/**
 * Backupアクション
 *
 * @package org.carrot-framework
 * @subpackage Console
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BackupAction.class.php 1787 2010-01-27 02:44:00Z pooza $
 */
class BackupAction extends BSAction {
	public function execute () {
		BSBackupManager::getInstance()->execute();
		return BSView::NONE;
	}
}

/* vim:set tabstop=4: */
