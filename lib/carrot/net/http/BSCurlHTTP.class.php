<?php
/**
 * @package org.carrot-framework
 * @subpackage net.http
 */

/**
 * CurlによるHTTP処理
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSCurlHTTP.class.php 1867 2010-02-16 09:00:32Z pooza $
 */
class BSCurlHTTP extends BSHTTP {
	private $engine;
	private $attributes = array();
	private $ssl = false;

	/**
	 * HEADリクエスト
	 *
	 * @access public
	 * @param string $path パス
	 * @return BSHTTPResponse レスポンス
	 */
	public function sendHeadRequest ($path = '/') {
		$this->setAttribute('nobody', true);
		return $this->execute($path);
	}

	/**
	 * GETリクエスト
	 *
	 * @access public
	 * @param string $path パス
	 * @return BSHTTPResponse レスポンス
	 */
	public function sendGetRequest ($path = '/') {
		$this->setAttribute('httpget', true);
		return $this->execute($path);
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
		$renderer = new BSWWWFormRenderer;
		$renderer->setParameters($params);

		$this->setAttribute('post', true);
		$this->setAttribute('postfields', $renderer->getContents());
		return $this->execute($path);
	}

	/**
	 * リクエスト実行
	 *
	 * @param string $path パス
	 * @access protected
	 * @return BSHTTPResponse レスポンス
	 */
	protected function execute ($path) {
		$url = $this->createURL($path);
		$this->setAttribute('url', $url->getContents());

		$response = new BSHTTPResponse;
		$response->setURL($url);
		$contents = BSString::convertLineSeparator(curl_exec($this->getEngine()), "\n");
		if ($contents === false) {
			throw new BSHTTPException($url . 'へ送信できません。');
		}
		$response->setContents($contents);

		if (!$response->validate()) {
			$message = new BSStringFormat('不正なレスポンスです。 (%d %s)');
			$message[] = $response->getStatus();
			$message[] = $response->getError();
			throw new BSHTTPException($message);
		}
		return $response;
	}

	/**
	 * パスからリクエストURLを生成して返す
	 *
	 * @param string $href パス
	 * @access protected
	 * @return BSHTTPURL リクエストURL
	 */
	protected function createRequestURL ($href) {
		$url = BSURL::getInstance();
		$url['host'] = $this->getHost();
		$url['path'] ='/' . ltrim($href, '/');
		if ($this->isSSL()) {
			$url['scheme'] = 'https';
		} else {
			$url['scheme'] = 'http';
		}
		return $url;
	}

	/**
	 * Curlエンジンを返す
	 *
	 * @access private
	 * @return handle Curlエンジン
	 */
	private function getEngine () {
		if (!$this->engine) {
			if (!extension_loaded('curl')) {
				throw new BSHTTPException('curlモジュールがロードされていません。');
			}

			$this->engine = curl_init();
			$this->setAttribute('autoreferer', true);
			$this->setAttribute('useragent', BSController::getFullName('en'));
			$this->setAttribute('followlocation', true);
			$this->setAttribute('header', true);
			$this->setAttribute('returntransfer', true);
			$this->setAttribute('maxredirs', 32);
			$this->setAttribute('ssl_verifypeer', false);

			if ($this->host->getName() == BSController::getInstance()->getHost()->getName()) {
				$constants = BSConstantHandler::getInstance();
				if ($constants['app_basic_auth_user'] && $constants['app_basic_auth_password']) {
					$value = new BSStringFormat('%s:%s');
					$value[] = $constants['app_basic_auth_user'];
					$value[] = $constants['app_basic_auth_password'];
					$this->setAttribute('userpwd', $value->getContents());
				}
			}
		}
		return $this->engine;
	}

	/**
	 * 全ての属性を返す
	 *
	 * @access public
	 * @return mixed[] 全ての属性
	 */
	public function getAttributes () {
		return $this->attributes;
	}

	/**
	 * 属性を設定
	 *
	 * @access public
	 * @param string $name 属性名
	 * @param mixed $value 属性値
	 */
	public function setAttribute ($name, $value) {
		if (!$this->getEngine()) {
			return;
		}

		$names = array(
			'curlopt_' . $name,
			'curl_' . $name,
			$name,
		);
		$constants = BSConstantHandler::getInstance();
		foreach ($names as $name) {
			if ($constants->hasParameter($name)) {
				$this->attributes[$name] = $value;
				curl_setopt($this->getEngine(), $constants[$name], $value);
				return;
			}
		}
	}

	/**
	 * SSLモードか？
	 *
	 * @access public
	 * @return boolean SSLモードならTrue
	 */
	public function isSSL () {
		return $this->ssl;
	}

	/**
	 * SSLモードを設定
	 *
	 * @access public
	 * @param boolean $mode SSLモード
	 */
	public function setSSL ($mode) {
		$this->ssl = $mode;
		$this->name = null;
		if ($this->isSSL()) {
			$this->port = BSNetworkService::getPort('https');
		} else {
			$this->port = BSNetworkService::getPort('http');
		}
	}
}

/* vim:set tabstop=4: */
