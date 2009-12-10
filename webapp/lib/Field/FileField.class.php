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
			$this->getFileClassName()
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
	protected function getFileClassName () {
		return 'BSFile';
	}

	/**
	 * 一時ファイルの名前を返す
	 *
	 * @access public
	 * @return string 一時ファイルの名前
	 */
	protected function getTemporaryFileName () {
		return BSCrypt::getSHA1(
			BSRequest::getInstance()->getSession()->getID() . $this->getName() . BS_CRYPT_SALT
		);
	}

	/**
	 * バリデータ登録
	 *
	 * @access public
	 */
	public function registerValidators () {
		parent::registerValidators();
		BSValidateManager::getInstance()->register(
			$this->getName(),
			new BSFileValidator(array('suffixes' => BSFileValidator::ATTACHABLE))
		);
	}
}

/* vim:set tabstop=4 */