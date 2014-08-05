<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Iproperty
 * @copyright (C) 2013 the Thinkery
 * @license see LICENSE.php
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Include IP router once
require_once( JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'helpers'.DS.'route.php' );

// Include helper functions only once
require_once( dirname(__FILE__).DS.'helper.php' );
require( JModuleHelper::getLayoutPath( 'mod_ip_catmenu', $params->get('layout', 'default') ) );
?>