<?php
/**
 * @package org.carrot-framework
 */

/**
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSHTTPTest.class.php 2460 2011-01-14 08:01:54Z pooza $
 * @abstract
 */
class BSHTTPTest extends BSTest {
	public function execute () {
		$this->assert('__construct', $http = new BSHTTP('www.b-shock.co.jp'));
		try {
			$http->sendGET('/NotFound');
		} catch (BSHTTPException $e) {
		}
		$this->assert('status_404', $e->getResponse()->getStatus() == 404);
		$this->assert('content-length_404', !!$e->getResponse()->getRenderer()->getSize());
	}
}

/* vim:set tabstop=4: */
