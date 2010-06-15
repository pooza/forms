<?php
/**
 * @package org.carrot-framework
 * @subpackage media.movie
 */

/**
 * 3GPP2動画ファイル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BS3GPP2MovieFile.class.php 2139 2010-06-14 17:09:35Z pooza $
 */
class BS3GPP2MovieFile extends BSQuickTimeMovieFile {

	/**
	 * 表示用のXHTML要素を返す
	 *
	 * @access public
	 * @param BSParameterHolder $params パラメータ配列
	 * @param BSUserAgent $useragent 対象ブラウザ
	 * @return BSDivisionElement 要素
	 */
	public function getElement (BSParameterHolder $params, BSUserAgent $useragent = null) {
		if (!$useragent) {
			$useragent = BSRequest::getInstance()->getUserAgent();
		}
		if ($useragent->isMobile()) {
			$params = new BSArray($params);
			$params['url'] = $this->getMediaURL($params)->getContents();
			if (BSString::isBlank($params['label'])) {
				$params['label'] = $this->getBaseName();
			}
			return $useragent->getMovieElement($params);
		}
		return parent::getElement($params, $useragent);
	}

	/**
	 * @access public
	 * @return string 基本情報
	 */
	public function __toString () {
		return sprintf('3GPP2動画ファイル "%s"', $this->getShortPath());
	}
}

/* vim:set tabstop=4: */
