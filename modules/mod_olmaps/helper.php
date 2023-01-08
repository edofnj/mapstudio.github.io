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

use Joomla\Registry\Registry;    
class ModOLmaps {
    static $olmaps_output = '';
    
    private $service;

    function __construct() {
        $this->service = new stdClass;        
        $result = $this->MakeParams();        
        if ($result === 2) {
            $this->OkDb();
        } else {
            self::$olmaps_output = JText::_('MOD_OLMAPS_ERR_MODULE_DB');
        }        
    }    
    
    private function OkDb() {
        /*	add a css file into template	*/
        $document = JFactory::getDocument();
        $document->addStyleSheet($this->service->urlCSS);
        

        $this->addStyleContainer();
        
        switch ($this->service->parms->marpopvalue) {
            case '1':
                $tobrowser = $this->MarPop1();
                break;
            case '2':
                $tobrowser = $this->Marpop2();
                break;
            case '3':
                $tobrowser = $this->Marpop3();
                break;
            case '4':
                $tobrowser = $this->Marpop4();
                break;
            case '5':
                $tobrowser = $this->Marpop5();
                break;
            default:
                $tobrowser = JText::_('MOD_OLMAPS_ERR_MARPOP');
                break;
        }
        self::$olmaps_output = $tobrowser;
    }

    private function MarPop1() {
        include  $this->service->marpo1;
        return $htmlNOmarker;
    }
    
    private function Marpop2() {
        include $this->service->marpo2;
        return $html;
    }
    
    private function Marpop3() {
        $this->addStylePopup();        
        $toBrowser = $this->HTMLpopup();
        
        include $this->service->marpo3;        
        $toBrowser .= $js;
        
        return $toBrowser;
    }    
    
    private function Marpop4() {
        $this->addStylePopup();        
        $toBrowser = $this->HTMLpopup();
        
        include $this->service->marpo4;
        $toBrowser .= $js;
        
        return $toBrowser;
    }    
    
    private function Marpop5() {
        $this->addStylePopup();        
        $toBrowser = $this->HTMLpopup();
        
        include $this->service->marpo5;        
        $toBrowser .= $js;
        
        return $toBrowser;        
    }    
    
    private function addStyleContainer() {
        $document = JFactory::getDocument();
        
        ($this->service->parms->maxwd != '') ?  ($wdt = 'max-width:' . $this->service->parms->maxwd . ';') : $wdt = '' ;
        
        $containerStyle = <<<CTS
.olmapsMap{height:{$this->service->parms->nheight}; {$wdt}}
CTS;
        
        $document->addStyleDeclaration($containerStyle);
    }

    private function addStylePopup() {
        $document = JFactory::getDocument();
        include $this->service->popupCSS;        
        $document->addStyleDeclaration($css);
    }    
    
    private function HTMLpopup() {
        $html = <<<HEO
<div id="ol_map" class="olmapsMap"></div>
<div id="popup" class="ol-popup">
    <a href="#" id="popup-closer" class="ol-popup-closer"></a>
    <div class="ol-popup-direc">
    <a id="popup_href_directions" target="_blank"><img alt="Directions Icon" src="{$this->service->urlDirectionsIcon}" title="Directions"></a>
    </div>
    <div id="popup_content" class="ol-popup-content"></div>
</div>
HEO;
        return $html;
    }
    
    private function MakeParams() {
        new MOLparms_olmaps('mod_olmaps');
        
        $comPath = '/modules/mod_olmaps/tmpl';
        $bwPath = JURI::base(true) . $comPath;
        $svPath = JPATH_BASE . $comPath;
        
        $this->service->urlCSS              = $bwPath . '/css/ol.css';
        $this->service->urlJS               = $bwPath . '/htmlJs/ol.js';
        $this->service->urlMarker           = $bwPath . '/images/marker-green.png';
        $this->service->urlDirectionsIcon   = $bwPath . '/images/Directions_image1.png';
        $this->service->marpo1              = $svPath . '/htmlJs/marpop1.php';
        $this->service->marpo2              = $svPath . '/htmlJs/marpop2.php';
        $this->service->marpo3              = $svPath . '/htmlJs/marpop3.php';
        $this->service->marpo4              = $svPath . '/htmlJs/marpop4.php';
        $this->service->marpo5              = $svPath . '/htmlJs/marpop5.php';
        $this->service->popupCSS            = $svPath . '/css/popup_css.php';
        $this->service->urlDirections       = 'https://www.openstreetmap.org/directions?from=';
        
        if (MOLparms_olmaps::$backInitialized === false){
            self::$olmaps_output = JText::_('MOD_OLMAPS_ERR_ACTIVE');            
            return 1;
        }
        
        $this->service->parms = MOLparms_olmaps::$backParmsMod;

        $this->service->parms->longitude = floatval($this->service->parms->longitude);
        $this->service->parms->latitude  = floatval($this->service->parms->latitude);
        
        if (isset($this->service->parms->popuptext)){
            $this->service->parms->popuptext = str_replace("\r\n", "<br>", $this->service->parms->popuptext);
            $this->service->parms->popuptext = str_replace(["\n", "\t", "\r"], "&nbsp", $this->service->parms->popuptext);
            $this->service->parms->popuptext = str_replace("'", "&#39;", $this->service->parms->popuptext);
        }

        return 2;
    }
}

class MOLparms_olmaps extends Joomla\Registry\Registry{
    static $backParmsMod    = '';
    static $backInitialized = '';
    
     function __construct($mod) {
        $module = JModuleHelper::getModule($mod);
        $params = new Registry($module->params);
        
        self::$backParmsMod    = $params->data;
        self::$backInitialized = $params->initialized;
    }
}
new ModOLmaps();