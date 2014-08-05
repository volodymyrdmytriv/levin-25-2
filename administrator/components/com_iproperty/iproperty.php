<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_iproperty')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

require_once (JPATH_COMPONENT.DS.'controller.php');
require_once (JPATH_COMPONENT.DS.'classes'.DS.'admin.class.php');
require_once (JPATH_COMPONENT.DS.'classes'.DS.'icon.class.php');
require_once (JPATH_COMPONENT.DS.'helpers'.DS.'iproperty.php');
require_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'html.helper.php');
require_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'query.php');
require_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'auth.php');

// load language file for iportal
$language = JFactory::getLanguage();
$language->load('iportal');

// load language file for ipreserve
$language = JFactory::getLanguage();
$language->load('ipreserve');

// Check for IPortal helpers
if(file_exists(JPATH_COMPONENT_SITE.DS.'helpers'.DS.'manage.php')) require_once (JPATH_COMPONENT_SITE .DS.'helpers'.DS.'manage.php');
if(file_exists(JPATH_COMPONENT_SITE.DS.'helpers'.DS.'portal.php')) require_once (JPATH_COMPONENT_SITE .DS.'helpers'.DS.'portal.php');

// Check for IPreserve helper
if(file_exists(JPATH_COMPONENT_SITE .DS.'helpers'.DS.'ipreserve.php')) require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'ipreserve.php';

// Include dependancies
jimport('joomla.application.component.controller');

// Execute the task.
$controller	= JController::getInstance('Iproperty');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();