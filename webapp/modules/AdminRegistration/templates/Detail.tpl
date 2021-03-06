{*
フォーム詳細画面テンプレート

@package jp.co.b-shock.forms
@subpackage AdminRegistration
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
{include file='AdminHeader'}

<nav class="bread_crumbs">
	<a href="/AdminForm/">フォーム一覧</a>
	<a href="/AdminForm/Detail/{$form.id}?pane=RegistrationList">フォーム:{$form.name}</a>
	<a href="#">{$action.title}</a>
</nav>

<h1>{$action.title}</h1>

{include file='ErrorMessages'}

<table class="detail">
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
	{if $answer}
		{if $form.fields[$field].is_image}
			{image_cache src=$answer pixel=400 style_class='bordered'}<br/>
		{/if}
		{if $form.fields[$field].is_file}
			<a href="{carrot_url module='AdminRegistration' action='Attachment' record=$registration.id param_name=$form.fields[$field].name}"><img src="/carrotlib/images/document.gif" width="16" height="16" alt="ダウンロード" /></a>
		{/if}

			{$answer|nl2br}

		{if $field=='birthday'}
			({$answer|date2age}歳)
		{/if}
	{/if}
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

