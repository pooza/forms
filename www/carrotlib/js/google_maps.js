/**
 * Google Maps処理
 *
 * テンプレートでの記述例:
 * <div id="map" style="width:400px; height:400px">Loading...</div> 
 * <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
 * <script src="/carrotlib/js/google_maps.js" type="text/javascript"></script>
 * <script type="text/javascript">
 * Event.observe(window, 'load', function () {ldelim}
 *   handleGoogleMaps($('map'), {$geocode.lat|default:0}, {$geocode.lng|default:0});
 * {rdelim});
 * </script>
 *
 * @package org.carrot-framework
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: google_maps.js 1961 2010-04-04 06:43:27Z pooza $
 */
function handleGoogleMaps (container, lat, lng) {
  var point = new google.maps.LatLng(lat, lng);
  var map = new google.maps.Map(container, {
    zoom: 17,
    center: point,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  var marker = new google.maps.Marker({
    position: point,
    map: map
  });
}
