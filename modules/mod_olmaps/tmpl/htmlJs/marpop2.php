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

$html = <<<HTM
<div id="olmaps_map" class="olmapsMap"></div>
<script src="{$this->service->urlJS}"></script>
<script>
var city = new ol.Feature({geometry: new ol.geom.Point(ol.proj.fromLonLat([{$this->service->parms->longitude}, {$this->service->parms->latitude}]))}); city.setStyle(new ol.style.Style({image: new ol.style.Icon(({src: '{$this->service->urlMarker}', anchor: [0.5, 1]}))}));
var vectorSource = new ol.source.Vector({features: [city]});
var vectorLayer = new ol.layer.Vector({source: vectorSource});       
var map = new ol.Map({layers: [new ol.layer.Tile({source: new ol.source.OSM()}),vectorLayer],target: 'olmaps_map', view: new ol.View({center: ol.proj.fromLonLat([{$this->service->parms->longitude}, {$this->service->parms->latitude}]), zoom: {$this->service->parms->zoom}})});
</script>
HTM;
