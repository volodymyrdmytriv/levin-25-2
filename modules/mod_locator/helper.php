<?php
/**
* @version		$Id: helper.php 10857 2008-08-30 06:41:16Z willebil $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details tc.
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

if(!class_exists('LocatorController')){
	require_once ('components'.DS.'com_locator'.DS.'controller.php');
}

class modLocatorHelper {
	
	var $lists;
	
	function getLists(){
		return $this->lists;	
	}
	
	function getTagModel()
	{
		if (!class_exists( 'LocatorModelTags' ))
		{
			// Build the path to the model based upon a supplied base path
			$path = JPATH_SITE.DS.'components'.DS.'com_locator'.DS.'models'.DS.'tags.php';
			$false = false;

			// If the model file exists include it and try to instantiate the object
			if (file_exists( $path )) {
				require_once( $path );
				if (!class_exists( 'LocatorModelTags' )) {
					JError::raiseWarning( 0, 'Model class LocatorModelTags not found in file.' );
					return $false;
				}
			} else {
				JError::raiseWarning( 0, 'Model LocatorModelTags not supported. File not found.' );
				return $false;
			}
		}

		$model = new LocatorModelTags();
		return $model;
	}
	
	function getDirectoryModel()
	{
		if (!class_exists( 'LocatorModelDirectory' ))
		{
			// Build the path to the model based upon a supplied base path
			$path = JPATH_SITE.DS.'components'.DS.'com_locator'.DS.'models'.DS.'directory.php';
			$false = false;

			// If the model file exists include it and try to instantiate the object
			if (file_exists( $path )) {
				require_once( $path );
				if (!class_exists( 'LocatorModelDirectory' )) {
					JError::raiseWarning( 0, 'Model class LocatorModelDirectory not found in file.' );
					return $false;
				}
			} else {
				JError::raiseWarning( 0, 'Model LocatorModelDirectory not supported. File not found.' );
				return $false;
			}
		}

		$model = new LocatorModelDirectory();
		return $model;
	}

	function getList(&$params){
		
		// Get some data from the model
		
		$model = modLocatorHelper::getDirectoryModel();
				
		$model->setModuleParams($params);
		
		$this->items = $model->getData();	

		
		$model->getJSUserLocation($res);
		
		if(isset($res->lat)){
			
			if(abs($res->lat) > 0){
			
				$params->set('gmap_default_lat',@$res->lat);
				$params->set('gmap_default_lng',@$res->lng);
				$params->set('gmap_default_zoom',@$res->zoom);
					
			}
		}

		$itemid = (int) $params->get('showresultson', 0);
		$link = '';
		
		if($itemid == 0){
			echo "<i>Module not configured.  See 'Show Results on' setting.</i>";
		}

		$db =& JFactory::getDBO();
		
		$sql = 'SELECT `link` FROM #__menu WHERE id=' . (int)$itemid . ' LIMIT 1';
		
		$db->setQuery($sql);
		
		$link = $db->loadResult();
		
		$link .= '&Itemid=' . $itemid;
		
		$link = htmlentities($link);
	
		$this->lists['link']  = $link;		
		
		if($params->get('showlegend',0) == 1){
		
			$tagids = $params->get('tags');
			
			$tag_where = "";
			
			if(!is_array($tagids)){
				if($tagids > 0){
					$tag_where = "WHERE id= " . (int)$tagids;
				}
			}else{
				$tag_where = "WHERE id in (" . implode(",",$tagids) . ")"; 
			}
	
			$order_clause = " ORDER BY `order` DESC";
		
			//TODO: Move to model
			$db =& JFactory::getDBO();
			$sql = 'SELECT `id`,`name`,`order`,`marker`,`description` FROM #__location_tags ' . $tag_where . $order_clause;
			$db->setQuery($sql);
			
			$this->lists['legend'] = $db->loadObjectList();			
				
		}
		
		if($params->get('showtagdropdown') == 1){
			
			$model		= modLocatorHelper::getTagModel();	
			
			$model->getTagList();
			
			$this->lists['tags'] = @$model->_lists['tags'];
		}
			
		if($params->get('showstatedropdown') == 1){
			
			if($params->get('showcitydropdown',0) == 1){

				$model = modLocatorHelper::getDirectoryModel();
	
				$model->showCityList(true);
				
				$doc =& JFactory::getDocument();

			}
			
			$model = new LocatorModelDirectory; 
			$model->getProvinceList(true);
			
			$this->lists['states'] = $model->_lists['states'];
		
		}
		
		if($params->get('showcitydropdown',0) == 1){
			
			$model = modLocatorHelper::getDirectoryModel();
			$model->getCityList(true);
			$this->lists['city'] = $model->_lists['city'];
			
		
		}
		
		if($params->get('showcountrydropdown') == 1){
			
			if($params->get('showcitydropdown',0) == 1){
				
				$model = modLocatorHelper::getDirectoryModel();
	
				$model->showCityListByCountry(true);
				
				$doc =& JFactory::getDocument();
				
			}
				
			$model	= modLocatorHelper::getDirectoryModel();
			
			$model->getCountryList(true);
			
			$this->lists['country'] = $model->_lists['country'];
		}
	}
}