<?php
/**
 * @package jp.co.commons.forms
 */

/**
 * 応募レコード
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class Registration extends BSRecord implements BSAttachmentContainer {
	private $answers;
	static private $smtp;

	/**
	 * 回答を返す
	 *
	 * @access public
	 * @return BSArray 回答明細
	 */
	public function getAnswers () {
		if (!$this->answers) {
			$this->answers = new BSArray;
			$db = $this->getDatabase();
			$criteria = $db->createCriteriaSet();
			$criteria->register('detail.registration_id', $this);
			$criteria[] = 'detail.field_id=field.id';
			$sql = BSSQL::getSelectQueryString(
				array('field.name AS field_name', 'detail.answer'),
				array('registration_detail AS detail', 'field'),
				$criteria,
				'field.rank,field.id'
			);
			foreach ($db->query($sql) as $row) {
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
			if (!$file->isWritable()) {
				throw new BSFileException($answer['name'] . 'が読み込めません。');
			}
			$this->setAttachment($file, $answer['name'], $field->getName());
			$answer = $file->getShortPath();
		} else if (BSArray::isArray($answer)) {
			$answer = new BSArray($answer);
			$answer = $answer->join("\n");
		}
		if (BSString::isBlank($answer)) {
			return;
		}

		$values = array(
			'registration_id' => $this->getID(),
			'field_id' => $field->getID(),
			'answer' => $answer,
		);
		$sql = BSSQL::getInsertQueryString('registration_detail', $values);
		$this->getDatabase()->exec($sql);
	}

	/**
	 * メール送信
	 *
	 * @access public
	 * @param string $template テンプレート、又はテンプレート名
	 * @param BSParameterHolder $params 追加パラメータ
	 */
	public function sendMail ($template, BSParameterHolder $params = null) {
		$smtp = $this->getSender();
		if ($template instanceof BSTemplateFile) {
			$file = $template;
		} else if ($file = $smtp->getRenderer()->searchTemplate($template . '.mail')) {
		} else if ($file = $this->getForm()->getTemplateFile($template)) {
		}

		$smtp->setTemplate($file);
		$smtp->setAttribute('registration', $this);
		$smtp->setAttribute('form', $this->getForm());
		$smtp->setAttribute('params', $params);

		if (BS_MAIL_INCLUDE_ANSWERS) {
			BSTranslateManager::getInstance()->register($this->getForm(), BSArray::POSITION_TOP);
			$smtp->setAttribute('is_include_answers', true);
		}

		$smtp->render();
		$smtp->send();
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
		$url['module'] = 'AdminRegistration';
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
	 * 全てのファイル属性
	 *
	 * @access protected
	 * @return BSArray ファイル属性の配列
	 */
	protected function getFullAttributes () {
		$values = $this->getAttributes();
		$values['answers'] = $this->getAnswers();
		return $values;
	}

	static private function getSender () {
		if (!self::$smtp) {
			self::$smtp = new BSSmartySender;
		}
		return self::$smtp;
	}
}

/* vim:set tabstop=4 */