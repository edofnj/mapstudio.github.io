<?php
/**
 * @package     OL maps Module for Joomla 3.x
 * @author	EdilWeb.eu
 *
 * @copyright   Copyright (C) 2018 Edilweb.eu
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
/* No direct access	*/
    defined('_JEXEC') or die;
   
/* Include the syndicate functions only once	*/
    require_once dirname(__FILE__) . '/helper.php';
    
/*	get the html string for output	*/
    $olMapOutput = ModOLmaps::$olmaps_output;
    
/*	output to browser	*/
    require JModuleHelper::getLayoutPath('mod_olmaps');    

