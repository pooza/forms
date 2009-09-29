<?php
/**
 * @package org.carrot-framework
 * @subpackage log
 */

/**
 * ログマネージャ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSLogManager.class.php 1522 2009-09-22 06:38:56Z pooza $
 */
class BSLogManager implements IteratorAggregate {
	private $loggers;
	static private $instance;

	/**
	 * @access private
	 */
	private function __construct () {
		$this->loggers = new BSArray;
		foreach (BSString::explode(',', BS_LOG_LOGGERS) as $class) {
			$this->register(BSClassLoader::getInstance()->getObject($class, 'Logger'));
		}
	}

	/**
	 * シングルトンインスタンスを返す
	 *
	 * @access public
	 * @return BSLogManager インスタンス
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
	 * ロガーを登録
	 *
	 * @access public
	 * @param BSLogger $logger ロガー
	 */
	public function register (BSLogger $logger) {
		if ($logger->initialize()) {
			$this->loggers[] = $logger;
		}
	}

	/**
	 * 最優先のロガーを返す
	 *
	 * @access public
	 * @param BSLogger $logger ロガー
	 */
	public function getPrimaryLogger () {
		return $this->getIterator()->getFirst();
	}

	/**
	 * ログを出力
	 *
	 * @access public
	 * @param mixed $message ログメッセージ又は例外
	 * @param string $priority 優先順位
	 */
	public function put ($message, $priority = BSLogger::DEFAULT_PRIORITY) {
		if ($message instanceof BSStringFormat) {
			$message = $message->getContents();
		}
		if (is_object($priority)) {
			$priority = get_class($priority);
		}
		foreach ($this as $logger) {
			$logger->put($message, $priority);
		}
	}

	/**
	 * イテレータを返す
	 *
	 * @access public
	 * @return BSIterator イテレータ
	 */
	public function getIterator () {
		return $this->loggers->getIterator();
	}

	/**
	 * メッセージを整形
	 *
	 * @access public
	 * @param string $message メッセージ
	 * @param string $priority 優先順位
	 * @return string 整形済みメッセージ
	 * @static
	 */
	static public function formatMessage ($message, $priority) {
		$message = array(
			'[' . date('Y-m-d H:i:s') . ']',
			'[' . gethostbyaddr($_SERVER['REMOTE_ADDR']) . ']', //BSRequest::getHostは使わない
			'[' . $priority . ']',
			$message,
		);
		return implode(' ', $message);
	}
}

/* vim:set tabstop=4: */
