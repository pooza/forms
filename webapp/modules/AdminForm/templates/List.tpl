{*
一覧画面テンプレート

@package jp.co.b-shock.forms
@subpackage AdminForm
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id$
*}
{include file='AdminHeader'}

<div id="BreadCrumbs">
	<a href="#">{$action.title}</a>
</div>

{include file='ErrorMessages'}

<h1>{$action.title}</h1>
<table>
	<tr>
		<th width="420">名前</th>
		<th width="60"></th>
	</tr>

{if $credentials.AdminEdit}
	<tr>
		<td colspan="2">
			<a href="/{$module.name}/Create">新しいフォームを登録...</a>
		</td>
	</tr>
{/if}

{foreach from=$forms item='form' name='forms'}
	<tr class="{$form.status}">
		<td width="420"><a href="/{$module.name}/Detail/{$form.id}">{$form.name}</a></td>
		<td width="60" align="center">
	{if $credentials.AdminEdit}
		{if $smarty.foreach.forms.first}
			<img src="/carrotlib/images/navigation_arrow/top_off.gif" width="11" height="11" alt="TOP"/>
			<img src="/carrotlib/images/navigation_arrow/up_off.gif" width="11" height="11" alt="UP"/>
		{else}
			<a href="/{$module.name}/SetRank/{$form.id}?option=top"><img src="/carrotlib/images/navigation_arrow/top_on.gif" width="11" height="11" alt="TOP"/></a>
			<a href="/{$module.name}/SetRank/{$form.id}?option=up"><img src="/carrotlib/images/navigation_arrow/up_on.gif" width="11" height="11" alt="UP"/></a>
		{/if}

		{if $smarty.foreach.forms.last}
			<img src="/carrotlib/images/navigation_arrow/down_off.gif" width="11" height="11" alt="DOWN"/>
			<img src="/carrotlib/images/navigation_arrow/bottom_off.gif" width="11" height="11" alt="DOWN"/>
		{else}
			<a href="/{$module.name}/SetRank/{$form.id}?option=down"><img src="/carrotlib/images/navigation_arrow/down_on.gif" width="11" height="11" alt="DOWN"/></a>
			<a href="/{$module.name}/SetRank/{$form.id}?option=bottom"><img src="/carrotlib/images/navigation_arrow/bottom_on.gif" width="11" height="11" alt="BOTTOM"/></a>
		{/if}
	{/if}
		</td>
	</tr>
{foreachelse}
	<tr>
		<td colspan="2" class="alert">登録されていません。</td>
	</tr>
{/foreach}

</table>

{include file='AdminFooter'}

{* vim: set tabstop=4: *}
