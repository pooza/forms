<?php
/**
 * CreateInputビュー
 *
 * @package jp.co.b-shock.forms
 * @subpackage AdminField
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class CreateInputView extends BSSmartyView {
	public function execute () {
		$this->setAttribute('types', new FieldTypeHandler);
	}
}

