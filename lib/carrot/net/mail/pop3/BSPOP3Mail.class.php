<?php
/**
 * @package org.carrot-framework
 * @subpackage net.mail.pop3
 */

/**
 * 受信メール
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSPOP3Mail.class.php 1599 2009-10-30 14:20:35Z pooza $
 */
class BSPOP3Mail extends BSMIMEDocument {
	private $id;
	private $size;
	private $server;
	private $executed;

	/**
	 * @access public
	 * @param BSPOP3 $server サーバ
	 * @param string $line レスポンス行
	 */
	public function __construct (BSPOP3 $server, $line) {
		$fields = BSString::explode(' ', $line);
		$this->id = $fields[0];
		$this->size = $fields[1];
		$this->server = $server;
		$this->executed = new BSArray;
	}

	/**
	 * IDを返す
	 *
	 * @access public
	 * @return integer ID
	 */
	public function getID () {
		return $this->id;
	}

	/**
	 * ヘッダを返す
	 *
	 * @access public
	 * @param string $name 名前
	 * @return BSMIMEHeader ヘッダ
	 */
	public function getHeader ($name) {
		if (!$this->getHeaders()->count()) {
			$this->queryHeaders();
		}
		return parent::getHeader($name);
	}

	/**
	 * 本文を取得
	 *
	 * @access public
	 */
	public function fetch () {
		$this->server->execute('RETR ' . $this->getID());
		$body = new BSArray($this->server->getLines());
		$this->setContents($body->join("\n"));
		$this->executed['RETR'] = true;
	}

	/**
	 * ヘッダだけを取得
	 *
	 * @access public
	 */
	public function fetchHeaders () {
		$this->server->execute('TOP ' . $this->getID() . ' 0');
		$headers = new BSArray($this->server->getLines());
		$this->parseHeaders($headers->join("\n"));
		$this->executed['TOP'] = true;
	}


	/**
	 * 本文を返す
	 *
	 * 添付メールの場合でも、素の本文を返す。
	 *
	 * @access public
	 * @return string 本文
	 */
	public function getBody () {
		if (!$this->executed['RETR']) {
			$this->fetch();
		}
		return parent::getBody();
	}

	/**
	 * サーバから削除
	 *
	 * @access public
	 */
	public function delete () {
		if (!$this->executed['DELE']) {
			$this->server->execute('DELE ' . $this->getID());
			$message = new BSStringFormat('%sを%sから削除しました。');
			$message[] = $this;
			$message[] = $this->server;
			BSLogManager::getInstance()->put($message, $this);
			$this->executed['DELE'] = true;
		}
	}
}

/* vim:set tabstop=4: */
