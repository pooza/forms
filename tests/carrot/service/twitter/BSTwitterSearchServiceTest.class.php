<?php
/**
 * @package org.carrot-framework
 */

/**
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSTwitterSearchServiceTest.class.php 2367 2010-09-29 11:31:45Z pooza $
 * @abstract
 */
class BSTwitterSearchServiceTest extends BSTest {

	/**
	 * 実行
	 *
	 * @access public
	 */
	public function execute () {
		$this->assert('__construct', $service = new BSTwitterSearchService);
		$this->assert('searchTweets_twitter', !!$service->searchTweets('twitter')->count());
		$this->assert('searchTweets_#twitter', !!$service->searchTweets('#twitter')->count());
	}
}

/* vim:set tabstop=4: */
