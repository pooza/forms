{*
フォーム詳細画面テンプレート

@package jp.co.commons.forms
@subpackage AdminRegistration
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id$
*}
{include file='AdminHeader'}

<div id="BreadCrumbs">
	<a href="/AdminForm/">フォーム一覧</a>
	<a href="/AdminForm/Detail/{$form.id}?pane=RegistrationList">{$form.name}</a>
	<a href="#">応募詳細</a>
</div>

<h1>応募詳細</h1>

{include file='ErrorMessages'}

<table class="Detail">
	<tr>
		<th>応募ID</th>
		<td>{$registration.id}</td>
	</tr>
	<tr>
		<th>応募日付</th>
		<td>{$registration.create_date|date_format:'Y年n月j日(ww) H:i:s'}</td>
	</tr>

{foreach from=$registration.answers key='field' item='answer'}
	<tr>
		<th>{$field|translate}</th>
		<td>{$answer}</td>
	</tr>
{/foreach}

	<tr>
		<th>ブラウザ</th>
		<td>
			{$registration.user_agent|user_agent_type|default:'(不明)'}系<br/>
			{$registration.user_agent|default:'(不明)'}
		</td>
	</tr>
	<tr>
		<th>リモートホスト</th>
		<td>{$registration.remote_host|default:'(不明)'}</td>
	</tr>
</table>

{include file='AdminFooter'}

{* vim: set tabstop=4: *}
