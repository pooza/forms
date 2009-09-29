<?php
/**
 * @package org.carrot-framework
 * @subpackage request.filter
 */

/**
 * 絵文字リクエストフィルタ
 *
 * 絵文字を検出し、内部表現タグに置換
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSPictogramRequestFilter.class.php 1015 2009-03-25 09:34:57Z pooza $
 */
class BSPictogramRequestFilter extends BSRequestFilter {

	/**
	 * 変換して返す
	 *
	 * @access protected
	 * @param mixed $key フィールド名
	 * @param mixed $value 変換対象の文字列又は配列
	 * @return mixed 変換後
	 */
	protected function convert ($key, $value) {
		$useragent = $this->request->getUserAgent();
		if ($useragent->isMobile()) {
			$value = $useragent->getCarrier()->convertPictogram($value);
		}
		return $value;
	}
}

/* vim:set tabstop=4: */
