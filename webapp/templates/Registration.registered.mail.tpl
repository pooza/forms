{*
登録報告
 
@package jp.co.commons.forms
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id$
*}
Subject: [{const name='app_name_ja'}] {$form.name|default:'(不明)'}
From: {const name='admin_email'}
To: {const name='author_email'}

フォーム:
{$form.name|default:'(不明)'}

応募ID:
{$registration.id|default:'(不明)'}

日時:
{$registration.create_date|date_format:'Y/n/j(ww) H:i:s'}

クライアントホスト:
{$client_host.ip}
{$client_host.name|default:'(名前解決に失敗)'}

ブラウザ:
{$useragent.type}系
{$useragent.name}
