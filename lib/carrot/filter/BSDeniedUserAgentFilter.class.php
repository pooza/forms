<?php
/**
 * @package org.carrot-framework
 * @subpackage filter
 */

/**
 * 禁止されたUserAgent
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSDeniedUserAgentFilter.class.php 1357 2009-08-01 09:48:33Z pooza $
 */
class BSDeniedUserAgentFilter extends BSFilter {
	public function initialize ($parameters = array()) {
		$this['module'] = 'Default';
		$this['action'] = 'DeniedUserAgent';
		return parent::initialize($parameters);
	}

	public function execute () {
		if ($this->request->getUserAgent()->isDenied()) {
			try {
				$module = $this->controller->getModule($this['module']);
				$action = $module->getAction($this['action']);
			} catch (BSException $e) {
				$action = $this->controller->getNotFoundAction();
			}
			$this->controller->registerAction($action);
		}
	}
}

/* vim:set tabstop=4: */
