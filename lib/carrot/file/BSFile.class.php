<?php
/**
 * @package org.carrot-framework
 * @subpackage file
 */

ini_set('auto_detect_line_endings', true);

/**
 * ファイル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSFile.class.php 2192 2010-06-30 09:15:45Z pooza $
 */
class BSFile extends BSDirectoryEntry implements BSRenderer, BSSerializable {
	private $mode;
	private $lines;
	private $size;
	private $handle;
	private $error;
	const LINE_SEPARATOR = "\n";
	const COMPRESSED_SUFFIX = '.gz';
	const COMPRESSED_TYPE = 'application/x-gzip';

	/**
	 * @access public
	 * @param string $path パス
	 */
	public function __construct ($path) {
		$this->setPath($path);
	}

	/**
	 * @access public
	 */
	public function __destruct () {
		if ($this->isOpened()) {
			$this->close();
		}
	}

	/**
	 * メディアタイプを返す
	 *
	 * @access public
	 * @return string メディアタイプ
	 */
	public function getType () {
		return BSMIMEType::getType($this->getSuffix());
	}

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
	 * ファイルの内容から、メディアタイプを返す
	 *
	 * @access public
	 * @return string メディアタイプ
	 */
	public function analyzeType () {
		if (!$this->isExists()) {
			return null;
		}

		if (!$this->isBinary()) {
			return $this->getType();
		}
		if (extension_loaded('fileinfo') && defined('FILEINFO_MIME_TYPE')) {
			$finfo = new finfo(FILEINFO_MIME_TYPE);
			return $finfo->file($this->getPath());
		} else if (function_exists('mime_content_type')) {
			return mime_content_type($this->getPath());
		} else {
			return exec('file -b --mime-type ' . $this->getPath());
		}
	}

	/**
	 * 規定のサフィックスを返す
	 *
	 * @access public
	 * @return string 規定サフィックス
	 */
	public function getDefaultSuffix () {
		return BSMIMEType::getSuffix($this->getType());
	}

	/**
	 * リネーム
	 *
	 * @access public
	 * @param string $name 新しい名前
	 */
	public function rename ($name) {
		if ($this->isOpened()) {
			throw new BSFileException($this . 'は既に開かれています。');
		}

		if ($this->isUploaded()) {
			$path = $this->getDirectory()->getPath() . DIRECTORY_SEPARATOR . basename($name);
			if (!move_uploaded_file($this->getPath(), $path)) {
				$message = new BSStringFormat('アップロードされた%sをリネームできません。');
				$message[] = $this;
				throw new BSFileException($message);
			}
			$this->setPath($path);
		} else {
			parent::rename($name);
		}
	}

	/**
	 * 移動
	 *
	 * @access public
	 * @param BSDirectory $dir 移動先ディレクトリ
	 */
	public function moveTo (BSDirectory $dir) {
		if ($this->isOpened()) {
			throw new BSFileException($this . 'は既に開かれています。');
		}
		if ($this->isUploaded()) {
			$path = $dir->getPath() . DIRECTORY_SEPARATOR . $this->getName();
			if (!move_uploaded_file($this->getPath(), $path)) {
				$message = new BSStringFormat('アップロードされた%sを移動できません。');
				$message[] = $this;
				throw new BSFileException($message);
			}
			$this->setPath($path);
		} else {
			parent::moveTo($dir);
		}
	}

	/**
	 * コピー
	 *
	 * @access public
	 * @param BSDirectory $dir コピー先ディレクトリ
	 * @param string $class クラス名
	 * @return BSFile コピーされたファイル
	 */
	public function copyTo (BSDirectory $dir, $class = 'BSFile') {
		$file = parent::copyTo($dir);
		$class = BSClassLoader::getInstance()->getClass($class);
		return new $class($file->getPath());
	}

	/**
	 * 削除
	 *
	 * @access public
	 */
	public function delete () {
		if (!$this->isWritable($this->getPath())) {
			throw new BSFileException($this . 'を削除できません。');
		} else if ($this->isOpened()) {
			throw new BSFileException($this . 'は既に開かれています。');
		}
		if (!unlink($this->getPath())) {
			throw new BSFileException($this . 'を削除できません。');
		}
	}

	/**
	 * ストリームを開く
	 *
	 * @access public
	 * @param string $mode モード
	 */
	public function open ($mode = 'r') {
		if (!in_array($mode, array('r', 'a', 'w'))) {
			$message = new BSStringFormat('モード "%s" が正しくありません。');
			$message[] = $mode;
			throw new BSFileException($message);
		} else if (($mode == 'r') && !$this->isExists()) {
			throw new BSFileException($this . 'が存在しません。');
		} else if ($this->isCompressed()) {
			throw new BSFileException($this . 'はgzip圧縮されています。');
		} else if ($this->isOpened()) {
			throw new BSFileException($this . 'は既に開かれています。');
		}

		if (!$this->handle = fopen($this->getPath(), $mode)) {
			$this->handle = null;
			$this->mode = null;
			$message = new BSStringFormat('%sを%sモードで開くことができません。');
			$message[] = $this;
			$message[] = $mode;
			throw new BSFileException($message);
		}
		$this->mode = $mode;
	}

	/**
	 * ストリームを閉じる
	 *
	 * @access public
	 */
	public function close () {
		if ($this->isOpened()) {
			fclose($this->handle);
		}
		$this->handle = null;
		$this->mode = null;
	}

	/**
	 * ストリームに1行書き込む
	 *
	 * @access public
	 * @param string $str 書き込む内容
	 */
	public function putLine ($str = '', $separator = self::LINE_SEPARATOR) {
		if (!$this->isOpened() || !in_array($this->mode, array('w', 'a'))) {
			throw new BSFileException($this . 'はw又はaモードで開かれていません。');
		}

		flock($this->handle, LOCK_EX);
		fwrite($this->handle, $str . $separator);
		flock($this->handle, LOCK_UN);
		$this->lines = null;
	}

