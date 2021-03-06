<?php
/**
 * @package jp.co.b-shock.carrot
 * @subpackage request.validate.validator
 */

/**
 * レコードバリデータ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class BSRecordValidator extends BSValidator {
	protected $table;

	/**
	 * 初期化
	 *
	 * @access public
	 * @param string[] $params パラメータ配列
	 */
	public function initialize ($params = []) {
		$this['table'] = null;
		$this['class'] = null;
		$this['field'] = 'id';
		$this['exist'] = true;
		$this['update'] = false;
		$this['exist_error'] = '登録されていません。';
		$this['duplicate_error'] = '既に登録されています。';
		$this['valid_values'] = [];
		$this['criteria'] = [];
		return parent::initialize($params);
	}

	/**
	 * 実行
	 *
	 * @access public
	 * @param mixed $value バリデート対象（レコードのID、又はその配列）
	 * @return boolean 妥当な値ならばTrue
	 */
	public function execute ($value) {
		$ids = BSArray::create($value);
		$ids->trim();
		foreach ($ids as $id) {
			if ($this->isExists($id)) {
				if (!$this['exist']) {
					$this->error = $this['duplicate_error'];
					return false;
				} else if ($this['valid_values'] && !$this->validateValues($id)) {
					return false;
				}
			} else {
				if ($this['exist']) {
					$this->error = $this['exist_error'];
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * レコードが存在するか
	 *
	 * @access protected
	 * @param integer $id レコードのID
	 * @return boolean 存在するならばTrue
	 */
	protected function isExists ($id) {
		if ($recordFound = $this->getRecord($id)) {
			if ($this['update']) {
				if ($recordModule = $this->controller->getModule()->getRecord()) {
					return ($recordModule->getID() != $recordFound->getID());
				} else {
					return false;
				}
			} else {
				return true;
			}
		}
		return false;
	}

	/**
	 * 妥当な値か
	 *
	 * @access protected
	 * @param integer $id レコードのID
	 * @return boolean 妥当な値ならばTrue
	 */
	protected function validateValues ($id) {
		$record = $this->getRecord($id);
		foreach ($this['valid_values'] as $field => $value) {
			$values = BSArray::create($value);
			if (!$values->isContain($record[$field])) {
				$message = new BSStringFormat('%sが正しくありません。');
				$message[] = BSTranslateManager::getInstance()->execute($field);
				$this->error = $message->getContents();
				return false;
			}
		}
		return true;
	}

	/**
	 * クラスのstaticメソッドを実行
	 *
	 * @access protected
	 * @param string $function メソッド名
	 * @return boolean メソッドの戻り値
	 */
	protected function executeModuleFunction ($function) {
		$value = $this->controller->getModule()->$function();
		if ($value instanceof BSRecord) {
			$value = $value->getID();
		}
		return $value;
	}

	/**
	 * 対象レコードを取得
	 *
	 * @access protected
	 * @param integer $id レコードのID
	 * @return BSRecord 対象レコード
	 */
	protected function getRecord ($id) {
		try {
			$values = [$this['field'] => $id];
			foreach (BSArray::create($this['criteria']) as $field => $value) {
				if (isset($value['function'])) {
					$value = $this->executeModuleFunction($value['function']);
				}
				$values[$field] = $value;
			}
			return $this->getTable()->getRecord($values);
		} catch (Exception $e) {
		}
	}

	/**
	 * 対象テーブルを取得
	 *
	 * @access protected
	 * @return BSTableHandler 対象テーブル
	 */
	protected function getTable () {
		if (!$this->table) {
			if (BSString::isBlank($class = $this['class'])) {
				$class = $this['table'];
			}
			$this->table = BSTableHandler::create($class);
		}
		return $this->table;
	}
}

