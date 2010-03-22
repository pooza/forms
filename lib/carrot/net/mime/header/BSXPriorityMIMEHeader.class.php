<?php
/**
 * @package org.carrot-framework
 * @subpackage net.mime.header
 */

/**
 * X-Priorityヘッダ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSXPriorityMIMEHeader.class.php 1923 2010-03-21 12:02:11Z pooza $
 */
class BSXPriorityMIMEHeader extends BSMIMEHeader {

	/**
	 * 内容を設定
	 *
	 * @access public
	 * @param mixed $contents 内容
	 */
	public function setContents ($contents) {
		if (!in_array($contents, range(1, 5))) {
			$message = new BSStringFormat('優先順位"%d"が正しくありません。');
			$message[] = $contents;
			throw new BSMailException($message);
		}
		parent::setContents($contents);
	}
}

/* vim:set tabstop=4: */
