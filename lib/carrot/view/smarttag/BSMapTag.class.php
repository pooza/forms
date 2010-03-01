<?php
/**
 * @package org.carrot-framework
 * @subpackage view.smarttag
 */

/**
 * Google Mapタグ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSMapTag.class.php 1889 2010-02-28 10:52:44Z pooza $
 */
class BSMapTag extends BSSmartTag {
	private $geocode;

	/**
	 * タグ名を返す
	 *
	 * @access public
	 * @return string タグ名
	 */
	public function getTagName () {
		return 'map';
	}

	/**
	 * 置換して返す
	 *
	 * @access public
	 * @param string $body 置換対象文字列
	 * @return string 置換された文字列
	 */
	public function execute ($body) {
		try {
			if ($this->getUserAgent()->isMobile()) {
				$element = $this->getMobileAnchorElement();
			} else {
				$element = $this->getAjaxDivisionElement();
			}
			$replace = $element->getContents();
		} catch (Exception $e) {
			$replace = sprintf('[エラー: %s]', $e->getMessage());
		}
		return str_replace($this->getContents(), $replace, $body);
	}

	private function getMobileAnchorElement () {
		$url = BSGoogleMapsService::getURL($this->tag[1], $this->getUserAgent());
		$element = new BSAnchorElement;
		$element->setBody($this->tag[1]);
		$element->setURL($url);
		return $element;
	}

	private function getAjaxDivisionElement () {
		$params = new BSArray($this->getQueryParameters());
		$params['id'] = 'map_' . BSCrypt::getDigest($this->tag[1]);
		return BSGoogleMapsService::getScriptElement($this->getGeocode(), $params);
	}

	private function getGeocode () {
		if (!$this->geocode) {
			$service = new BSGoogleMapsService;
			if (!$this->geocode = $service->getGeocode($this->tag[1])) {
				throw new BSGeocodeException('ジオコードが取得できません。');
			}
		}
		return $this->geocode;
	}
}

/* vim:set tabstop=4: */
