<?php
/**
 * @version 2.0.2 2013-03-20
 * @package Joomla
 * @subpackage Iproperty
 * @copyright (C) 2013 the Thinkery
 * @license see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

JHtml::_('behavior.framework', true);

$images = modIPSlideshowHelper::getList($params);

if (count($images) > 0){
    $moduleclass_sfx    = htmlspecialchars($params->get('moduleclass_sfx'));
    modIPSlideshowHelper::loadScripts($params, $images);
}else if(count($images) == 0 && $params->get('hide_mod')){
    return false;
}
require(JModuleHelper::getLayoutPath('mod_ip_slideshow', $params->get('layout', 'default')));