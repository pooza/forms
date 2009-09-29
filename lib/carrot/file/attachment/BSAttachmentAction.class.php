<?php
/**
 * @package org.carrot-framework
 * @subpackage image.attachment
 */

/**
 * 添付ファイルのダウンロードアクション
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSAttachmentAction.class.php 1129 2009-04-29 11:16:30Z pooza $
 * @abstract
 */
abstract class BSAttachmentAction extends BSRecordAction {
	public function execute () {
		$this->request->setAttribute(
			'filename',
			$this->getRecord()->getAttachmentFileName($this->request['name'])
		);
		$this->request->setAttribute(
			'renderer',
			$this->getRecord()->getAttachment($this->request['name'])
		);
		return BSView::SUCCESS;
	}

	public function handleError () {
		return $this->controller->getNotFoundAction()->forward();
	}

	public function validate () {
		return parent::validate()
			&& ($this->getRecord() instanceof BSAttachmentContainer)
			&& $this->getRecord()->getAttachment($this->request['name']);
	}
}

/* vim:set tabstop=4: */
