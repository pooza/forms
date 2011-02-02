<?php
/**
 * UserFormモジュール
 *
 * @package jp.co.commons.forms
 * @subpackage UserForm
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class UserFormModule extends BSModule {

	/**
	 * テンプレートを返す
	 *
	 * @access public
	 * @param string $name テンプレート名
	 * @return BSTemplateFile テンプレート
	 */
	public function getTemplate ($name) {
		$record = $this->getRecord();
		$useragent = $this->request->getUserAgent();

		if ($useragent->isSmartPhone()) {
			if (!BSString::isBlank($record['smartphone_' . $name . '_template'])) {
				return $record->getTemplate('smartphone_' . $name);
			}
		}
		if ($useragent->isSmartPhone() || $useragent->isMobile()) {
			if (!BSString::isBlank($record['mobile_' . $name . '_template'])) {
				return $record->getTemplate('mobile_' . $name);
			}
		}
		return $record->getTemplate('pc_' . $name);
	}
}

/* vim:set tabstop=4: */
