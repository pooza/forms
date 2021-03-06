<?php
/**
 * @package jp.co.b-shock.carrot
 * @subpackage file
 */

/**
 * ファイル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class BSFile extends BSDirectoryEntry implements BSRenderer, BSSerializable {
	use BSSerializableMethods;
	protected $error;
	protected $handle;
	private $mode;
	private $lines;
	private $size;
	private $binary = false;
	const LINE_SEPARATOR = "\n";

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
	 * ユニークなファイルIDを返す
	 *
	 * @access public
	 * @return integer ID
	 */
	public function getID () {
		if (!$this->id) {
			$this->id = BSCrypt::digest([
				$this->getPath(),
				$this->getSize(),
				fileinode($this->getPath()),
				$this->getUpdateDate()->getTimestamp(),
			]);
		}
		return $this->id;
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
	 * メディアタイプのメイン部を返す
	 *
	 * @access public
	 * @return string メディアタイプ
	 */
	public function getMainType () {
		return BSMIMEUtility::getMainType($this->getType());
	}

	/**
	 * バイナリファイルか？
	 *
	 * @access public
	 * @return boolean バイナリファイルならTrue
	 */
	public function isBinary () {
		return $this->binary;
	}

	/**
	 * バイナリファイルかどうかのフラグを設定
	 *
	 * @access public
	 * @param boolean $flag バイナリファイルならTrue
	 */
	public function setBinary ($flag) {
		return $this->binary = !!$flag;
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
			$type = $finfo->file($this->getPath());
		} else {
			$type = $this->controller->getPlatform()->analyzeFile($this);
		}

		if (BSString::isBlank($type)) {
			$type = BSMIMEType::DEFAULT_TYPE;
		}
		return $type;
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
			$path = $this->getDirectory()->getPath() . '/' . basename($name);
			if (!move_uploaded_file($this->getPath(), $path)) {
				$message = new BSStringFormat('アップロードされた%sをリネームできません。');
				$message[] = $this;
				throw new BSFileException($message);
			}
			$this->setPath($path);
			$this->getDirectory()->clearEntryNames();
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
			$path = $dir->getPath() . '/' . $this->getName();
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
		$class = $this->loader->getClass($class);
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
		if (!in_array($mode[0], ['r', 'a', 'w'])) {
			$message = new BSStringFormat('モード "%s" が正しくありません。');
			$message[] = $mode;
			throw new BSFileException($message);
		} else if (($mode[0] == 'r') && !$this->isExists()) {
			throw new BSFileException($this . 'が存在しません。');
		} else if ($this->isCompressed()) {
			throw new BSFileException($this . 'はgzip圧縮されています。');
		} else if ($this->isOpened()) {
			throw new BSFileException($this . 'は既に開かれています。');
		}

		ini_set('auto_detect_line_endings', true);
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
		if (!$this->isOpened() || !in_array($this->mode[0], ['w', 'a'])) {
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
			if ($this->mode[0] != 'r') {
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
			$this->lines = BSArray::create();
			if ($this->isCompressed()) {
				if (!extension_loaded('zlib')) {
					throw new BSFileException('zlibモジュールがロードされていません。');
				}
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
			if (!extension_loaded('zlib')) {
				throw new BSFileException('zlibモジュールがロードされていません。');
			}
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
			if (!extension_loaded('zlib')) {
				throw new BSFileException('zlibモジュールがロードされていません。');
			}
			$contents = gzencode($contents, 9);
		}
		file_put_contents($this->getPath(), $contents, LOCK_EX);
		$this->size = null;
	}

	/**
	 * gzip圧縮
	 *
	 * @access public
	 */
	public function compress () {
		if (!extension_loaded('zlib')) {
			throw new BSFileException('zlibモジュールがロードされていません。');
		}
		if ($this->isCompressed()) {
			throw new BSFileException($this . 'をgzip圧縮することはできません。');
		}
		$this->setContents(gzencode($this->getContents(), 9));
		$this->rename($this->getName() . '.gz');
	}

	/**
	 * ウィルスなどに感染しているか？
	 *
	 * @access public
	 * @return boolean 感染していたらtrue
	 */
	public function isInfected () {
		$command = new BSCommandLine('bin/' . BS_CLAMAV_COMMAND);
		$command->setDirectory(BSFileUtility::getDirectory('clamav'));
		$command->push('--no-summary');
		$command->push($this->getPath());

		if ($command->getReturnCode() == 1) {
			$pattern = '^' . $this->getPath() . ': (.*)$';
			if (mb_ereg($pattern, $command->getResult()->join("\n"), $matches)) {
				$this->error = $matches[1];
				return true;
			}
		}

		return false;
	}

	/**
	 * gzip圧縮されているか？
	 *
	 * @access public
	 * @return boolean gzip圧縮されていたらTrue
	 */
	public function isCompressed () {
		return ($this->getSuffix() == '.gz');
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
		if (BSString::isBlank($this->size)) {
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
	 * ダイジェストを返す
	 *
	 * @access public
	 * @return string ダイジェスト
	 */
	public function digest () {
		return $this->getID();
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
		if ($this->isExists()) {
			return $this->controller->getAttribute($this, $this->getUpdateDate());
		}
	}

	/**
	 * @access public
	 * @return string 基本情報
	 */
	public function __toString () {
		return sprintf('ファイル "%s"', $this->getShortPath());
	}
}

