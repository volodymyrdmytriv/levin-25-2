<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'classes'.DS.'admin.class.php');
require_once(JPATH_COMPONENT.DS.'helpers'.DS.'agent.php');
require_once(JPATH_COMPONENT.DS.'helpers'.DS.'auth.php');
require_once(JPATH_COMPONENT.DS.'helpers'.DS.'html.helper.php');
require_once(JPATH_COMPONENT.DS.'helpers'.DS.'property.php');
require_once(JPATH_COMPONENT.DS.'helpers'.DS.'query.php');
require_once(JPATH_COMPONENT.DS.'helpers'.DS.'route.php');

/* PORTAL SPECIFIC */
if(file_exists(JPATH_COMPONENT.DS.'helpers'.DS.'manage.php')){
    require_once(JPATH_COMPONENT.DS.'helpers'.DS.'manage.php');
}
if(file_exists(JPATH_COMPONENT.DS.'helpers'.DS.'portal.php')){
    require_once(JPATH_COMPONENT.DS.'helpers'.DS.'portal.php');
}

// load language file for iportal
$language = JFactory::getLanguage();
$language->load('iportal');
// load language file for ipreserve
$language = JFactory::getLanguage();
$language->load('ipreserve');

$controller = JController::getInstance('Iproperty');

$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
?>