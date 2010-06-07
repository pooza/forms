<?php
/**
 * @package org.carrot-framework
 * @subpackage file
 */

/**
 * ディレクトリエントリ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSDirectoryEntry.class.php 2126 2010-06-06 08:57:25Z pooza $
 * @abstract
 */
abstract class BSDirectoryEntry {
	protected $name;
	protected $path;
	private $suffix;
	private $basename;
	private $shortPath;
	private $linkTarget;
	protected $directory;

	/**
	 * inodeを返す
	 *
	 * @access public
	 * @return integer ID
	 */
	public function getID () {
		return fileinode($this->getPath());
	}

	/**
	 * 名前を返す
	 *
	 * @access public
	 * @return string 名前
	 */
	public function getName () {
		if (!$this->name) {
			$this->name = basename($this->getPath());
		}
		return $this->name;
	}

	/**
	 * 名前を設定
	 *
	 * renameのエイリアス
	 *
	 * @access public
	 * @param string $name 新しい名前
	 * @final
	 */
	final public function setName ($name) {
		return $this->rename($name);
	}

	/**
	 * リネーム
	 *
	 * @access public
	 * @param string $name 新しい名前
	 */
	public function rename ($name) {
		if (!$this->isExists()) {
			throw new BSFileException($this . 'が存在しません。');
		} else if (!$this->isWritable($this->getPath())) {
			throw new BSFileException($this . 'をリネームできません。');
		} else if (BSString::isContain(DIRECTORY_SEPARATOR, $name)) {
			throw new BSFileException($this . 'をリネームできません。');
		}

		$path = $this->getDirectory()->getPath() . DIRECTORY_SEPARATOR . basename($name);
		if (!rename($this->getPath(), $path)) {
			throw new BSFileException($this . 'をリネームできません。');
		}
		$this->setPath($path);
	}

	/**
	 * 削除
	 *
	 * @access public
	 * @abstract
	 */
	abstract public function delete ();

	/**
	 * パスを返す
	 *
	 * @access public
	 * @return string パス
	 */
	public function getPath () {
		return $this->path;
	}

	/**
	 * パスを設定
	 *
	 * @access public
	 * @param string $path パス
	 */
	public function setPath ($path) {
		if (!BSUtility::isPathAbsolute($path)) {
			$message = new BSStringFormat('パス"%s"が正しくありません。');
			$message[] = $path;
			throw new BSFileException($message);
		}
		$this->path = $path;
		$this->name = null;
		$this->basename = null;
		$this->suffix = null;
	}

	/**
	 * 短いパスを返す
	 *
	 * @access public
	 * @return string 短いパス
	 */
	public function getShortPath () {
		if (!$this->shortPath) {
			$this->shortPath = str_replace(
				BSFileUtility::getPath('root') . DIRECTORY_SEPARATOR,
				'',
				$this->getPath()
			);
		}
		return $this->shortPath;
	}

	/**
	 * 移動
	 *
	 * @access public
	 * @param BSDirectory $dir 移動先ディレクトリ
	 */
	public function moveTo (BSDirectory $dir) {
		if (!$this->isExists()) {
			throw new BSFileException($this . 'が存在しません。');
		} else if (!$this->isWritable() || !$dir->isWritable()) {
			throw new BSFileException($this . 'を移動できません。');
		}

		$path = $dir->getPath() . DIRECTORY_SEPARATOR . $this->getName();
		if (!rename($this->getPath(), $path)) {
			throw new BSFileException($this . 'を移動できません。');
		}
		$this->setPath($path);
	}

	/**
	 * サフィックスを返す
	 *
	 * @access public
	 * @return string サフィックス
	 */
	public function getSuffix () {
		if (!$this->suffix) {
			$name = BSString::explode('.', $this->getName());
			if (1 < $name->count()) {
				$this->suffix = '.' . $name->getIterator()->getLast();
			}
		}
		return $this->suffix;
	}

	/**
	 * ベース名を返す
	 *
	 * @access public
	 * @return string ベース名
	 */
	public function getBaseName () {
		if (!$this->basename) {
			$this->basename = basename($this->getPath(), $this->getSuffix());
		}
		return $this->basename;
	}

