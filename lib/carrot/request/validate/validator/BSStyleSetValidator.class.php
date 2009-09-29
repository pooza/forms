<?php
/**
 * @package org.carrot-framework
 * @subpackage request.validate.validator
 */

/**
 * スタイルセット選択バリデータ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSStyleSetValidator.class.php 1513 2009-09-20 13:27:06Z pooza $
 */
class BSStyleSetValidator extends BSChoiceValidator {
	protected function getChoices () {
		$styleset = new BSStyleSet;
		return $styleset->getEntryNames();
	}
}

/* vim:set tabstop=4: */
