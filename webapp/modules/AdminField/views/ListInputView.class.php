<?php
/**
 * ListInputビュー
 *
 * @package jp.co.commons.forms
 * @subpackage AdminField
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class ListInputView extends BSSmartyView {
	public function execute () {
		$this->translator->register(new FieldTypeHandler);
	}
}

/* vim:set tabstop=4: */
