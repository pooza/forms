<?php
/**
 * @package jp.co.b-shock.forms
 */

/**
 * フォームレコード
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class Form extends BSRecord implements BSValidatorContainer, BSDictionary {
	use BSSortableRecord;
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
	 * 更新
	 *
	 * @access public
	 * @param mixed $values 更新する値
	 * @param integer $flags フラグのビット列
	 *   BSDatabase::WITHOUT_LOGGING ログを残さない
	 *   BSDatabase::WITHOUT_SERIALIZE シリアライズしない
	 */
	public function update ($values, $flags = 0) {
		parent::update($values, $flags);
		foreach (FormHandler::getAttachmentNames() as $field) {
			if (BSString::isBlank($this[$field])) {
				if ($file = $this->getAttachment($field)) {
					$file->delete();
				}
			} else {
				$file = BSFileUtility::createTemporaryFile('.tpl');
				$file->setContents($this[$field]);
				$this->setAttachment($field, $file, $file->getName());
			}
		}
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
	 * 添付ファイルをまとめて設定
	 *
	 * @access public
	 * @param BSWebRequest $request リクエスト
	 */
	public function setAttachments (BSWebRequest $request) {
		// なにもしない
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
				$this->email = BSMailAddress::create($email);
			} else {
				$this->email = BSAuthorRole::getInstance()->getMailAddress();
			}
		}
		return $this->email;
	}

	/**
	 * 項目を返す
	 *
	 * @access public
	 * @return FieldHandler 項目テーブル
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
	 * 項目をJSONで返す
	 *
	 * @access public
	 * @return BSResultJSONRenderer 項目情報
	 */
	public function getFieldOptions () {
		$values = BSArray::create($this->getAttributes());
		$fields = $values['fields'] = BSArray::create();
		foreach ($this->getFields() as $field) {
			$fields[$field->getName()] = $field->getOptions();
		}

		$json = new BSResultJSONRenderer;
		$json->setContents($values);
		return $json;
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
		$values = BSArray::create([
			'form_id' => $this->getID(),
		]);
		$values['imported'] = 'imported';
		$answers->removeParameter('imported');
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
			if (!$field = $this->getFields()->getRecord(['name' => $key])) {
				if (!$field = $this->getFields()->getRecord(['label' => $key])) {
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
	public function getAttachmentInfo ($name) {
		if ($file = $this->getAttachment($name)) {
			$info = parent::getAttachmentInfo($name);
			$info['contents'] = $file->getContents();
			return $info;
		}
	}

	/**
	 * テンプレートファイルを返す
	 *
	 * @access public
	 * @param string $name 名前
	 * @return BSTemplateFile テンプレートファイル
	 */
	public function getTemplate ($name) {
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
		$url = BSURL::create(null, 'carrot');
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
		if ($field = $fields->getRecord(['name' => $label])) {
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
	 * 全てのファイル属性
	 *
	 * @access protected
	 * @return BSArray ファイル属性の配列
	 */
	protected function getSerializableValues () {
		$values = parent::getSerializableValues();
		$values['email'] = $this->getMailAddress()->getContents();
		$values['fields'] = BSArray::create();
		foreach ($this->getFields() as $field) {
			$values['fields'][$field->getName()] = $field->assign();
		}
		return $values;
	}
}

/* vim:set tabstop=4 */