{*
一覧画面テンプレート

@package jp.co.commons.forms
@subpackage AdminRegistration
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id$
*}
<div>
	<a href="javascript:void(window.open('/AdminForm/Export', '{$module.name}Export', 'width=320,height=320,scrollbars=yes,'))"><img src="/carrotlib/images/document.gif" width="16" height="16" alt="" />CSVエクスポート</a>
	<a href="javascript:void(window.open('/AdminForm/Import', '{$module.name}Import', 'width=320,height=320,scrollbars=yes,'))"><img src="/carrotlib/images/document.gif" width="16" height="16" alt="" />CSVインポート</a>
</div>

<form onsubmit='return false;'>
	<input type="text" name="key" id="key" value="{$params.key}" />
	<input type="button" value="抽出" onclick="new Ajax.Updater('RegistrationList', '/{$module.name}/{$action.name}?key=' + encodeURI($('key').value))" />
	<input type="button" value="抽出の解除" onclick="new Ajax.Updater('RegistrationList', '/{$module.name}/ListAll')" />
</form>

{include file='ErrorMessages'}

<h1>{$action.title}</h1>
<table>
	<tr>
		<th width="60">ID</th>
		<th width="120">応募日付</th>
		<th width="90">ブラウザ種別</th>
		<th width="240">リモートホスト</th>
	</tr>

{foreach from=$registrations item='registration' name='registrations'}
	<tr>
		<td align="right"><a href="/{$module.name}/Detail/{$registration.id}">{$registration.id}</a></td>
		<td width="120">{$registration.create_date|date_format:'Y-m-d(ww) H:i'}</td>
		<td width="90">{$registration.user_agent|user_agent_type|default:'(不明)'}系</td>
		<td width="240">{$registration.remote_host|default:'(不明)'}</td>
	</tr>
{foreachelse}
	<tr>
		<td colspan="4" class="alert">登録されていません。</td>
	</tr>
{/foreach}

	<tr>
		<td colspan="4" style="text-align:center">
{strip}
			<span><a href="javascript:void({if 1<$page}new Ajax.Updater('RegistrationList','/{$module.name}/{$action.name}?page=1'){/if})"><img src="/carrotlib/images/navigation_arrow/left3.gif" width="14" height="14" alt="|&lt;" /></a></span>&nbsp;
			<span><a href="javascript:void({if 1<$page}new Ajax.Updater('RegistrationList','/{$module.name}/{$action.name}?page={$page-1}'){/if})"><img src="/carrotlib/images/navigation_arrow/left1.gif" width="14" height="14" alt="&lt;" /></a></span>&nbsp;
			[{$page}]&nbsp;
			<span><a href="javascript:void({if $page<$lastpage}new Ajax.Updater('RegistrationList','/{$module.name}/{$action.name}?page={$page+1}'){/if})"><img src="/carrotlib/images/navigation_arrow/right1.gif" width="14" height="14" alt="&gt;" /></a></span>&nbsp;
			<span><a href="javascript:void({if $page<$lastpage}new Ajax.Updater('RegistrationList','/{$module.name}/{$action.name}?page={$lastpage}'){/if})"><img src="/carrotlib/images/navigation_arrow/right3.gif" width="14" height="14" alt="&gt;|" /></a></span>
{/strip}
		</td>
	</tr>
</table>

{* vim: set tabstop=4: *}
