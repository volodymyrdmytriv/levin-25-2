<?php
/**
* @version		$Id: mod_latestnews.php 10381 2008-06-01 03:35:53Z pasamio $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined('_JEXEC') or die('Restricted access');


if(!defined('LOCATOR_MODULE')){
	define('LOCATOR_MODULE',1);
}
// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$doc =& JFactory::getDocument();

$doc->addStyleSheet('components/com_locator/assets/locator.css');

$lang =& JFactory::getLanguage();

$lang->load( 'com_locator', JPATH_SITE );	

$module_params = $params;

if(!defined('LOCATOR_LAYOUT')){
		
	define('LOCATOR_LAYOUT',1);
	
	class layoutContainer{
		
		public $items;
		
		public $lists;
		
		function getItems(){
			return $this->items;	
		}	
		
		function getLists(){
			return $this->lists;	
		}
		
		function showModule($module_params){
			
			$params = $module_params;
			
			$helper = new modLocatorHelper();
			
			$helper->getList($module_params);
	
			$this->items = $helper->items;
			
			$this->lists = $helper->getLists();
			
			
			require(JModuleHelper::getLayoutPath('mod_locator'));
		}
		
	}
}

$c = new layoutContainer();

$c->showModule($module_params);

?>