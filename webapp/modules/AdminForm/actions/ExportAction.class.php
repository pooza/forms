<?php
/**
 * Exportアクション
 *
 * @package jp.co.b-shock.forms
 * @subpackage AdminForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class ExportAction extends BSRecordAction {
	public function getTitle () {
		return 'CSVエクスポート';
	}

	public function execute () {
		if (BSString::isBlank($date = $this->request['date'])) {
			$date = null;
			$name = new BSStringFormat('registrations_%06d.csv');
			$name[] = $this->getRecord()->getID();
		} else {
			$date = BSDate::create($date);
			$name = new BSStringFormat('registrations_%06d_%s.csv');
			$name[] = $this->getRecord()->getID();
			$name[] = $date->format('Ymd');
		}
		$this->request->setAttribute(
			'renderer',
			$this->getRecord()->export($date, !!$this->request['mail_permission'])
		);
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
