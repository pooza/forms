<?php
/**
 * @package org.carrot-framework
 * @subpackage request.filter
 */

/**
 * リクエストを保存するフィルタ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSStoreRequestFilter.class.php 1469 2009-09-11 12:40:31Z pooza $
 */
class BSStoreRequestFilter extends BSRequestFilter {

	/**
	 * 変換して返す
	 *
	 * @access protected
	 * @param mixed $key フィールド名
	 * @param mixed $value 変換対象の文字列又は配列
	 * @return mixed 変換後
	 */
	protected function convert ($key, $value) {
		return $value;
	}

	public function execute () {
		if (BS_DEBUG || $this['force']) {
			if ($this->request->getMethod() == 'POST') {
				$this->getFile()->setContents($this->getContents());
			}
		}
	}

	private function getDirectory () {
		$name = BSDate::getNow('Y-m');
		if (!$dir = $this->controller->getDirectory('request')->getEntry($name)) {
			$dir = $this->controller->getDirectory('request')->createDirectory($name);
		}
		return $dir;
	}

	private function getFile () {
		$name = sprintf(
			'%s.%s.txt',
			BSDate::getNow('YmdHis'),
			$this->request->getSession()->getID()
		);
		return $this->getDirectory()->createEntry($name);
	}

	private function getContents () {
		$params = new BSArray;
		$params['UserAgent'] = $this->request->getUserAgent()->getName();
		$params->setAttributes($_POST);
		foreach ($params as $key => $value) {
			if (mb_eregi('password', $key)) {
				$params[$key] = '********';
			}
		}
		return BSString::toString($params, ': ', "\n");
	}
}

/* vim:set tabstop=4: */
