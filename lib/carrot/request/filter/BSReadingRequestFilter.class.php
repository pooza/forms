<?php
/**
 * @package org.carrot-framework
 * @subpackage request.filter
 */

/**
 * フリガナ リクエストフィルタ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSReadingRequestFilter.class.php 1716 2009-12-25 08:55:41Z pooza $
 */
class BSReadingRequestFilter extends BSRequestFilter {

	/**
	 * 変換して返す
	 *
	 * @access protected
	 * @param mixed $key フィールド名
	 * @param mixed $value 変換対象の文字列又は配列
	 * @return mixed 変換後
	 */
	protected function convert ($key, $value) {
		if (!BSArray::isArray($value) && mb_ereg('_read$', $key)) {
			$value = str_replace(' ', '', $value);
			$value = BSString::convertKana($value, 'KVC');
		}
		return $value;
	}
}

/* vim:set tabstop=4: */
