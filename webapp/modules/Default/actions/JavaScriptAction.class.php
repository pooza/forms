<?php
/**
 * JavaScriptアクション
 *
 * @package org.carrot-framework
 * @subpackage Default
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: JavaScriptAction.class.php 1513 2009-09-20 13:27:06Z pooza $
 */
class JavaScriptAction extends BSAction {
	private $jsset;

	/**
	 * JavaScriptセットを返す
	 *
	 * @access private
	 * @return BSJavaScriptSet JavaScriptセット
	 */
	private function getJavaScriptSet () {
		if (!$this->jsset) {
			$this->jsset = new BSJavaScriptSet($this->request['jsset']);
		}
		return $this->jsset;
	}

	public function execute () {
		$this->request->setAttribute('renderer', $this->getJavaScriptSet());
		return BSView::SUCCESS;
	}

	public function validate () {
		return !!$this->getJavaScriptSet();
	}

	public function handleError () {
		return $this->controller->getNotFoundAction()->forward();
	}
}

/* vim:set tabstop=4: */
