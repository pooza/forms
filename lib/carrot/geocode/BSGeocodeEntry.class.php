<?php
/**
 * @package org.carrot-framework
 * @subpackage geocode
 */

/**
 * ジオコード エントリーレコード
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSGeocodeEntry.class.php 2012 2010-04-17 08:33:47Z pooza $
 */
class BSGeocodeEntry extends BSRecord {

	/**
	 * 書式化して返す
	 *
	 * @access public
	 * @param string $separator 区切り文字
	 * @return string 書式化した文字列
	 */
	public function format ($separator = ',') {
		return $this['lat'] . $separator . $this['lng'];
	}
}

/* vim:set tabstop=4: */
