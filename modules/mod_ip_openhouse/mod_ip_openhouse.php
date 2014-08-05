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

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$list            = modIPOpenhouseHelper::getList($params);

if( !$list && $params->get('hide_mod') ){
    return false;
}else if( !$list ){
    $params->def('layout', 'default_nodata');
}
require(JModuleHelper::getLayoutPath('mod_ip_openhouse', $params->get('layout', 'default')));