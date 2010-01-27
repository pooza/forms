<?php
/**
 * Backupアクション
 *
 * @package org.carrot-framework
 * @subpackage AdminUtility
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BackupAction.class.php 1791 2010-01-27 04:04:18Z pooza $
 */
class BackupAction extends BSAction {
	public function execute () {
		try {
			if (!$file = BSBackupManager::getInstance()->execute()) {
				throw new BSFileException('バックアップファイルを取得できません。');
			}
			$this->request->setAttribute('renderer', $file);
			$this->request->setAttribute('filename', $file->getName());
			return BSView::SUCCESS;
		} catch (BSFileException $e) {
			$message = new BSStringFormat('バックアップに失敗しました。 (%s)');
			$message[] = $e->getMessage();
			$this->request->setError('bsutility', $message->getContents());
			return $this->handleError();
		}
	}

	public function getDefaultView () {
		return BSView::INPUT;
	}

	public function handleError () {
		return $this->getDefaultView();
	}
}

/* vim:set tabstop=4: */
