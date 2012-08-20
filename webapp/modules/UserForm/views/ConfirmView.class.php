<?php
/**
 * Confirmビュー
 *
 * @package jp.co.b-shock.forms
 * @subpackage UserForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class ConfirmView extends BSSmartyView {

	/**
	 * HTTPキャッシュ有効か
	 *
	 * @access public
	 * @return boolean 有効ならTrue
	 */
	public function isCacheable () {
		return false;
	}

	public function execute () {
		$this->setAttribute('answer', $this->user->getAttribute('answer'));

		if ($file = $this->getModule()->getTemplate('confirm')) {
			$this->setTemplate($file);
		}
		$this->translator->register($this->getModule()->getRecord(), BSArray::POSITION_TOP);
	}
}

/* vim:set tabstop=4: */
