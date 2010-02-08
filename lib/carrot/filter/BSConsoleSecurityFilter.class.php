<?php
/**
 * @package org.carrot-framework
 * @subpackage filter
 */

/**
 * コンソール認証
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSConsoleSecurityFilter.class.php 1829 2010-02-07 07:07:21Z pooza $
 */
class BSConsoleSecurityFilter extends BSFilter {
	public function execute () {
		if (!BSString::isBlank($user = $this->controller->getAttribute('USER'))) {
			if (!BSProcess::getAllowedUsers()->isContain($user)) {
				throw new BSConsoleException('実行ユーザー "%s" が正しくありません。', $user);
			}
		}
		return !$this->request->isCLI();
	}
}

/* vim:set tabstop=4: */
