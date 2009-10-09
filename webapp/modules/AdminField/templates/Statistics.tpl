{*
フィールド詳細画面テンプレート

@package jp.co.commons.forms
@subpackage AdminField
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id$
*}
<h2>■回答構成比</h2>

{if $statistics}
<table>
{foreach from=$statistics item='row'}
<tr>
	<td width="210">{$row.answer}</td>
	<td width="60" align="right">{$row.percentage*100|string_format:'%.1f'}%</td>
	<td width="120">
	{if $row.count}
		<img src="/carrotlib/images/bar.gif" height="8" width="{$row.percentage*100|floor}" alt="" />
		{$row.count|number_format}
	{/if}
	</td>
</tr>
{/foreach}
</table>
{else}
<p class="alert">回答がありません。</p>
{/if}

{* vim: set tabstop=4: *}
