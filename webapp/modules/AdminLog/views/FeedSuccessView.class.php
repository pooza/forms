<?php
/**
 * FeedSuccessビュー
 *
 * @package org.carrot-framework
 * @subpackage AdminFeed
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: FeedSuccessView.class.php 1195 2009-05-16 11:46:01Z pooza $
 */
class FeedSuccessView extends BSView {
	public function initialize () {
		parent::initialize();
		$this->setRenderer(BSClassLoader::getInstance()->getObject(BS_FEED_CLASS));
		return true;
	}

	public function execute () {
		$this->renderer->setTitle($this->controller->getHost()->getName());
		$this->renderer->setDescription(BSController::getName() . 'の管理ログ');
		$this->renderer->setLink($this->getModule('AdminLog'));
		foreach ($this->request->getAttribute('entries') as $log) {
			$entry = $this->renderer->createEntry();
			$entry->setTitle($log['message']);
			$entry->setDate(BSDate::getInstance($log['date']));
			$message = array(
				'date' => $log['date'],
				'remote_host' => $log['remote_host'],
				'priority' => $log['priority'],
			);
			$entry->setBody(BSString::toString($message, ': ', "\n"));
		}
	}
}

/* vim:set tabstop=4: */
