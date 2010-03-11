<?php
/**
 * @package org.carrot-framework
 * @subpackage media.movie
 */

/**
 * 3GP動画ファイル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BS3GPMovieFile.class.php 1911 2010-03-11 01:52:28Z pooza $
 */
class BS3GPMovieFile extends BSQuickTimeMovieFile {

	/**
	 * @access public
	 * @return string 基本情報
	 */
	public function __toString () {
		return sprintf('3GP動画ファイル "%s"', $this->getShortPath());
	}
}

/* vim:set tabstop=4: */
