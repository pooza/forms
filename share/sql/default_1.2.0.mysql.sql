# 1.1.2→1.2.0へのアップグレード
#
# @package jp.co.commons.forms
# @author 小石達也 <tkoishi@b-shock.co.jp>

SET NAMES 'utf8';
ALTER TABLE `form` ADD `pc_form_template` text NULL DEFAULT NULL  AFTER `email`;
ALTER TABLE `form` ADD `pc_confirm_template` text NULL DEFAULT NULL  AFTER `pc_form_template`;
ALTER TABLE `form` ADD `pc_thanx_template` text NULL DEFAULT NULL  AFTER `pc_confirm_template`;
ALTER TABLE `form` ADD `mobile_form_template` text NULL DEFAULT NULL  AFTER `pc_thanx_template`;
ALTER TABLE `form` ADD `mobile_confirm_template` text NULL DEFAULT NULL  AFTER `mobile_form_template`;
ALTER TABLE `form` ADD `mobile_thanx_template` text NULL DEFAULT NULL  AFTER `mobile_confirm_template`;
ALTER TABLE `form` ADD `smartphone_form_template` text NULL DEFAULT NULL  AFTER `mobile_thanx_template`;
ALTER TABLE `form` ADD `smartphone_confirm_template` text NULL DEFAULT NULL  AFTER `smartphone_form_template`;
ALTER TABLE `form` ADD `smartphone_thanx_template` text NULL DEFAULT NULL  AFTER `smartphone_confirm_template`;
ALTER TABLE `form` ADD `thanx_mail_template` text NULL DEFAULT NULL  AFTER `smartphone_thanx_template`;
