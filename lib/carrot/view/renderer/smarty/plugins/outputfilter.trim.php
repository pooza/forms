<?php
/**
 * @package org.carrot-framework
 * @subpackage view.renderer.smarty.plugins
 */

/**
 * トリミング出力フィルタ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: outputfilter.trim.php 1812 2010-02-03 15:15:09Z pooza $
 */
function smarty_outputfilter_trim ($source, &$smarty) {
	return trim($source);
}

/* vim:set tabstop=4: */

