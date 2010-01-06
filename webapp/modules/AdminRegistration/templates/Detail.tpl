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
	<a href="#">{$action.title}</a>
</div>

<h1>{$action.title}</h1>

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
		<th>
	{if $form.fields[$field].choices}
			<a href="{carrot_url module='AdminField' action='Detail' record=$form.fields[$field].id params_pane='Statistics'}">{$field|translate}</a>
	{else}
			{$field|translate}
	{/if}
		</th>
		<td>
	{if $form.fields[$field].is_image}
			{image_cache size=$field pixel=400 mode='lightbox'}<br/>
	{elseif $form.fields[$field].is_file}
			<a href="{carrot_url module='AdminRegistration' action='Attachment' record=$registration.id param_name=$form.fields[$field].name}"><img src="/carrotlib/images/document.gif" width="16" height="16" alt="ダウンロード" /></a>
	{/if}
			{$answer|nl2br}
		</td>
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
