<?php
/**
 * @package org.carrot-framework
 * @subpackage media.movie
 */

/**
 * MPEG4動画ファイル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSMPEG4MovieFile.class.php 1910 2010-03-10 05:22:14Z pooza $
 */
class BSMPEG4MovieFile extends BSWindowsMediaMovieFile {

	/**
	 * @access public
	 * @return string 基本情報
	 */
	public function __toString () {
		return sprintf('MPEG4動画ファイル "%s"', $this->getShortPath());
	}
}

/* vim:set tabstop=4: */
