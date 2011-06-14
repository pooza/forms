<?php
/**
 * ImportInputビュー
 *
 * @package jp.co.b-shock.forms
 * @subpackage AdminForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class ImportInputView extends BSSmartyView {
	public function execute () {
		$this->translator->register(new BSRawDictionary);
	}
}

/* vim:set tabstop=4: */
