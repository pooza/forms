<?php
/**
 * @package org.carrot-framework
 */

/**
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSGoogleURLShortnerServiceTest.class.php 2460 2011-01-14 08:01:54Z pooza $
 * @abstract
 */
class BSGoogleURLShortnerServiceTest extends BSTest {
	public function execute () {
		$this->assert('__construct', $service = new BSGoogleURLShortnerService);

		$url = BSURL::getInstance('http://www.b-shock.co.jp/');
		$this->assert('getShortURL', ($service->getShortURL($url) instanceof BSHTTPURL));
		$this->assert(
			'getQRCodeImageFile',
			($service->getQRCodeImageFile($url) instanceof BSImageFile)
		);
	}
}

/* vim:set tabstop=4: */
