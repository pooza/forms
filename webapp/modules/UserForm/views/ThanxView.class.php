<?php
/**
 * Thanxビュー
 *
 * @package jp.co.b-shock.forms
 * @subpackage UserForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class ThanxView extends BSSmartyView {

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
		if ($file = $this->getModule()->getTemplate('thanx')) {
			$this->setTemplate($file);
		}
		$this->translator->register($this->getModule()->getRecord(), BSArray::POSITION_TOP);

		$this->setAttribute('has_image', $this->user->getAttribute('has_image'));
		$this->setAttribute('regid', $this->user->getAttribute('regid'));
	}
}

