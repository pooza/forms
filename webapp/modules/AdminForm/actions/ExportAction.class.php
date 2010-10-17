<?php
/**
 * Exportアクション
 *
 * @package jp.co.commons.forms
 * @subpackage AdminForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class ExportAction extends BSRecordAction {
	public function getTitle () {
		return 'CSVエクスポート';
	}

	public function execute () {
		if (BSString::isBlank($date = $this->request['date'])) {
			$name = new BSStringFormat('registrations_%06d.csv');
			$name[] = $this->getRecord()->getID();
			$this->request->setAttribute('renderer', $this->getRecord()->export());
		} else {
			$date = BSDate::getInstance($date);
			$this->request->setAttribute('renderer', $this->getRecord()->export($date));
			$name = new BSStringFormat('registrations_%06d_%s.csv');
			$name[] = $this->getRecord()->getID();
			$name[] = $date->format('Ymd');
		}
		$this->request->setAttribute('filename', $name->getContents());
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
