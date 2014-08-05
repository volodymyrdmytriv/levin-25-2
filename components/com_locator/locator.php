<?php
/**
 * @package Locator Component
 * @copyright 2009 - Fatica Consulting L.L.C.
 * @license GPL - This is Open Source Software 
 * $Id: locator.php 1018 2012-08-13 22:19:42Z fatica $
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once(JPATH_BASE . DS . 'administrator' . DS . 'components' . DS . 'com_locator'.DS.'controller.php');
require_once(JPATH_BASE . DS . 'components' . DS . 'com_locator'.DS.'models' . DS. 'directory.php');

// Create the controller
$controller = new LocatorController();

$mmciLang =& JFactory::getLanguage();
$mmciLang->load("com_locator");
    

// Register Extra tasks
$controller->registerTask( 'new'  , 	'edit' );
$controller->registerTask( 'apply', 	'save' );
$controller->registerTask( 'apply_new', 'save' );

// Perform the Request task
$controller->execute(JRequest::getVar('task', null, 'default', 'cmd'));
$controller->redirect();
?>