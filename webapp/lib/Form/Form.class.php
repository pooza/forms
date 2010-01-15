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
class Form extends BSRecord implements
	BSAttachmentContainer, BSHTTPRedirector, BSValidatorContainer, BSDictionary {
	private $exporter;
	private $fields;
	private $registrations;

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
	 *   BSDatabase::WITHOUT_LOGGING ログを残さない
	 */
	public function delete ($flags = null) {
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
		return !$this->getRegistrations()->count();
	}

	/**
	 * 複製
	 *
	 * @access public
	 * @return integer[] 複製されたレコードの主キー
	 */
	public function duplicate () {
		$values = clone $this->getAttributes();
		$values['name'] .= 'のコピー';
		$values['status'] = 'hide';
		$values->removeParameter('id');
		$id = $this->getTable()->createRecord($values);
		$new = $this->getTable()->getRecord($id);

		foreach ($this->getFields() as $field) {
			$values = clone $field->getAttributes();
			$values['form_id'] = $new->getID();
			$values->removeParameter('id');
			$new->getFields()->createRecord($values);
		}

		return $new->getID();
	}

	/**
	 * 追加項目を返す
	 *
	 * @access public
	 * @return CampaignFieldHandler 追加項目テーブル
	 */
	public function getFields () {
		if (!$this->fields) {
			$this->fields = new FieldHandler;
			$this->fields->getCriteria()->register('form_id', $this);
			$this->fields->getCriteria()->register('status', 'show');
			$this->fields->getOrder()->push('form_id');
			$this->fields->getOrder()->push('rank');
		}
		return $this->fields;
	}

	/**
	 * 応募を返す
	 *
	 * @access public
	 * @return RegistrationHandler 応募テーブル
	 */
	public function getRegistrations () {
		if (!$this->registrations) {
			$this->registrations = new RegistrationHandler;
			$this->registrations->getCriteria()->register('form_id', $this);
		}
		return $this->registrations;
	}

	/**
	 * 応募
	 *
	 * @access public
	 * @param BSArray 回答
	 * @return Registration 応募
	 */
	public function registerAnswer (BSArray $answers) {
		$answers = clone $answers;
		$values = new BSArray(array(
			'form_id' => $this->getID(),
		));
		$fields = new BSArray(array(
			'user_agent' => 'ブラウザ',
			'remote_host' => 'リモートホスト',
			'create_date' => '応募日',
			'imported' => 'imported',
		));
		foreach ($fields as $key => $field) {
			$values[$key] = $answers[$field];
			$answers->removeParameter($field);
		}
		$values['imported'] = !!$values['imported'];

		if ($answers['フォーム'] && ($answers['フォーム'] != $this->getName())) {
			throw new BSException('別のフォームへの応募です。');
		}
		$answers->removeParameter('応募ID');
		$answers->removeParameter('フォーム');

		$id = $this->getRegistrations()->createRecord($values);
		$registration = $this->getRegistrations()->getRecord($id);

		$this->getFields()->query();
		foreach ($answers as $key => $answer) {
			if (!$field = $this->getFields()->getRecord(array('name' => $key))) {
				if (!$field = $this->getFields()->getRecord(array('label' => $key))) {
					throw new BSException('フィールド' . $key . 'が見つかりません。');
				}
			}
			$registration->registerDetail($field, $answer);
		}
		return $registration;
	}

	/**
	 * インポートされた応募を削除
	 *
	 * @access public
	 */
	public function clearImportedAnswers () {
		$criteria = $this->createCriteriaSet();
		$criteria->register('form_id', $this);
		$criteria->register('imported', 1);
		$sql = BSSQL::getDeleteQueryString('registration', $criteria);
		$this->getDatabase()->exec($sql);
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
		$url = BSURL::getInstance(null, 'carrot');
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
			return $this->getAttachmentBaseName($name) . $file->getSuffix();
		}
	}

	/**
	 * テンプレートファイルを返す
	 *
	 * @access public
	 * @param string $name 名前
	 * @return BSTemplateFile テンプレートファイル
	 */
	public function getTemplateFile ($name) {
		if (!$file = $this->getAttachment($name . '_template')) {
			throw new BSViewException($this . 'に' . $name . '_templateがありません。');
		}
		return new BSTemplateFile($file->getPath());
	}

	/**
	 * リダイレクト対象
	 *
	 * @access public
	 * @return BSURL
	 */
	public function getURL () {
		$url = BSURL::getInstance(null, 'carrot');
		$url['module'] = 'UserForm';
		$url['action'] = 'Register';
		$url['record'] = $this;
		return $url;
	}

	/**
	 * リダイレクト
	 *
	 * @access public
	 * @return string ビュー名
	 */
	public function redirect () {
		return $this->getURL()->redirect();
	}

	/**
	 * バリデータ登録
	 *
	 * @access public
	 */
	public function registerValidators () {
		foreach ($this->getFields() as $field) {
			$field->registerValidators();
		}
	}

	/**
	 * 翻訳して返す
	 *
	 * @access public
	 * @param string $label ラベル
	 * @param string $language 言語
	 * @return string 翻訳された文字列
	 */
	public function translate ($label, $language) {
		$fields = $this->getFields();
		$fields->query();
		if ($field = $fields->getRecord(array('name' => $label))) {
			return $field['label'];
		}
	}

	/**
	 * 辞書の名前を返す
	 *
	 * @access public
	 * @return string 辞書の名前
	 */
	public function getDictionaryName () {
		return get_class($this) . '.' . $this->getID();
	}

	/**
	 * エクスポート
	 *
	 * @access public
	 * @return BSExporter エクスポーター
	 */
	public function export () {
		$table = new RegistrationDumpHandler($this);
		return $table->export();
	}

	/**
	 * 全てのファイル属性
	 *
	 * @access protected
	 * @return BSArray ファイル属性の配列
	 */
	protected function getFullAttributes () {
		$values = $this->getAttributes();
		$values['url'] = $this->getURL()->getContents();
		foreach (FormHandler::getAttachmentNames() as $field) {
			if ($this->getAttachment($field)) {
				$values['has_' . $field] = true;
				$values[$field] = $this->getAttachmentInfo($field);
			}
		}
		$values['fields'] = new BSArray;
		foreach ($this->getFields() as $field) {
			$values['fields'][$field->getName()] = $field->getAssignValue();
		}
		return $values;
	}
}

/* vim:set tabstop=4 */