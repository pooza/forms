{*
登録報告
 
@package jp.co.commons.forms
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id$
*}
Subject: [{const name='app_name_ja'}] {$form.name|default:'(不明)'}
{if $registration.answers.email}
From: {$registration.answers.email}
{else}
From: {const name='admin_email'}
{/if}
{if $form.email}
To: {$form.email}
{else}
To: {const name='author_email'}
{/if}

フォーム:
{$form.name|default:'(不明)'}

応募ID:
{$registration.id|default:'(不明)'}

応募詳細:
{const name='root_url'}AdminRegistration/Detail/{$registration.id}

日時:
{$registration.create_date|date_format:'Y/n/j(ww) H:i:s'}

{if $is_include_answers}
{foreach from=$registration.answers key='field' item='answer'}
{$field|translate}:
{$answer}

{/foreach}
{/if}

クライアントホスト:
{$client_host.ip}
{$client_host.name|default:'(名前解決に失敗)'}

ブラウザ:
{$useragent.type}系
{$useragent.name}
