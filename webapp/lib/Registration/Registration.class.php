<?php
/**
 * @package jp.co.b-shock.forms
 */

/**
 * 応募レコード
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class Registration extends BSRecord {
	private $answers;

	/**
	 * 回答を返す
	 *
	 * @access public
	 * @return BSArray 回答明細
	 */
	public function getAnswers () {
		if (!$this->answers) {
			$this->answers = BSArray::create();
			$criteria = $this->createCriteriaSet();
			$criteria->register('detail.registration_id', $this);
			$criteria[] = 'detail.field_id=field.id';
			$sql = BSSQL::getSelectQueryString(
				['field.name AS field_name', 'detail.answer'],
				['registration_detail AS detail', 'field'],
				$criteria,
				'field.rank,field.id'
			);
			foreach ($this->getDatabase()->query($sql) as $row) {
				$this->answers[$row['field_name']] = $row['answer'];
			}
		}
		return $this->answers;
	}

	/**
	 * 明細追加
	 *
	 * @access public
	 * @param Field $field フィールド
	 * @param mixed $answer 回答
	 */
	public function registerDetail (Field $field, $answer) {
		if ($field->isFile()) {
			if (BSString::isBlank($path = $answer['tmp_name'])) {
				return;
			}
			$file = new BSFile($path);
			if (!$file->isReadable()) {
				throw new BSFileException($answer['name'] . 'が読み込めません。');
			}
			$this->setAttachment($field->getName(), $file);
			$answer = $file->getShortPath();
		} else if (is_array($answer) || ($answer instanceof BSParameterHolder)) {
			$answer = BSArray::create($answer);
			$answer = $answer->join("\n");
		}
		if (BSString::isBlank($answer)) {
			return;
		}

		$values = [
			'registration_id' => $this->getID(),
			'field_id' => $field->getID(),
			'answer' => $answer,
		];
		$sql = BSSQL::getInsertQueryString('registration_detail', $values);
		$this->getDatabase()->exec($sql);
	}

	/**
	 * メールを送信
	 *
	 * @access public
	 * @param string $template テンプレート名
	 * @param BSParameterHolder $params アサインするパラメータ
	 */
	public function sendMail ($template, BSParameterHolder $params = null) {
		$mail = new BSSmartyMail;

		if ($template instanceof BSTemplateFile) {
			$file = $template;
		} else if ($file = $mail->getRenderer()->searchTemplate($template . '.mail')) {
		} else if ($file = $this->getForm()->getTemplate($template)) {
		}
		$mail->getRenderer()->setTemplate($file);

		$mail->getRenderer()->setAttribute('registration', $this);
		$mail->getRenderer()->setAttribute('form', $this->getForm());
		$mail->getRenderer()->setAttribute('params', $params);

		BSTranslateManager::getInstance()->register($this->getForm(), BSArray::POSITION_TOP);
		if (BS_MAIL_INCLUDE_ANSWERS) {
			$mail->getRenderer()->setAttribute('is_include_answers', true);
		}

		$mail->send();
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
			$info = $this->getAttachmentInfo($name);
			$info['contents'] = $file->getContents();
			return $info;
		}
	}

	/**
	 * 全てのファイル属性
	 *
	 * @access protected
	 * @return BSArray ファイル属性の配列
	 */
	protected function getSerializableValues () {
		$values = $this->getAttributes();
		$values['answers'] = $this->getAnswers();
		return $values;
	}
}

/* vim:set tabstop=4 */