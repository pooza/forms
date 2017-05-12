{*
一覧画面テンプレート

@package jp.co.b-shock.forms
@subpackage AdminField
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
<h2>■{$action.title}</h2>
<table>
	<tr>
		<th width="120">名前</th>
		<th width="180">ラベル</th>
		<th width="90">種別</th>
		<th width="30">必須</th>
		<th width="30">確認</th>
		<th width="30">DL</th>
		<th width="60"></th>
		<th width="60"></th>
	</tr>
{if $credentials.AdminEdit}
	<tr>
		<td colspan="8">
			<a href="/{$module.name}/Create">新しいフィールドを登録...</a>
		</td>
	</tr>
{/if}

{foreach from=$fields item='field' name='fields'}
	<tr class="{$field.status}">
		<td width="120">
	{if $credentials.AdminEdit}
			<a href="/{$module.name}/Detail/{$field.id}">{$field.name}</a>
	{else}
			{$field.name}
	{/if}
		</td>
		<td width="180">{$field.label|truncate:48}</td>
		<td width="90">{$field.field_type_id|translate:'FieldHandler'}</td>
		<td width="30" align="center">{if $field.required}○{/if}</td>
		<td width="30" align="center">{if $field.has_confirm_field}○{/if}</td>
		<td width="30" align="center">
	{if $field.is_file}
			<a href="{carrot_url module='AdminField' action='Export' record=$field.id}"><img src="/carrotlib/images/document.gif" width="16" height="16" alt="ダウンロード" /></a>
	{/if}
		</td>
		<td width="60" align="center">
	{if $field.has_statistics}
			<a href="/{$module.name}/Detail/{$field.id}?pane=Statistics">構成比</a>
	{/if}
		</td>
		<td width="60" align="center">
	{if $credentials.AdminEdit}
		{if $smarty.foreach.fields.first}
			<img src="/carrotlib/images/navigation_arrow/top_off.gif" width="11" height="11" alt="TOP"/>
			<img src="/carrotlib/images/navigation_arrow/up_off.gif" width="11" height="11" alt="UP"/>
		{else}
			<a href="javascript:void(new Ajax.Updater('FieldList','/{$module.name}/SetRank/{$field.id}?option=top'))"><img src="/carrotlib/images/navigation_arrow/top_on.gif" width="11" height="11" alt="TOP"/></a>
			<a href="javascript:void(new Ajax.Updater('FieldList','/{$module.name}/SetRank/{$field.id}?option=up'))"><img src="/carrotlib/images/navigation_arrow/up_on.gif" width="11" height="11" alt="UP"/></a>
		{/if}

		{if $smarty.foreach.fields.last}
			<img src="/carrotlib/images/navigation_arrow/down_off.gif" width="11" height="11" alt="DOWN"/>
			<img src="/carrotlib/images/navigation_arrow/bottom_off.gif" width="11" height="11" alt="DOWN"/>
		{else}
			<a href="javascript:void(new Ajax.Updater('FieldList','/{$module.name}/SetRank/{$field.id}?option=down'))"><img src="/carrotlib/images/navigation_arrow/down_on.gif" width="11" height="11" alt="DOWN"/></a>
			<a href="javascript:void(new Ajax.Updater('FieldList','/{$module.name}/SetRank/{$field.id}?option=bottom'))"><img src="/carrotlib/images/navigation_arrow/bottom_on.gif" width="11" height="11" alt="BOTTOM"/></a>
		{/if}
	{/if}
		</td>
	</tr>
{foreachelse}
	<tr>
		<td colspan="8" class="alert">登録されていません。</td>
	</tr>
{/foreach}

</table>

