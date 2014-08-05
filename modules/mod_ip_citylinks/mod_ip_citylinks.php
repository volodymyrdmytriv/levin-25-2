<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @license see LICENSE.php
 */

//no direct access
defined('_JEXEC') or die('Restricted Access');

// Include the syndicate functions only once
require_once(dirname(__FILE__).DS.'helper.php');
require_once(JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'helpers'.DS.'route.php');

$cat                = (int) $params->get('cat_id', 0);
$count              = (int) $params->get('show_count', 0);
$pretext            = $params->get('pretext', '');
$posttext           = $params->get('posttext', '');
$moduleclass_sfx    = htmlspecialchars($params->get('moduleclass_sfx'));

$list = modIpCityLinksHelper::getList($params, $cat);

if( !$list && $params->get('hide_mod') ){ // hide module if possible with template
    return false;
}else if( !$list ){ // display no data message
    $params->def('layout', 'default_nodata');
}
require(JModuleHelper::getLayoutPath('mod_ip_citylinks', $params->get('layout', 'default')));