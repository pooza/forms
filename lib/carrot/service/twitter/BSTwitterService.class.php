<?php
/**
 * @package org.carrot-framework
 * @subpackage service.twitter
 */

/**
 * Twitterクライアント
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSTwitterService.class.php 2037 2010-04-26 11:43:01Z pooza $
 */
class BSTwitterService extends BSCurlHTTP {
	const DEFAULT_HOST = 'twitter.com';

	/**
	 * @access public
	 * @param BSHost $host ホスト
	 * @param integer $port ポート
	 */
	public function __construct (BSHost $host = null, $port = null) {
		if (!$host) {
			$host = new BSHost(self::DEFAULT_HOST);
		}
		parent::__construct($host, $port);
		$this->setAttribute('httpauth', CURLAUTH_BASIC);
		$this->setAttribute('httpheader', $this->getRequestHeaders());
	}

	/**
	 * GETリクエスト
	 *
	 * @access public
	 * @param string $path パス
	 * @return BSHTTPResponse レスポンス
	 */
	public function sendGetRequest ($path = '/') {
		try {
			return parent::sendGetRequest($path);
		} catch (BSHTTPException $e) {
			$message = new BSStringFormat('認証エラーが発生した為、 "%s" をGETできません。');
			$message[] = $path;
			throw new BSTwitterException($message);
		}
	}

	/**
	 * POSTリクエスト
	 *
	 * @access public
	 * @param string $path パス
	 * @param string[] $params パラメータの配列
	 * @return BSHTTPResponse レスポンス
	 */
	public function sendPostRequest ($path = '/', $params = array()) {
		if (BSString::isBlank($this->getAttribute('userpwd'))) {
			throw new BSTwitterException('認証情報が未定義です。');
		}
		try {
			return parent::sendPostRequest($path, $params);
		} catch (BSHTTPException $e) {
			$message = new BSStringFormat('認証エラーが発生した為、 "%s" をPOSTできません。');
			$message[] = $path;
			throw new BSTwitterException($message);
		}
	}

	/**
	 * 追加分リクエストヘッダを返す
	 *
	 * @access protected
	 * @return string[] 追加分リクエストヘッダ
	 */
	protected function getRequestHeaders () {
		return array(
			'X-Twitter-Client' => BSController::getName('en'),
		);
	}
}

/* vim:set tabstop=4: */
