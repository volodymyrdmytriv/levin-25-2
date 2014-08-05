<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Iproperty
 * @copyright (C) 2013 the Thinkery
 * @license see LICENSE.php
 */
 
defined('_JEXEC') or die('Restricted access');

require_once(dirname(__FILE__).DS.'helper.php');

if(!$params->get('zillow_id') && $params->get('hide_mod')){
    return false;
}else if(!$params->get('zillow_id')){
    $params->def('layout', 'default_nodata');
}else{
    $Mrates = modIPMratesHelper::MRatesCall($params);
    if(is_null($Mrates)) $params->def('layout', 'default_nodata');
}
require(JModuleHelper::getLayoutPath('mod_ip_zillowmrates', $params->get('layout', 'default')));