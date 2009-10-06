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
			'form_id' => $field->getForm()->getID(),
			'field_id' => $field->getID(),
			'answer' => $answer,
		);
		$sql = BSSQL::getInsertQueryString('registration_detail', $values);
		$this->getTable()->getDatabase()->exec($sql);
	}
}

/* vim:set tabstop=4 */