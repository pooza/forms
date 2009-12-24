<?php
/**
 * QRCodeアクション
 *
 * @package org.carrot-framework
 * @subpackage Default
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: NotFoundAction.class.php 738 2008-12-12 00:59:09Z pooza $
 */
class QRCodeAction extends BSAction {
	public function execute () {
		$qrcode = new BSQRCode;
		$qrcode->setData($this->request['value']);
		$this->request->setAttribute('renderer', $qrcode);
		return BSView::SUCCESS;
	}
}

/* vim:set tabstop=4: */
