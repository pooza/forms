<?php
/**
 * Choiceアクション
 *
 * @package org.carrot-framework
 * @subpackage UserPictogram
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: ChoiceAction.class.php 1812 2010-02-03 15:15:09Z pooza $
 */
class ChoiceAction extends BSAction {
	public function execute () {
		$this->request->setAttribute('pictograms', BSPictogram::getPictogramNames());
		return BSView::INPUT;
	}
}

/* vim:set tabstop=4: */
