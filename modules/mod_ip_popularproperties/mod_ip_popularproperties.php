<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Iproperty
 * @copyright (C) 2013 the Thinkery
 * @license see LICENSE.php
 */

defined('_JEXEC') or die('Restricted access');

// Include the helper functions only once
require_once (dirname(__FILE__).DS.'helper.php');

// Initialize variables
$document           = JFactory::getDocument();
$list               = modIPPopularHelper::getList($params);
$show_desc          = $params->get('show_desc', 1);
$counter            = 0;
$settings           = ipropertyAdmin::config();
$thumb_width        = (int) $params->get('thumb_width', 200) . 'px';
$thumb_height       = (int) $params->get('thumb_height', 120) . 'px';
$moduleclass_sfx    = htmlspecialchars($params->get('moduleclass_sfx'));

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
require(JModuleHelper::getLayoutPath('mod_ip_popularproperties', $params->get('layout', 'default')));