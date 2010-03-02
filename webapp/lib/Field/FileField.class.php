<?php
/**
 * @package jp.co.commons.forms
 */

/**
 * ファイルフィールド
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class FileField extends Field {

	/**
	 * ファイル項目か？
	 *
	 * @access public
	 * @return boolean ファイル項目ならTrue
	 */
	public function isFile () {
		return true;
	}

	/**
	 * 接続中ユーザーがアップロードした一時ファイルを返す
	 *
	 * @access public
	 * @return BSFile 一時ファイル
	 */
	public function getTemporaryFile () {
		return BSFileUtility::getDirectory('tmp')->getEntry(
			$this->getTemporaryFileName(),
			$this->getFileClass()
		);
	}

	/**
	 * 接続中ユーザーがアップロードしたファイルを移動し、返す
	 *
	 * @access public
	 * @param BSFile $file 一時ファイル
	 * @return BSFile 異動後の一時ファイル
	 */
	public function setTemporaryFile (BSFile $file) {
		$file->moveTo(BSFileUtility::getDirectory('tmp'));
		$file->rename($this->getTemporaryFileName());
		return $this->getTemporaryFile();
	}

	/**
	 * 接続中ユーザーの一時ファイルを削除
	 *
	 * @access public
	 * @param BSFile $file 一時ファイル
	 * @return BSFile 異動後の一時ファイル
	 */
	public function clearTemporaryFile () {
		if ($file = $this->getTemporaryFile()) {
			$file->delete();
		}
	}

	/**
	 * ファイルのクラスを返す
	 *
	 * @access public
	 * @return string ファイルのクラス
	 */
	protected function getFileClass () {
		return 'BSFile';
	}

	/**
	 * 一時ファイルの名前を返す
	 *
	 * @access public
	 * @return string 一時ファイルの名前
	 */
	protected function getTemporaryFileName () {
		return BSCrypt::getDigest(array(
			BSRequest::getInstance()->getSession()->getID(),
			$this->getName(),
		));
	}

	/**
	 * アーカイブを生成して返す
	 *
	 * @access public
	 * @return BSZipArchive アーカイブ
	 */
	public function createArchive () {
		$archive = new BSZipArchive;
		$archive->open();
		foreach ($this->getForm()->getRegistrations() as $registration) {
			if ($file = $registration->getAttachment($this->getName())) {
				$archive->register($file);
			}
		}
		$archive->close();
		return $archive;
	}

	/**
	 * アーカイブのファイル名を返す
	 *
	 * @access public
	 * @return string アーカイブのファイル名
	 */
	public function getArchiveFileName () {
		return sprintf('%06d_%s.zip', $this->getForm()->getID(), $this->getName());
	}

	/**
	 * バリデータ登録
	 *
	 * @access public
	 */
	public function registerValidators () {
		parent::registerValidators();

		$params = new BSArray(array('suffixes' => BSFileValidator::ATTACHABLE));
		$server = BSController::getInstance()->getHost();
		if ($file = BSConfigManager::getConfigFile('validator/' . $server->getName())) {
			$config = new BSArray(BSConfigManager::getInstance()->compile($file));
			if ($config['file'] && isset($config['file']['params'])) {
				$params->setParameters($config['file']['params']);
			}
		}
		$validator = new BSFileValidator($params);

		BSValidateManager::getInstance()->register($this->getName(), $validator);
	}
}

/* vim:set tabstop=4 */