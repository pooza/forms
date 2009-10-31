<?php
/**
 * @package org.carrot-framework
 * @subpackage media.image.cache
 */

/**
 * 画像キャッシュアクション
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSImageCacheAction.class.php 1598 2009-10-30 12:26:03Z pooza $
 * @abstract
 */
abstract class BSImageCacheAction extends BSRecordAction {
	public function execute () {
		$url = BSImageCacheHandler::getInstance()->getURL(
			$this->getRecord(),
			$this->request['size'],
			$this->request['pixel']
		);
		return $url->redirect();
	}

	public function handleError () {
		return $this->controller->getAction('not_found')->forward();
	}

	public function validate () {
		return parent::validate()
			&& ($this->getRecord() instanceof BSImageContainer)
			&& $this->getRecord()->getImageFile($this->request['size']);
	}
}

/* vim:set tabstop=4: */
