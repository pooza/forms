{*
経歴詳細画面テンプレート

@package jp.co.b-shock.forms
@subpackage AdminForm
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<title>{const name='app_name_ja'} {$title}</title>
{js_cache name=$jsset}
{css_cache name=$styleset}
<script type="text/javascript">
document.observe('dom:loaded', function(){
  new InputCalendar('date', {
    lang:'ja',
    format:'yyyy-mm-dd'
  });
});
</script>
</head>
<body>
	<h1>{$action.title}</h1>
	{include file='ErrorMessages'}
	{form onsubmit=''}
		<table>
			<tr>
				<th width="60" align="left">日付</th>
				<td width="210"><input type="text" id="date" name="date" size="10" maxlength="10" class="english" /></td>
			</tr>
			<tr>
				<th width="60" align="left">mail_permissionフィールド</th>
				<td width="210">
					{if $form.fields.mail_permission}
						<label><input type="checkbox" name="mail_permission" value="1" />チェックされている</label>
					{else}
						<span class="alert">未登録です。</span>
					{/if}
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" value="送信" />
				</td>
			</tr>
		</table>
	{/form}
</body>
</html>
