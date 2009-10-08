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
class Registration extends BSRecord {
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
			$db = $this->getTable()->getDatabase();
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
		if (BSArray::isArray($answer)) {
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
		$this->getTable()->getDatabase()->exec($sql);
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
		$smtp->render();
		$smtp->send();
	}

	/**
	 * アサインすべき値を返す
	 *
	 * @access public
	 * @return mixed アサインすべき値
	 */
	public function getAssignValue () {
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