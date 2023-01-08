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

$htmlNOmarker = <<<HTM
<div id="olmaps_map" class="olmapsMap"></div>
<script src="{$this->service->urlJS}"></script>
<script>
var map = new ol.Map({layers: [new ol.layer.Tile({ source: new ol.source.OSM()})],target: 'olmaps_map',view: new ol.View({ center: ol.proj.fromLonLat([{$this->service->parms->longitude}, {$this->service->parms->latitude}]), zoom: {$this->service->parms->zoom}})});
</script>
HTM;

