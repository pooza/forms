# 1.1.0→1.1.1へのアップグレード
#
# @package jp.co.b-shock.forms
# @author 小石達也 <tkoishi@b-shock.co.jp>

SET NAMES 'utf8';
ALTER TABLE `form` ADD `email` varchar(64) NULL DEFAULT NULL  AFTER `name`;

