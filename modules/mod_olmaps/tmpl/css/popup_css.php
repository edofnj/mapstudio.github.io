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

$css = <<<'HEO'
.ol-popup {position: absolute;background-color: white; -webkit-filter: drop-shadow(0 1px 4px rgba(0,0,0,0.2)); filter: drop-shadow(0 1px 4px rgba(0,0,0,0.2)); padding: 15px; border-radius: 7px; border: 1px solid #cccccc; bottom: 12px; left: -50px; min-width: 250px; max-width: 280px;}
.ol-popup:after, .ol-popup:before { top: 100%; border: solid transparent; content: " "; height: 0; width: 0; position: absolute; pointer-events: none;}
.ol-popup:after { border-top-color: white; border-width: 10px; left: 48px; margin-left: -10px;}
.ol-popup:before { border-top-color: #cccccc; border-width: 11px; left: 48px; margin-left: -11px;}
.ol-popup-closer {text-decoration: none; position: absolute; top: 2px; right: 8px;}
.ol-popup-closer:after { content: "\2716"; color: red;}
.ol-popup-closer:hover::after{background-color: red; border-radius: 3px; color: black; box-shadow:0px 2px 2px 0px RGBA(168,163,168,1); text-shadow:#ffeb3b 1px 1px 1px;}
.ol-popup-content{border-left: 1px solid #c3b8b8; float:left;font-family: verdana, calibri, arial, times new roman; font-size: 12px; font-style: italic; line-height: 150%; margin-left: 2px; padding-left: 2px; min-width: 188px; max-width: 218px;}
.ol-popup-direc{ background: #078e1e; float:left; width: 20px; padding: 3px 3px 3px 3px;}            
HEO;
