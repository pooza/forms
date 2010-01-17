<?php
/**
 * @package org.carrot-framework
 * @subpackage net.mime
 */

/**
 * MIMEタイプ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSMIMEType.class.php 1761 2010-01-17 06:20:14Z pooza $
 */
class BSMIMEType extends BSParameterHolder {
	static private $instance;
	private $typesFile;
	private $magicFile;
	const DEFAULT_TYPE = 'application/octet-stream';

	/**
	 * @access private
	 */
	private function __construct () {
		$expire = $this->getTypesFile()->getUpdateDate();
		if (!$this->getConfigFile()->getUpdateDate()->isPast($expire)) {
			$expire = $this->getConfigFile()->getUpdateDate();
		}

		if ($params = BSController::getInstance()->getAttribute($this, $expire)) {
			$this->setParameters($params);
		} else {
			$this->parse();
			BSController::getInstance()->setAttribute($this, $this->getParameters());
		}
	}

	/**
	 * シングルトンインスタンスを返す
	 *
	 * @access public
	 * @return BSMIMEType インスタンス
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
	 * mime.typesファイルを返す
	 *
	 * @access private
	 * @return BSFile mime.typesファイル
	 */
	private function getTypesFile () {
		if (!$this->typesFile) {
			$this->typesFile = new BSFile(BS_FILE_TYPES_FILE);
			if (!$this->typesFile->isReadable()) {
				throw new BSConfigException($file . 'を開くことができません。');
			}
		}
		return $this->typesFile;
	}

	/**
	 * magicファイルを返す
	 *
	 * @access private
	 * @return BSFile magicファイル
	 */
	private function getMagicFile () {
		if (!$this->magicFile) {
			$this->magicFile = new BSFile(BS_FILE_MAGIC_FILE);
			if (!$this->magicFile->isReadable()) {
				throw new BSConfigException($file . 'を開くことができません。');
			}
		}
		return $this->magicFile;
	}

	/**
	 * 設定ファイルを返す
	 *
	 * @access private
	 * @return BSConfigFile 設定ファイル
	 */
	private function getConfigFile () {
		return BSConfigManager::getInstance()->getConfigFile('mime');
	}

	/**
	 * 設定ファイルとmime.typesをパース
	 *
	 * @access private
	 */
	private function parse () {
		foreach ($this->getTypesFile()->getLines() as $line) {
			$line = rtrim($line);
			$line = mb_ereg_replace('#.*$', '', $line);
			$line = mb_split('[[:blank:]]+', $line);
			for ($i = 1 ; $i < count($line) ; $i ++) {
				$this[BSString::toLower($line[$i])] = $line[0];
			}
		}

		$config = BSConfigManager::getInstance()->compile($this->getConfigFile());
		foreach ($config['types'] as $key => $value) {
			if (BSString::isBlank($value)) {
				$this->removeParameter($key);
			} else {
				$this[BSString::toLower($key)] = $value;
			}
		}
	}

	/**
	 * パラメータを返す
	 *
	 * @access public
	 * @param string $name パラメータ名
	 * @return mixed パラメータ
	 */
	public function getParameter ($name) {
		return parent::getParameter(ltrim($name, '.'));
	}

	/**
	 * @access public
	 * @return string 基本情報
	 */
	public function __toString () {
		return 'MIMEタイプ';
	}

	/**
	 * アップロード可能なメディアタイプを返す
	 *
	 * @access public
	 * @return BSArray メディアタイプの配列
	 * @static
	 */
	static public function getAttachableTypes () {
		$types = new BSArray;
		$config = BSConfigManager::getInstance()->compile(self::getInstance()->getConfigFile());
		foreach ($config['types'] as $key => $value) {
			$types['.' . $key] = $value;
		}
		return $types;
	}

	/**
	 * 規定のメディアタイプを返す
	 *
	 * @access public
	 * @param string $suffix サフィックス、又はファイル名
	 * @param integer $flags フラグのビット列
	 *   BSMIMEUtility::IGNORE_INVALID_TYPE タイプが不正ならapplication/octet-streamを返す
	 * @return string メディアタイプ
	 * @static
	 */
	static public function getType ($suffix, $flags = BSMIMEUtility::IGNORE_INVALID_TYPE) {
		$types = self::getInstance();
		if (BSString::isBlank($type = $types[BSMIMEUtility::getFileNameSuffix($suffix)])
			&& ($flags & BSMIMEUtility::IGNORE_INVALID_TYPE)) {
			$type = self::DEFAULT_TYPE;
		}
		return $type;
	}
}

/* vim:set tabstop=4: */
