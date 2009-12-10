<?php
/**
 * Exportアクション
 *
 * @package jp.co.commons.forms
 * @subpackage AdminField
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class ExportAction extends BSRecordAction {
	public function execute () {
		$this->request->setAttribute('filename', $this->getRecord()->getArchiveFileName());
		$this->request->setAttribute('renderer', $this->getRecord()->createArchive());
		return BSView::SUCCESS;
	}

	public function handleError () {
		return $this->controller->getAction('not_found')->forward();
	}

	public function validate () {
		return (parent::validate() && ($this->getRecord() instanceof FileField));
	}
}

/* vim:set tabstop=4: */
