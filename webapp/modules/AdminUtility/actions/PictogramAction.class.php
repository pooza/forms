<?php
/**
 * Pictogramアクション
 *
 * @package org.carrot-framework
 * @subpackage AdminUtility
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: PictogramAction.class.php 1820 2010-02-04 11:15:28Z pooza $
 */
class PictogramAction extends BSAction {
	public function execute () {
		$this->request->setAttribute('pictograms', BSPictogram::getPictogramNames());
		return BSView::INPUT;
	}
}

/* vim:set tabstop=4: */
