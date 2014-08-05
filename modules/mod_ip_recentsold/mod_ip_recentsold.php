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
   
// Initialize variables
$document           = JFactory::getDocument();
$show_desc          = $params->get('show_desc', 1);
$counter            = 0;
$settings           = ipropertyAdmin::config();
$thumb_width        = (int) $params->get('thumb_width', 200) . 'px';
$thumb_height       = (int) $params->get('thumb_height', 120) . 'px';
$moduleclass_sfx    = htmlspecialchars($params->get('moduleclass_sfx'));
$list               = false;

$list = modIPRecentsoldHelper::getList($params);

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
require(JModuleHelper::getLayoutPath('mod_ip_recentsold', $params->get('layout', 'default')));