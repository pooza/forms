<?php
/**
 * ListInputビュー
 *
 * @package jp.co.b-shock.forms
 * @subpackage AdminField
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class ListInputView extends BSSmartyView {
	public function execute () {
		$this->translator->register(new FieldTypeHandler);
	}
}

