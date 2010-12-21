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
class Form extends BSSortableRecord implements BSValidatorContainer, BSDictionary {
	private $exporter;
	private $fields;
	private $registrations;
	private $email;

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
	 * メールアドレスを返す
	 *
	 * @access public
	 * @return BSMailAddress メールアドレス
	 */
	public function getMailAddress () {
		if (!$this->email) {
			if ($email = $this['email']) {
				$this->email = BSMailAddress::getInstance($email);
			} else {
				$this->email = BSAuthorRole::getInstance()->getMailAddress();
			}
		}
		return $this->email;
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
			$info = parent::getAttachmentInfo($name);
			$info['contents'] = $file->getContents();
			return $info;
		}
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
	 * 添付ファイルをまとめて設定
	 *
	 * @access public
	 * @param BSWebRequest $request リクエスト
	 */
	public function setAttachments (BSWebRequest $request) {
		foreach ($this->getTable()->getImageNames() as $name) {
			if ($info = $request[$name]) {
				$this->setImageFile(new BSImageFile($info['tmp_name']), $name);
			}
		}
		foreach ($this->getTable()->getAttachmentNames() as $name) {
			if ($info = $request[$name]) {
				$this->setAttachment(new BSTemplateFile($info['tmp_name']), $name);
			}
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
	 * @param string $action アクション名
	 * @return BSURL
	 */
	public function getURL ($action = 'Register') {
		$url = BSURL::getInstance(null, 'carrot');
		$url['module'] = 'UserForm';
		$url['action'] = $action;
		$url['record'] = $this;
		return $url;
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
	 * @param BSDate $date 対象日付
	 * @param boolean $permission "mail_permission"がチェックされた応募を抽出
	 * @return BSExporter エクスポーター
	 */
	public function export (BSDate $date = null, $permission = null) {
		$table = new RegistrationDumpHandler($this);
		$table->setMailPermission($permission);
		if ($date) {
			$table->setDate($date);
		}
		return $table->export();
	}

	/**
	 * シリアライズするか？
	 *
	 * @access public
	 * @return boolean シリアライズするならTrue
	 */
	public function isSerializable () {
		return true;
	}

	/**
	 * 全てのファイル属性
	 *
	 * @access protected
	 * @return BSArray ファイル属性の配列
	 */
	protected function getFullAttributes () {
		$values = parent::getFullAttributes();
		$values['email'] = $this->getMailAddress()->getContents();
		$values['fields'] = new BSArray;
		foreach ($this->getFields() as $field) {
			$values['fields'][$field->getName()] = $field->getAssignValue();
		}
		return $values;
	}
}

/* vim:set tabstop=4 */