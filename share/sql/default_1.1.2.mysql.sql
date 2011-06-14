# 1.1.1→1.1.2へのアップグレード
#
# @package jp.co.b-shock.forms
# @author 小石達也 <tkoishi@b-shock.co.jp>

SET NAMES 'utf8';
ALTER TABLE `form` ADD `rank` smallint UNSIGNED NULL DEFAULT NULL  AFTER `email`;

