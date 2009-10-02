{*
フォーム詳細画面テンプレート

@package jp.co.commons.forms
@subpackage AdminForm
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id$
*}
{include file='AdminHeader'}

<div id="BreadCrumbs">
	<a href="/{$module.name}/">フォーム一覧</a>
	<a href="#">{$action.title}</a>
</div>

<h1>{$action.title}</h1>

<div class="tabs10">
	<ul id="Tabs">
		<li><a href="#DetailForm"><span>フォーム詳細</span></a></li>
		<li><a href="#FieldList"><span>フィールド管理</span></a></li>
		{if $form.has_form_template}<li><a href="#FormTemplateViewer"><span>フォームテンプレート内容</span></a></li>{/if}
		{if $form.has_confirm_template}<li><a href="#ConfirmTemplateViewer"><span>確認画面テンプレート内容</span></a></li>{/if}
	</ul>
</div>

<div id="DetailForm" class="panel">
	{form attachable=true}
		<h2>■フォーム詳細</h2>

		{include file='ErrorMessages'}

		<table class="Detail">
			<tr>
				<th>フォームID</th>
				<td>{$form.id}</td>
			</tr>
			<tr>
				<th>名前</th>
				<td>
					<input type="text" name="name" value="{$params.name}" size="48" maxlength="64" />
				</td>
			</tr>
			<tr>
				<th>フォームテンプレート</th>
				<td>
					<input type="file" name="form_template" size="30" /><br/>
{if $form.has_form_template}
					<a href="{$form.form_template.url}" ><img src="/carrotlib/images/document.gif" width="16" height="16" alt="" /></a>
					{$form.form_template.size|binary_size_format}B
					[<a href="/{$module.name}/DeleteAttachment?name=form_template">このファイルを削除</a>]
{/if}
				</td>
			</tr>
			<tr>
				<th>確認画面テンプレート</th>
				<td>
					<input type="file" name="confirm_template" size="30" /><br/>
{if $form.has_confirm_template}
					<a href="{$form.confirm_template.url}" ><img src="/carrotlib/images/document.gif" width="16" height="16" alt="" /></a>
					{$form.confirm_template.size|binary_size_format}B
					[<a href="/{$module.name}/DeleteAttachment?name=confirm_template">このファイルを削除</a>]
{/if}
				</td>
			</tr>
			<tr>
				<th>状態</th>
				<td>
					{html_radios name='status' options=$status_options selected=$params.status}
				</td>
			</tr>
			<tr>
				<th>作成日</th>
				<td>{$form.create_date|date_format:'Y年 n月j日 (ww) H:i:s'}</td>
			</tr>
			<tr>
				<th>更新日</th>
				<td>{$form.update_date|date_format:'Y年 n月j日 (ww) H:i:s'}</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" value="更新" />
					<input type="button" value="このフォームを削除..." onclick="confirmDelete('{$module.name}','Delete','フォーム')" />
				</td>
			</tr>
		</table>
	{/form}
</div>

<div id="FieldList" class="panel"></div>

{if $form.has_form_template}
<div id="FormTemplateViewer" class="panel">
	{smarty_preformatted}{$form.form_template.contents}{/smarty_preformatted}
	<br/>({$form.form_template.size|binary_size_format}B)
</div>
{/if}

{if $form.has_confirm_template}
<div id="ConfirmTemplateViewer" class="panel">
	{smarty_preformatted}{$form.confirm_template.contents}{/smarty_preformatted}
	<br/>({$form.confirm_template.size|binary_size_format}B)
</div>
{/if}

<script type="text/javascript">
actions.onload.push(function(){ldelim}
  new ProtoTabs('Tabs', {ldelim}
    defaultPanel:'{$params.pane|default:'DetailForm'}',
    ajaxUrls: {ldelim}
      FieldList: '/AdminField/List/{$form.id}'
    {rdelim}
  {rdelim});
{rdelim});
</script>

{include file='AdminFooter'}

{* vim: set tabstop=4: *}
