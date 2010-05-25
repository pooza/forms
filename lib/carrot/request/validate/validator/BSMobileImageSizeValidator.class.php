<?php
/**
 * @package org.carrot-framework
 * @subpackage request.validate.validator
 */

/**
 * 本文に含まれる画像サイズを確認するバリデータ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSMobileImageSizeValidator.class.php 2101 2010-05-25 09:11:31Z pooza $
 */
class BSMobileImageSizeValidator extends BSValidator {

	/**
	 * 初期化
	 *
	 * @access public
	 * @param string[] $params パラメータ配列
	 */
	public function initialize ($params = array()) {
		$this['size'] = 100;
		parent::initialize($params);

		$message = new BSStringFormat('貼り付けられた画像が大きすぎます。%sKB迄に収めて下さい。');
		$message[] = number_format($this['size']);
		$this['size_error'] = $message->getContents();

		return true;
	}

	/**
	 * 実行
	 *
	 * @access public
	 * @param mixed $value バリデート対象
	 * @return boolean 妥当な値ならばTrue
	 */
	public function execute ($value) {
		$total = strlen($value);
		foreach (BSString::eregMatchAll('<img [^>]*src="([^"]+)"[^>]*/>', $value) as $matches) {
			$image = BSImageCacheHandler::getInstance()->getThumbnail(
				BSFileUtility::getDirectory('www')->getEntry($matches[1], 'BSImageFile'),
				null,
				BS_IMAGE_MOBILE_SIZE_WIDTH,
				BSImageCacheHandler::WIDTH_FIXED
			);
			$total += $image->getSize();
		}
		if (($this['size'] * 1024) < $total) {
			$this->error = $this['size_error'];
			return false;
		}
		return true;
	}
}

/* vim:set tabstop=4: */
