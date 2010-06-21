<?php
/**
 * @package org.carrot-framework
 * @subpackage controller
 */

/**
 * Webコントローラー
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSWebController.class.php 2166 2010-06-21 08:20:37Z pooza $
 */
class BSWebController extends BSController {

	/**
	 * リダイレクト
	 *
	 * @access public
	 * @param string $redirectTo リダイレクト先
	 * @return string ビュー名
	 */
	public function redirect ($redirectTo) {
		if ($redirectTo instanceof BSHTTPRedirector) {
			$url = $redirectTo->getURL();
		} else {
			$url = BSURL::getInstance();
			$url['path'] = $redirectTo;
		}

		$useragent = $this->request->getUserAgent();
		$url->setParameters($useragent->getQuery());
		if ($useragent->hasBug('cache_control')) {
			$url->setParameter('at', BSNumeric::getRandom());
		}

		$this->setHeader('Location', $url->getContents());
		return BSView::NONE;
	}
}

/* vim:set tabstop=4: */
