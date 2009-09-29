/**
 * AHAHエンジン
 *
 * @package org.carrot-framework
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: ahah.js 501 2008-08-17 16:36:14Z pooza $
 */

function ahah (id, href) {
  if (window.XMLHttpRequest) {
    var req = new XMLHttpRequest();
  } else if (window.ActiveXObject) {
    var req = new ActiveXObject('Microsoft.XMLHTTP');
  } else {
    return false;
  }

  var element = document.getElementById(id);
  req.onreadystatechange = function() {
    if (req.readyState < 4) {
      return;
    } else if (req.status == 200) {
      element.innerHTML = req.responseText;
    } else {
      element.innerHTML = 'AHAH Error: ' + req.statusText;
    }
  }
  req.open('GET', href, true);
  req.send('');
}