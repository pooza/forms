<?php
/**
 * @package jp.co.b-shock.carrot
 * @subpackage config.file
 */

/**
 * 設定ファイル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class BSConfigFile extends BSFile {
	private $config = [];
	private $parser;
	private $cache;

	/**
	 * バイナリファイルか？
	 *
	 * @access public
	 * @return boolean バイナリファイルならTrue
	 */
	public function isBinary () {
		return false;
	}

	/**
	 * 設定パーサーを返す
	 *
	 * @access public
	 * @return BSConfigParser 設定パーサー
	 */
	public function getParser () {
		if (!$this->parser) {
			$this->parser = BSLoader::getInstance()->createObject(
				ltrim($this->getSuffix(), '.'),
				'ConfigParser'
			);
			$this->parser->setContents($this->getContents());
		}
		return $this->parser;
	}

	/**
	 * コンパイラを返す
	 *
	 * @access public
	 * @return BSConfigCompiler コンパイラ
	 */
	public function getCompiler () {
		return BSConfigManager::getInstance()->getCompiler($this);
	}

	/**
	 * 設定内容を返す
	 *
	 * @access public
	 * @return string[][] 設定ファイルの内容
	 */
	public function getResult () {
		if (!$this->config) {
			$this->config = $this->getParser()->getResult();
		}
		return $this->config;
	}

	/**
	 * コンパイル
	 *
	 * @access public
	 * @return BSFile 設定キャッシュファイル
	 */
	public function compile () {
		if (defined('BS_MEMCACHE_DEFAULT_HOST') && defined('BS_MEMCACHE_DEFAULT_PORT')) {
			$server = BSMemcacheManager::getInstance()->getServer();
			$serializer = new BSPHPSerializer;
			if ($script = $server[$this->getID()]) {
				$script = $serializer->decode($script);
			} else {
				$script = $this->getCompiler()->execute($this);
				$script = str_replace('<?php', '', $script);
				$server[$this->getID()] = $serializer->encode($script);
			}
			return eval($script);
		} else {
			$cache = $this->getCacheFile();
			if (!$cache->isExists() || $cache->getUpdateDate()->isPast($this->getUpdateDate())) {
				$cache->setContents($this->getCompiler()->execute($this));
			}
			return require $cache->getPath();
		}
	}

	/**
	 * キャッシュファイルを返す
	 *
	 * @access public
	 * @return BSFile キャッシュファイル
	 */
	public function getCacheFile () {
		if (!$this->cache) {
			$path = new BSStringFormat('%s/config_cache/%s.php');
			$path[] = BS_VAR_DIR;
			$path[] = str_replace(BS_ROOT_DIR . '/', '', $this->getPath());
			$path = $path->getContents();

			$dir = dirname($path);
			if (!file_exists($dir)) {
				mkdir($dir, 0777, true);
			}

			$this->cache = new BSFile($path);
		}
		return $this->cache;
	}

	/**
	 * シリアライズ
	 *
	 * @access public
	 */
	public function serialize () {
		BSController::getInstance()->setAttribute($this, $this->getResult());
	}

	/**
	 * @access public
	 * @return string 基本情報
	 */
	public function __toString () {
		return sprintf('設定ファイル "%s"', $this->getShortPath());
	}
}

/* vim:set tabstop=4: */
