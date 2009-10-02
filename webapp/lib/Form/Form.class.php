<?php
/**
 * @package jp.co.commons.forms
 */

/**
 * フォームレコード
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class Form extends BSRecord implements BSAttachmentContainer, BSExportable {
	private $exporter;

	/**
	 * 更新
	 *
	 * @access public
	 * @param string[] $values 更新する値
	 * @param integer $flags フラグのビット列
	 *   BSDatabase::WITH_LOGGING ログを残さない
	 */
	public function update ($values, $flags = BSDatabase::WITH_LOGGING) {
		$values['update_date'] = BSDate::getNow('Y-m-d H:i:s');
		parent::update($values, $flags);
	}

	/**
	 * 更新可能か？
	 *
	 * @access protected
	 * @return boolean 更新可能ならTrue
	 */
	protected function isUpdatable () {
		return true;
	}

	/**
	 * 削除
	 *
	 * @access public
	 * @param integer $flags フラグのビット列
	 *   BSDatabase::WITH_LOGGING ログを残さない
	 */
	public function delete ($flags = BSDatabase::WITH_LOGGING) {
		foreach (FormHandler::getAttachmentNames() as $field) {
			if ($file = $this->getAttachment($field)) {
				$file->delete();
			}
		}
		parent::delete($flags);
	}

	/**
	 * 削除可能か？
	 *
	 * @access protected
	 * @return boolean 削除可能ならTrue
	 */
	protected function isDeletable () {
		return true;
	}

	/**
	 * 添付ファイルの情報を返す
	 *
	 * @access public
	 * @param string $name 名前
	 * @return string[] 添付ファイルの情報
	 */
	public function getAttachmentInfo ($name = null) {
		if ($file = $this->getAttachment($name)) {
			return new BSArray(array(
				'filename' => $this->getAttachmentFileName($name),
				'url' => $this->getAttachmentURL($name)->getContents(),
				'size' => $file->getSize(),
				'contents' => $file->getContents(),
			));
		}
	}

	/**
	 * 添付ファイルを返す
	 *
	 * @access public
	 * @param string $name 名前
	 * @return BSFile 添付ファイル
	 */
	public function getAttachment ($name = null) {
		foreach (BSMIMEType::getAttachableTypes() as $suffix => $type) {
			$filename = $this->getAttachmentBaseName($name) . $suffix;
			if ($file = $this->getTable()->getDirectory()->getEntry($filename)) {
				return $file;
			}
		}
	}

	/**
	 * 添付ファイルを設定
	 *
	 * @access public
	 * @param BSFile $file 添付ファイル
	 * @param string $filename 添付ファイルの名前
	 * @param string $name 名前
	 */
	public function setAttachment (BSFile $file, $filename, $name = null) {
		if ($old = $this->getAttachment($name)) {
			$old->delete();
		}

		$file->setMode(0666);
		$suffix = BSMIMEUtility::getFileNameSuffix($filename);
		$file->rename($this->getAttachmentBaseName($name) . $suffix);
		$file->moveTo($this->getTable()->getDirectory());
	}

	/**
	 * 添付ファイルのURLを返す
	 *
	 * @access public
	 * @param string $name 名前
	 * @return BSURL 添付ファイルURL
	 */
	public function getAttachmentURL ($name = null) {
		$url = BSURL::getInstance(null, 'BSCarrotURL');
		$url['module'] = 'AdminForm';
		$url['action'] = 'Attachment';
		$url['record'] = $this;
		$url->setParameter('name', $name);
		return $url;
	}

	/**
	 * 添付ファイルベース名を返す
	 *
	 * @access public
	 * @param string $name 名前
	 * @return string 添付ファイルベース名
	 */
	public function getAttachmentBaseName ($name = null) {
		return sprintf('%06d_%s', $this->getID(), $name);
	}

	/**
	 * 添付ファイルのダウンロード時の名を返す
	 *
	 * @access public
	 * @param string $name 名前
	 * @return string 添付ファイルベース名
	 */
	public function getAttachmentFileName ($name = null) {
		if ($file = $this->getAttachment($name)) {
			return sprintf(
				'%06d_%s_%s%s',
				$this->getID(),
				$this->getName(),
				$name,
				$file->getSuffix()
			);
		}
	}

	/**
	 * エクスポータを返す
	 *
	 * @access public
	 * @return BSExporter エクスポータ
	 */
	public function getExporter () {
		if (!$this->exporter) {
			$this->exporter = new BSCSVExporter;
		}
		return $this->exporter;
	}

	/**
	 * 見出しを返す
	 *
	 * @access public
	 * @return BSArray 見出し
	 */
	public function getHeader () {
		throw new BSException('getHeaderが未実装です。');
	}

	/**
	 * エクスポート
	 *
	 * @access public
	 * @return BSExporter エクスポーター
	 */
	public function export () {
		$this->getExporter()->addRecord($this->getHeader());
		foreach (BSDatabase::getInstance()->query('SELECT * from ' . $this->getName()) as $row) {
			$this->getExporter()->addRecord(
				$this->modifyRecord(new BSArray($row))
			);
		}
		return $this->getExporter();
	}

	/**
	 * レコードを整形する
	 *
	 * @access protected
	 * @param BSArray $record レコード
	 * @return BSArray 整形後のレコード
	 */
	protected function modifyRecord (BSArray $record) {
		return $record;
	}

	/**
	 * アサインすべき値を返す
	 *
	 * @access public
	 * @return mixed アサインすべき値
	 */
	public function getAssignValue () {
		$values = $this->getAttributes();
		foreach (FormHandler::getAttachmentNames() as $field) {
			if ($this->getAttachment($field)) {
				$values['has_' . $field] = true;
				$values[$field] = $this->getAttachmentInfo($field);
			}
		}
		return $values;
	}
}

/* vim:set tabstop=4 */