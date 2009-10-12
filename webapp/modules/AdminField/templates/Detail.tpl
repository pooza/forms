{*
フィールド詳細画面テンプレート

@package jp.co.commons.forms
@subpackage AdminField
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id$
*}
{include file='AdminHeader'}

<div id="BreadCrumbs">
	<a href="/AdminForm/">フォーム一覧</a>
	<a href="/AdminForm/Detail/{$form.id}?pane=FieldList">フォーム:{$form.name}</a>
	<a href="#">{$action.title}</a>
</div>

<h1>{$action.title}</h1>

<div class="tabs10">
	<ul id="Tabs">

{if $credentials.AdminEdit}
		<li><a href="#DetailForm"><span>フィールド詳細</span></a></li>
{/if}

		{if $field.choices}<li><a href="#Statistics"><span>回答構成比</span></a></li>{/if}
	</ul>
</div>

{if $credentials.AdminEdit}
<div id="DetailForm" class="panel">
	{form}
		<h2>■フィールド詳細</h2>

		{include file='ErrorMessages'}

		<table class="Detail">
			<tr>
				<th>フィールドID</th>
				<td>{$field.id}</td>
			</tr>
			<tr>
				<th>名前</th>
				<td>
					<input type="text" name="name" value="{$params.name}" size="48" maxlength="64" class="english" /><br/>
					<span class="alert">input要素のname属性に使われます。</span>
				</td>
			</tr>
			<tr>
				<th>ラベル</th>
				<td>
					<input type="text" name="label" value="{$params.label}" size="48" maxlength="64" /><br/>
					<span class="alert">日本語で。</span>
				</td>
			</tr>
			<tr>
				<th>フィールド種別</th>
				<td>
					{html_options name='field_type_id' options=$types selected=$params.field_type_id}
				</td>
			</tr>
			<tr>
				<th>選択肢</th>
				<td>
					<textarea name="choices" cols="60" rows="8" />{$params.choices}</textarea><br/>
					<span class="alert">改行で区切って。</span>
				</td>
			</tr>
			<tr>
				<th></th>
				<td>
					<label><input type="checkbox" name="required" value="1" {if $params.required}checked="checked"{/if} />必須項目</label>
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
				<td>{$field.create_date|date_format:'Y年 n月j日 (ww) H:i:s'}</td>
			</tr>
			<tr>
				<th>更新日</th>
				<td>{$field.update_date|date_format:'Y年 n月j日 (ww) H:i:s'}</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" value="更新" />
					<input type="button" value="このフィールドを削除..." onclick="confirmDelete('{$module.name}','Delete','フィールド')" />
				</td>
			</tr>
		</table>
	{/form}
</div>
{/if}

{if $field.choices}
<div id="Statistics" class="panel"></div>
{/if}

<script type="text/javascript">
actions.onload.push(function(){ldelim}
  new ProtoTabs('Tabs', {ldelim}
    defaultPanel:'{$params.pane|default:'DetailForm'}',
    ajaxUrls: {ldelim}
      Statistics: '/{$module.name}/Statistics/{$field.id}'
    {rdelim}
  {rdelim});
{rdelim});
</script>

{include file='AdminFooter'}

{* vim: set tabstop=4: *}
