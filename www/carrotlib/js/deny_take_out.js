/**
 * 画像お持ち帰り禁止
 *
 * @package org.carrot-framework
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: deny_take_out.js 1314 2009-07-09 16:16:48Z pooza $
 */

function denyTakeOut () {
  var doNothing = function () {return false;}
  var configureElement = function (element) {
    if (element.oncontextmenu == null) {
      element.oncontextmenu = doNothing;
      element.onselectstart = doNothing;
      element.onmousedown = doNothing;
    }
  }
  var elements = $$('.deny_take_out');
  for (var i = 0 ; i < elements.length ; i ++) {
    configureElement(elements[i]);
  }
}