	/**
	 * ストリームから1行読み込む
	 *
	 * @access public
	 * @param integer $length 一度に読み込む最大のサイズ
	 * @return string 読み込んだ内容
	 */
	public function getLine ($length = 4096) {
		if ($this->isOpened()) {
			if ($this->mode != 'r') {
				throw new BSFileException($this . 'はrモードで開かれていません。');
			}
		} else {
			$this->open();
		}

		if ($this->isEof()) {
			return '';
		}
		return stream_get_line($this->handle, $length);
	}

	/**
	 * 全ての行を返す
	 *
	 * @access public
	 * @return BSArray 読み込んだ内容の配列
	 */
	public function getLines () {
		if (!$this->lines) {
			$this->lines = new BSArray;
			if ($this->isCompressed()) {
				foreach (gzfile($this->getPath()) as $line) {
					$this->lines[] = rtrim($line);
				}
			} else {
				$this->lines->merge(file($this->getPath(), FILE_IGNORE_NEW_LINES));
			}
		}
		return $this->lines;
	}

	/**
	 * 全て返す
	 *
	 * @access public
	 * @return string 読み込んだ内容
	 */
	public function getContents () {
		if ($this->isCompressed()) {
			return readgzfile($this->getPath());
		} else {
			return file_get_contents($this->getPath());
		}
	}

	/**
	 * 書き換える
	 *
	 * @access public
	 * @param string $contents 書き込む内容
	 */
	public function setContents ($contents) {
		if ($this->isCompressed()) {
			file_put_contents($this->getPath(), gzencode($contents, 9));
		} else {
			file_put_contents($this->getPath(), $contents);
		}
	}

	/**
	 * gzip圧縮
	 *
	 * @access public
	 */
	public function compress () {
		if ($this->isCompressed()) {
			throw new BSFileException($this . 'をgzip圧縮することはできません。');
		}
		$contents = gzencode($this->getContents(), 9);
		$this->setContents($contents);
		$this->rename($this->getName() . self::COMPRESSED_SUFFIX);
	}

	/**
	 * gzip圧縮されているか？
	 *
	 * @access public
	 * @return boolean gzip圧縮されていたらTrue
	 */
	public function isCompressed () {
		try {
			return ($this->analyzeType() == self::COMPRESSED_TYPE);
		} catch (Exception $e) {
			return ($this->getSuffix() == self::COMPRESSED_SUFFIX);
		}
	}

	/**
	 * 開かれているか？
	 *
	 * @access public
	 * @return boolean 開かれていたらtrue
	 */
	public function isOpened () {
		return is_resource($this->handle);
	}

	/**
	 * ポインタがEOFに達しているか？
	 *
	 * @access public
	 * @return boolean EOFに達していたらtrue
	 */
	public function isEof () {
		if (!$this->isReadable()) {
			throw new BSFileException($this . 'を読み込めません。');
		}
		return feof($this->handle);
	}

	/**
	 * ファイルサイズを返す
	 *
	 * @access public
	 * @return integer ファイルサイズ
	 */
	public function getSize () {
		if ($this->size === null) {
			if (!$this->isExists()) {
				throw new BSFileException($this . 'が存在しません。');
			}
			$this->size = filesize($this->getPath());
		}
		return $this->size;
	}

	/**
	 * 書式化されたファイルサイズを文字列で返す
	 *
	 * @access public
	 * @param string $suffix サフィックス、デフォルトはバイトの略で"B"
	 * @return string 書式化されたファイルサイズ
	 */
	public function getBinarySize ($suffix = 'B') {
		return BSNumeric::getBinarySize($this->getSize()) . $suffix;
	}

	/**
	 * アップロードされたファイルか？
	 *
	 * @access public
	 * @return boolean アップロードされたファイルならTrue
	 */
	public function isUploaded () {
		return is_uploaded_file($this->getPath());
	}

	/**
	 * ファイルか？
	 *
	 * @access public
	 * @return boolean ファイルならTrue
	 */
	public function isFile () {
		return true;
	}

	/**
	 * ディレクトリか？
	 *
	 * @access public
	 * @return boolean ディレクトリならTrue
	 */
	public function isDirectory () {
		return false;
	}

	/**
	 * 出力可能か？
	 *
	 * @access public
	 * @return boolean 出力可能ならTrue
	 */
	public function validate () {
		if (!$this->isReadable()) {
			$this->error = $this . 'が開けません。';
			return false;
		}
		return true;
	}

	/**
	 * エラーメッセージを返す
	 *
	 * @access public
	 * @return string エラーメッセージ
	 */
	public function getError () {
		return $this->error;
	}

	/**
	 * 属性名へシリアライズ
	 *
	 * @access public
	 * @return string 属性名
	 */
	public function serializeName () {
		$name = new BSArray(get_class($this));
		$name->merge(explode(DIRECTORY_SEPARATOR, $this->getShortPath()));
		$name->trim();
		return $name->join('.');
	}

	/**
	 * シリアライズ
	 *
	 * @access public
	 */
	public function serialize () {
		throw new BSFileException('シリアライズできません。');
	}

	/**
	 * シリアライズ時の値を返す
	 *
	 * @access public
	 * @return mixed シリアライズ時の値
	 */
	public function getSerialized () {
		return BSController::getInstance()->getAttribute($this, $this->getUpdateDate());
	}

	/**
	 * @access public
	 * @return string 基本情報
	 */
	public function __toString () {
		return sprintf('ファイル "%s"', $this->getShortPath());
	}
}

/* vim:set tabstop=4: */
