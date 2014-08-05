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

//check if a property is being viewed
if((JRequest::getVar('option') == 'com_iproperty') && (JRequest::getVar('view') == 'property') && (JRequest::getInt('id') != 0))
{
    $moduleclass_sfx    = htmlspecialchars($params->get('moduleclass_sfx'));
    $ul_class           = $params->get( 'ul_class','' );
    $li_class           = $params->get( 'li_class','' );
    
    $list               = modIPRelatedHelper::getList($params);
    if( !$list && $params->get('hide_mod', 1) ){
        return false;
    }else if( !$list ){
        $params->def('layout', 'default_nodata');
    }   
}else{
    return false;
}
require(JModuleHelper::getLayoutPath('mod_ip_relatedproperties', $params->get('layout', 'default')));