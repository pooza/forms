<?php
/**
 * @package jp.co.commons.forms
 */

/**
 * 応募ダンプ用のワークテーブル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class RegistrationDumpHandler extends RegistrationHandler implements BSExportable {
	private $exporter;
	private $name;
	private $form;

	/**
	 * @access public
	 * @param string $criteria 抽出条件
	 * @param string $order ソート順
	 */
	public function __construct ($criteria = null, $order = 'id') {
		if (($criteria instanceof Form) == false) {
			throw new BSException('フォームが指定されていません。');
		}
		$this->form = $criteria;

		parent::__construct(null, $order);

		$criteria = $this->getDatabase()->createCriteriaSet();
		$criteria->register('form_id', $this->form);
		$sql = 'CREATE TEMPORARY TABLE ' . $this->getName() . ' ';
		$sql .= BSSQL::getSelectQueryString('*', 'registration', $criteria, $this->getOrder());
		BSDatabase::getInstance()->exec($sql);

		foreach ($this->form->getFields() as $field) {
			$this->addField($field);
		}
	}

	/**
	 * テーブル名を返す
	 *
	 * @access public
	 * @return string テーブル名
	 */
	public function getName () {
		if (!$this->name) {
			$this->name = 'registration_' . BSUtility::getUniqueID();
		}
		return $this->name;
	}

	/**
	 * レコードクラス名を返す
	 *
	 * @access protected
	 * @return string レコードクラス名
	 */
	protected function getRecordClassName () {
		return 'Registration';
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
		$header = new BSArray;
		$header[] = '応募ID';
		$header[] = 'フォーム';
		$header[] = 'ブラウザ';
		$header[] = 'リモートホスト';
		$header[] = '応募日';
		foreach ($this->form->getFields() as $field) {
			$header[] = $field['label'];
		}
		return $header;
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
			$row = new BSArray($row);
			$row['form_id'] = $this->form->getName();
			$this->getExporter()->addRecord($row);
		}
		return $this->getExporter();
	}

	private function addField (Field $field) {
		$name = sprintf('a%02d', $field->getID());
		$sql = 'ALTER TABLE ' . $this->getName() . ' ADD COLUMN ' . $name . ' text';
		BSDatabase::getInstance()->exec($sql);

		$sql = 'UPDATE '
			. $this->getName() . ',registration_detail '
			. 'SET ' . $name . '=registration_detail.answer '
			. 'WHERE (' . $this->getName() . '.id=registration_detail.registration_id) '
			. ' AND (registration_detail.field_id=' . $field->getID() . ')';
		BSDatabase::getInstance()->exec($sql);
	}
}

/* vim:set tabstop=4: */
