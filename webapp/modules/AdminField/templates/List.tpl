{*
一覧画面テンプレート

@package jp.co.commons.forms
@subpackage AdminField
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id$
*}
<h2>■{$action.title}</h2>
<table>
	<tr>
		<th width="150">名前</th>
		<th width="150">ラベル</th>
		<th width="90">種別</th>
		<th width="30">必須</th>
		<th width="30">選択</th>
		<th width="60"></th>
		<th width="60"></th>
	</tr>
	<tr>
		<td colspan="7">
			<a href="/{$module.name}/Create">新しいフィールドを登録...</a>
		</td>
	</tr>

{foreach from=$fields item='field' name='fields'}
	<tr class="{$field.status}">
		<td width="150"><a href="/{$module.name}/Detail/{$field.id}">{$field.name}</a></td>
		<td width="150">{$field.label}</td>
		<td width="90">{$field.field_type_id|translate:'FieldHandler'}</td>
		<td width="30" align="center">{if $field.required}○{/if}</td>
		<td width="30" align="center">{if $field.has_statistics}○{/if}</td>
		<td width="60" align="center">
	{if $field.has_statistics}
			<a href="/{$module.name}/Detail/{$field.id}?pane=Statistics">構成比</a>
	{/if}
		</td>
		<td width="60" align="center">
	{strip}
		{if $smarty.foreach.fields.first}
			△
		{else}
			<a href="javascript:void(new Ajax.Updater('FieldList','/{$module.name}/SetRank/{$field.id}?option=up'))">▲</a>
		{/if}

		{if $smarty.foreach.fields.last}
			▽
		{else}
			<a href="javascript:void(new Ajax.Updater('FieldList','/{$module.name}/SetRank/{$field.id}?option=down'))">▼</a>
		{/if}
	{/strip}
		</td>
	</tr>
{foreachelse}
	<tr>
		<td colspan="7" class="alert">登録されていません。</td>
	</tr>
{/foreach}

</table>

{* vim: set tabstop=4: *}
