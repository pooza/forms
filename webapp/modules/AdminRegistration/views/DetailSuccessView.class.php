<?php
/**
 * DetailSuccessビュー
 *
 * @package jp.co.commons.forms
 * @subpackage AdminRegistration
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class DetailSuccessView extends BSSmartyView {
	public function execute () {
		$this->translator->register($this->getModule()->getForm(), BSArray::POSITION_TOP);
	}
}

/* vim:set tabstop=4: */