	/**
	 * 無視対象か？
	 *
	 * @access public
	 * @return boolean 無視対象ならTrue
	 */
	public function isIgnore () {
		return BSFileUtility::isIgnoreName($this->getName());
	}

	/**
	 * 名前がドットから始まるか？
	 *
	 * @access public
	 * @return boolean ドットから始まるならTrue
	 */
	public function isDotted () {
		return BSFileUtility::isDottedName($this->getName());
	}

	/**
	 * シンボリックリンクか？
	 *
	 * @access public
	 * @return boolean シンボリックリンクならTrue
	 */
	public function isLink () {
		return is_link($this->getPath());
	}

	/**
	 * リンク先を返す
	 *
	 * @access public
	 * @return BSDirectoryEntry リンク先
	 */
	public function getLinkTarget () {
		if ($this->isLink() && !$this->linkTarget) {
			if ($this->isFile()) {
				$class = 'BSFile';
			} else {
				$class = 'BSDirectory';
			}
			$this->linkTarget = new $class(readlink($this->getPath()));
		}
		return $this->linkTarget;
	}

	/**
	 * シンボリックリンクを作成
	 *
	 * @access public
	 * @param BSDirectory $dir 作成先ディレクトリ
	 * @param string $name リンクのファイル名。空欄の場合は、元ファイルと同じ。
	 * @return BSDirectoryEntry リンク先
	 */
	public function createLink (BSDirectory $dir, $name = null) {
		if (BSString::isBlank($name)) {
			$name = $this->getName();
		}

		if ($file = $dir->getEntry($name)) {
			throw new BSFileException($file . 'が既に存在します。');
		}
		symlink($this->getPath(), $dir->getPath() . DIRECTORY_SEPARATOR . $name);
		return $dir->getEntry($name);
	}

	/**
	 * 親ディレクトリを返す
	 *
	 * @access public
	 * @return BSDirectory ディレクトリ
	 */
	public function getDirectory () {
		if (!$this->directory) {
			$this->directory = new BSDirectory(dirname($this->getPath()));
		}
		return $this->directory;
	}

	/**
	 * 作成日付を返す
	 *
	 * @access public
	 * @return BSDate 作成日付
	 */
	public function getCreateDate () {
		if (!$this->isExists()) {
			throw new BSFileException($this . 'が存在しません。');
		}

		clearstatcache();
		return BSDate::getInstance(filectime($this->getPath()), BSDate::TIMESTAMP);
	}

	/**
	 * 更新日付を返す
	 *
	 * @access public
	 * @return BSDate 更新日付
	 */
	public function getUpdateDate () {
		if (!$this->isExists()) {
			throw new BSFileException($this . 'が存在しません。');
		}

		clearstatcache();
		return BSDate::getInstance(filemtime($this->getPath()), BSDate::TIMESTAMP);
	}

	/**
	 * 存在するか？
	 *
	 * @access public
	 * @return boolean 存在するならtrue
	 */
	public function isExists () {
		return file_exists($this->getPath());
	}

	/**
	 * 存在し、かつ読めるか？
	 *
	 * @access public
	 * @return boolean 読めればtrue
	 */
	public function isReadable () {
		return is_readable($this->getPath());
	}

	/**
	 * 存在し、書き込めるか？
	 *
	 * @access public
	 * @return boolean 書き込めればtrue
	 */
	public function isWritable () {
		return is_writable($this->getPath());
	}

	/**
	 * ファイルモード（パーミッション）を設定
	 *
	 * @access public
	 * @param integer $mode ファイルモード
	 */
	public function setMode ($mode) {
		if (!$this->isWritable() || !chmod($this->getPath(), $mode)) {
			throw new BSFileException($this . 'のファイルモードを変更できません。');
		}
	}

	/**
	 * ファイルか？
	 *
	 * @access public
	 * @return boolean ファイルならTrue
	 * @abstract
	 */
	abstract public function isFile ();

	/**
	 * ディレクトリか？
	 *
	 * @access public
	 * @return boolean ディレクトリならTrue
	 * @abstract
	 */
	abstract public function isDirectory ();
}

/* vim:set tabstop=4: */
