# 1.0→1.1へのアップグレード
#
# @package jp.co.commons.forms
# @author 小石達也 <tkoishi@b-shock.co.jp>

SET NAMES 'utf8';
INSERT INTO field_type VALUES ('file','ファイル'),('image','画像'),('date','日付');
ALTER TABLE `field` ADD `has_confirm_field` tinyint(3) UNSIGNED NOT NULL DEFAULT '0'  AFTER `required`;
