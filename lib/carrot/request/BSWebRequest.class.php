<?php
/**
 * @package org.carrot-framework
 * @subpackage request
 */

/**
 * Webリクエスト
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSWebRequest.class.php 1596 2009-10-30 11:31:21Z pooza $
 */
class BSWebRequest extends BSRequest {
	static private $instance;

	/**
	 * @access private
	 */
	private function __construct () {
		$this->setMethod($this->controller->getAttribute('REQUEST_METHOD'));
	}

	/**
	 * シングルトンインスタンスを返す
	 *
	 * @access public
	 * @return BSWebRequest インスタンス
	 * @static
	 */
	static public function getInstance () {
		if (!self::$instance) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * @access public
	 */
	public function __clone () {
		throw new BSSingletonException(__CLASS__ . 'はコピーできません。');
	}

	/**
	 * メソッドを設定
	 *
	 * @access public
	 * @param integer $method メソッド
	 */
	public function setMethod ($method) {
		parent::setMethod($method);
		switch ($this->getMethod()) {
			case 'GET':
			case 'HEAD':
				$this->setParameters($_GET);
				break;
			default:
				$this->setParameters($_GET);
				$this->setParameters($_POST);
				foreach ($_FILES as $key => $info) {
					if (!BSString::isBlank($info['name'])) {
						$info['is_file'] = true;
						$this[$key] = $info;
					}
				}
				break;
		}
	}

	/**
	 * 出力内容を返す
	 *
	 * @access public
	 * @return string 出力内容
	 */
	public function getContents () {
		if (!$this->contents) {
			$contents = new BSArray;
			$contents[] = $this->getRequestLine();
			foreach ($this->getHeaders() as $header) {
				$contents[] = $header->getName() . ': ' . $header->getContents();
			}
			$contents[] = null;
			$contents[] = $this->getBody();
			$this->contents = $contents->join(self::LINE_SEPARATOR);
		}
		return $this->contents;
	}

	/**
	 * httpバージョンを返す
	 *
	 * @access public
	 * @return string httpバージョン
	 */
	public function getVersion () {
		if (!$this->version) {
			$version = $this->controller->getAttribute('SERVER_PROTOCOL');
			$this->version = BSString::explode('/', $version)->getParameter(1);
		}
		return $this->version;
	}

	/**
	 * レンダラーを返す
	 *
	 * @access public
	 * @return BSRenderer レンダラー
	 */
	public function getRenderer () {
		if (!extension_loaded('http')) {
			throw new BSHTTPException('httpモジュールがロードされていません。');
		}
		if (!$this->renderer) {
			$this->renderer = new BSRawRenderer;
			$this->renderer->setContents(http_get_request_body());
		}
		return $this->renderer;
	}

	/**
	 * ヘッダ一式を返す
	 *
	 * @access public
	 * @return string[] ヘッダ一式
	 */
	public function getHeaders () {
		if (!$this->headers) {
			$this->headers = new BSArray;
			if (extension_loaded('http')) {
				$headers = http_get_request_headers();
			} else {
				$headers = apache_request_headers();
			}
			foreach ($headers as $key => $value) {
				$this->setHeader($key, $value);
			}
		}
		return $this->headers;
	}

	/**
	 * 送信先URLを返す
	 *
	 * @access public
	 * @return BSURL 送信先URL
	 */
	public function getURL () {
		if (!$this->url) {
			$url = 'http';
			if ($this->isSSL()) {
				$url .= 's';
			}
			$url .= "://" . $this->controller->getHost()->getName();
			$this->url = BSURL::getInstance($url);
			$this->url['path'] = $this->controller->getAttribute('REQUEST_URI');
		}
		return $this->url;
	}

	/**
	 * UserAgent名を返す
	 *
	 * @access public
	 * @return string リモートホストのUserAgent名
	 */
	public function getUserAgentName () {
		if (BS_DEBUG && !BSString::isBlank($name = $this[BSRequest::USER_AGENT_ACCESSOR])) {
			return $name;
		}
		return $this->controller->getAttribute('USER-AGENT');
	}

	/**
	 * 実際のUserAgentを返す
	 *
	 * エミュレート環境でも、実際のUserAgentを返す。
	 *
	 * @access public
	 * @return BSUserAgent リモートホストのUserAgent
	 */
	public function getRealUserAgent () {
		if ($header = $this->getHeader('user-agent')) {
			return $header->getEntity();
		}
	}
}

/* vim:set tabstop=4: */
