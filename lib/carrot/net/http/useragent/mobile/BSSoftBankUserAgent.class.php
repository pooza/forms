<?php
/**
 * @package jp.co.b-shock.carrot
 * @subpackage net.http.useragent.mobile
 */

/**
 * SoftBankユーザーエージェント
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class BSSoftBankUserAgent extends BSMobileUserAgent {
	const DEFAULT_NAME = 'SoftBank';

	/**
	 * @access protected
	 * @param string $name ユーザーエージェント名
	 */
	protected function __construct ($name = null) {
		if (BSString::isBlank($name)) {
			$name = self::DEFAULT_NAME;
		}
		parent::__construct($name);
		$this['is_3gc'] = $this->is3GC();
		$this->supports['cookie'] = true;
		$this->supports['attach_file'] = true;
	}

	/**
	 * 3GC端末か？
	 *
	 * @access public
	 * @return boolean 3GC端末ならばTrue
	 */
	public function is3GC () {
		return !mb_ereg('^J-PHONE', $this->getName());
	}

	/**
	 * 旧機種か？
	 *
	 * @access public
	 * @return boolean 旧機種ならばTrue
	 */
	public function isLegacy () {
		if (BS_USERAGENT_MOBILE_DENY_ON_HTTPS && $this->request->isSSL()) {
			return true;
		}
		return !$this->is3GC();
	}

	/**
	 * 規定のエンコードを返す
	 *
	 * @access public
	 * @return string 規定のエンコード
	 */
	public function getDefaultEncoding () {
		return 'utf8';
	}

	/**
	 * 画面情報を返す
	 *
	 * @access public
	 * @return BSArray 画面情報
	 */
	public function getDisplayInfo () {
		if (BSString::isBlank($info = $this->controller->getAttribute('X-JPHONE-DISPLAY'))) {
			return parent::getDisplayInfo();
		}
		$info = BSString::explode('*', $info);

		return BSArray::create([
			'width' => (int)$info[0],
			'height' => (int)$info[1],
		]);
	}

	/**
	 * 一致すべきパターンを返す
	 *
	 * @access public
	 * @return string パターン
	 */
	public function getPattern () {
		return '^(J-PHONE|MOT|Vodafone|SoftBank)';
	}
}

