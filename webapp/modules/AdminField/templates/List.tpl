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
		<th width="240">ラベル</th>
		<th width="90">種別</th>
		<th width="60">必須</th>
		<th width="60">選択</th>
		<th width="60"></th>
	</tr>
	<tr>
		<td colspan="6">
			<a href="/{$module.name}/Create">新しいフィールドを登録...</a>
		</td>
	</tr>

{foreach from=$fields item='field' name='fields'}
	<tr class="{$field.status}">
		<td width="150"><a href="/{$module.name}/Detail/{$field.id}">{$field.name}</a></td>
		<td width="240">{$field.label}</td>
		<td width="90">{$field.field_type_id|translate:'FieldHandler'}</td>
		<td width="60" align="center">{if $field.required}○{/if}</td>
		<td width="60" align="center">{if $field.choices}○{/if}</td>
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
		<td colspan="6" class="alert">登録されていません。</td>
	</tr>
{/foreach}

</table>

{* vim: set tabstop=4: *}
