<?php
/**
 * Importアクション
 *
 * @package jp.co.b-shock.forms
 * @subpackage AdminForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class ImportAction extends BSRecordAction {
	public function getTitle () {
		return 'CSVインポート';
	}

	public function execute () {
		try {
			$this->database->beginTransaction();
			$this->getRecord()->clearImportedAnswers();
			$csv = new BSHeaderCSVData;
			$csv->setHasRowID(false);
			$file = new BSCSVFile($this->request['file']['tmp_name'], $csv);
			$line = 2;
			foreach ($file->getEngine()->getRecords() as $record) {
				try {
					$record = clone $record;
					$record['imported'] = true;
					$this->getRecord()->registerAnswer($record);
				} catch (Exception $e) {
					$this->request->setError($line . '行目', $e->getMessage());
				}
				$line ++;
			}
			if ($this->request->hasErrors()) {
				return $this->handleError();
			}
			$this->database->commit();
		} catch (Exception $e) {
			$this->database->rollBack();
			$this->request->setError($this->getTable()->getName(), $e->getMessage());
			return $this->handleError();
		}
		BSLogManager::getInstance()->put($this->request['file']['name'] . 'をインポートしました。');
		return BSView::SUCCESS;
	}

	public function getDefaultView () {
		return BSView::INPUT;
	}

	public function handleError () {
		return $this->getDefaultView();
	}
}

/* vim:set tabstop=4: */
