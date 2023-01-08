<?php
/**
 * @package     OL maps Module for Joomla 3.x  and Joomla 4 beta
 * @author	EdilWeb.eu
 *
 * @copyright   Copyright (C) 2018 Edilweb.eu
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

/* No direct access	*/
defined('_JEXEC') or die;

$js = <<<HEO
<script src="{$this->service->urlJS}"></script>
<script>
var markerLon = {$this->service->parms->longitude}, markerLat = {$this->service->parms->latitude}, myZoom = {$this->service->parms->zoom};
var centerLon = markerLon, centerLat = markerLat;
var container = document.getElementById('popup');
var closer = document.getElementById('popup-closer');
var Lat2Direc, Lon2Direc;
(Number.isInteger(markerLat)) ? Lat2Direc = markerLat.toString()+'.00' : Lat2Direc = markerLat.toString();
(Number.isInteger(markerLon)) ? Lon2Direc = markerLon.toString()+'.00' : Lon2Direc = markerLon.toString();        
popup_href_directions.href = '{$this->service->urlDirections}' + Lat2Direc + ',' + Lon2Direc;
var overlay = new ol.Overlay({ element: container, autoPan: true, position: ol.proj.fromLonLat([markerLon, markerLat]), autoPanAnimation: { duration: 250}});
closer.onclick = function () {overlay.setPosition(undefined);closer.blur();return false;};
var city = new ol.Feature({geometry: new ol.geom.Point(ol.proj.fromLonLat([markerLon, markerLat]))});
city.setStyle(new ol.style.Style({image: new ol.style.Icon(({src: '{$this->service->urlMarker}',anchor: [0.5, 1]}))}));
var vectorSource = new ol.source.Vector({features: [city]});
var vectorLayer = new ol.layer.Vector({source: vectorSource});
var map = new ol.Map({layers: [new ol.layer.Tile({source: new ol.source.OSM()}),vectorLayer],overlays: [overlay],target: 'ol_map',view: new ol.View({center: ol.proj.fromLonLat([centerLon,centerLat]),zoom: myZoom})});
map.on('singleclick', function () {overlay.setPosition(ol.proj.fromLonLat([markerLon, markerLat]));});
popup_content.innerHTML = '{$this->service->parms->popuptext}';
</script>
HEO;
