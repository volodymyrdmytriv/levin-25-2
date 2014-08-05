<?php
/**
 * @version 2.0 2012-08-13
 * @package Joomla
 * @subpackage Iproperty
 * @copyright (C)  2012 The Thinkery
 * @license see LICENSE.php
 */

defined('_JEXEC') or die('Restricted access');

// Include the helper functions only once
require_once (dirname(__FILE__).DS.'helper.php');

// Get session
$session = JFactory::getSession();

// create recentviews array if it doesn't exist
if(!$recentviews = $session->get('rviews')){
    $recentviews = array();
}

// remove any duplicates in case they've viewed same prop multiple times
$recentviews = array_unique($recentviews);

// if we're on a property view, then add the viewed ID to the session array
if (JRequest::getVar('view') == 'property' && JRequest::getVar('option') == 'com_iproperty'){
    // get prop_id
    $prop_id = JRequest::getInt('id'); 
    // add prop_id to recentviews array
    $recentviews[] = $prop_id;
    // add recentviews back to session
    $session->set('rviews', $recentviews);
}
    
// Initialize variables
$document           = JFactory::getDocument();
$show_desc          = $params->get('show_desc', 1);
$counter            = 0;
$settings           = ipropertyAdmin::config();
$thumb_width        = (int) $params->get('thumb_width', 200) . 'px';
$thumb_height       = (int) $params->get('thumb_height', 120) . 'px';
$moduleclass_sfx    = htmlspecialchars($params->get('moduleclass_sfx'));
$list               = false;

// get property list if we have values in session
if(count($recentviews)){
    $list = modIPRecentviewedHelper::getList($params, $recentviews);
} 

if( !$list && $params->get('hide_mod', 1) ){ // hide module if possible with template
    return false;
}else if( !$list ){ // display no data message
    $params->def('layout', 'default_nodata');
}else{
    // include iproperty css if set in parameters
    if($params->get('include_ipcss', 1) && !defined('_IPMODCSS')){
        define('_IPMODCSS', true);
        ipropertyHTML::includeIpScripts();
    }
}
require(JModuleHelper::getLayoutPath('mod_ip_recentviewed', $params->get('layout', 'default')));