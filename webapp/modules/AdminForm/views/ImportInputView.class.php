<?php
/**
 * ImportInputビュー
 *
 * @package jp.co.b-shock.forms
 * @subpackage AdminForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class ImportInputView extends BSSmartyView {
	public function execute () {
		$this->translator->register(new BSRawDictionary);
	}
}

