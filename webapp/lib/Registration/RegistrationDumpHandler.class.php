<?php
/**
 * @package jp.co.b-shock.forms
 */

/**
 * 応募ダンプ用のワークテーブル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class RegistrationDumpHandler extends RegistrationHandler implements BSExportable {
	private $exporter;
	private $name;
	private $form;
	private $date;
	private $permission;

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

		if (!$order) {
			$order = 'create_date';
		}

		parent::__construct(null, $order);

		$criteria = $this->createCriteriaSet();
		$criteria->register('form_id', $this->form);
		$sql = 'CREATE TEMPORARY TABLE ' . $this->getName() . ' ';
		$sql .= BSSQL::getSelectQueryString('*', 'registration', $criteria, $this->getOrder());
		$this->getDatabase()->exec($sql);

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
	 * 日付を設定
	 *
	 * @access public
	 * @param BSDate $date 日付
	 */
	public function setDate (BSDate $date) {
		$this->date = $date;
	}

	/**
	 * メールパーミッションの扱いを設定
	 *
	 * @access public
	 * @param boolean $permission Trueならば、mail_permissionフィールドがチェックされた応募を抽出
	 */
	public function setMailPermission ($permission) {
		$this->permission = !!$permission;
	}

	/**
	 * ディレクトリを返す
	 *
	 * @access public
	 * @return BSDirectory ディレクトリ
	 */
	public function getDirectory () {
		return BSFileUtility::getDirectory('registration');
	}

	/**
	 * レコードクラス名を返す
	 *
	 * @access protected
	 * @return string レコードクラス名
	 */
	protected function getRecordClass () {
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
		$header = BSArray::create();
		$header[] = '応募ID';
		$header[] = 'フォーム';
		$header[] = 'ブラウザ';
		$header[] = '-';
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
		$criteria = $this->createCriteriaSet();
		if ($this->permission) {
			$values = BSArray::create([
				'form_id' => $this->form->getID(),
				'name' => 'mail_permission',
			]);
			if ($field = $this->form->getFields()->getRecord($values)) {
				$criteria->register(sprintf('a%02d', $field->getID()), 1);
			}
		}
		if ($this->date) {
			$duration = BSArray::create([
				$this->date->format('Y-m-d 00:00:00'),
				$this->date->format('Y-m-d 23:59:59'),
			]);
		}
		$sql = BSSQL::getSelectQueryString('*', $this->getName(), $criteria);
		foreach ($this->getDatabase()->query($sql) as $row) {
			$row = BSArray::create($row);
			$row['form_id'] = $this->form->getName();
			$this->getExporter()->addRecord($row);
		}
		return $this->getExporter();
	}

	private function addField (Field $field) {
		$name = sprintf('a%02d', $field->getID());
		$sql = 'ALTER TABLE ' . $this->getName() . ' ADD COLUMN ' . $name . ' text';
		$this->getDatabase()->exec($sql);

		$sql = 'UPDATE '
			. $this->getName() . ',registration_detail '
			. 'SET ' . $name . '=registration_detail.answer '
			. 'WHERE (' . $this->getName() . '.id=registration_detail.registration_id) '
			. ' AND (registration_detail.field_id=' . $field->getID() . ')';
		$this->getDatabase()->exec($sql);
	}
}

