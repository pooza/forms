/**
 * carrot汎用 JavaScript
 *
 * @package org.carrot-framework
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: carrot.js 2251 2010-08-05 06:38:33Z pooza $
 */

function redirect (m, a, id) {
  var url = '/' + m + '/' + a;
  if (id) {
    url += '/' + id;
  }
  window.location.href = url;
}

function confirmDelete (m, a, recordType, id) {
  if (confirm('この' + recordType + 'を削除しますか？')) {
    redirect(m, a, id);
  }
}

function openPictogramPallet (id) {
  window.open(
    '/AdminUtility/Pictogram?field=' + id,
    'pictogram',
    'width=240,height=300,scrollbars=yes'
  );
}

function putSmartTag (tag, field, name, params) {
  var tag = '[[' + tag;
  if (name) {
    tag += ':' + name.gsub(':', '\\:').gsub('[', '\\[').gsub(']', '\\]');
    if (params) {
      var encoded = [];
      for(var key in params) {
        if (params[key] != null) {
          encoded.push(key + '=' + encodeURIComponent(params[key]));
        }
      }
      if (0 < encoded.length) {
        tag += ':' + encoded.join(';');
      }
    }
  }
  tag += ']]';
  if (Prototype.Browser.IE) {
    field.focus();
    field.document.selection.createRange().text = tag;
  } else {
    var position = field.selectionStart;
    field.value = field.value.substr(0, position)
      + tag
      + field.value.substr(field.selectionEnd, field.value.length);
    field.selectionStart = position + tag.length;
    field.selectionEnd = field.selectionStart;
  }
}

function handleUploadProgress (element) {
  var progress = new JS_BRAMUS.jsProgressBar(element, 0);
  function updateProgress (request) {
    if (request.responseText) {
      var json = request.responseText.evalJSON();
      progress.setPercentage(json.current / json.total * 100);
    }
  }
  new PeriodicalExecuter(function () {
    new Ajax.Request('/UploadProgress', {
      method: 'get',
      parameters: 'd=' + new Date().getTime(),
      onComplete: updateProgress
    });
  }, 1);
}

// SafariのString.trim対応
if (!String.prototype.trim) {
  String.prototype.trim = function () {
    return this.replace(/^[ ]+|[ ]+$/g, '');
  }
}

// ゼロサプレス
if (!Number.prototype.suppressZero) {
  Number.prototype.suppressZero = function (n) {
    var str = '';
    var zerolen = n - ('' + this).length;
    for (var i = 0 ; i < zerolen ; i ++) {
      str += '0';
    }
    str += this;
    return str;
  }
}

document.observe('dom:loaded', function () {
  try {
    AjaxZip3.JSONDATA = document.location.protocol
      + '//ajaxzip3.googlecode.com/svn/trunk/ajaxzip3/zipdata';
  } catch (e) {
  }
});
