<?php
/**
 * CookieDisabledビュー
 *
 * @package jp.co.b-shock.carrot
 * @subpackage Default
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: CookieDisabledView.class.php 2085 2010-05-21 07:06:13Z pooza $
 */
class CookieDisabledView extends BSSmartyView {
	public function execute () {
		$this->setStatus(400);
	}
}

