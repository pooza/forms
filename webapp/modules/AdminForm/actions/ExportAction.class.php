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
	public function execute () {
		$name = new BSStringFormat('registrations_%06d.csv');
		$name[] = $this->getRecord()->getID();
		$this->request->setAttribute('filename', $name->getContents());

		$this->request->setAttribute('renderer', $this->getRecord()->export());
		return BSView::SUCCESS;
	}

	public function handleError () {
		return $this->controller->getAction('not_found')->forward();
	}
}

/* vim:set tabstop=4: */
