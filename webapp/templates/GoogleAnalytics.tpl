{*
GoogleAnalyticsテンプレート

@package org.carrot-framework
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id: GoogleAnalytics.tpl 1934 2010-03-25 09:37:36Z pooza $
*}

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {ldelim}
var pageTracker = _gat._getTracker("UA-{$google_analytics.id}");
pageTracker._trackPageview();
{rdelim} catch(err) {ldelim}{rdelim}
</script>

{* vim: set tabstop=4: *}
