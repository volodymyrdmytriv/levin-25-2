<?php 
/**
 * $ModDesc
 * 
 * @version		$Id: helper.php $Revision
 * @package		modules
 * @subpackage	mod_lofslidenews
 * @copyright	Copyright (C) OCTOBER 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>. All rights reserved.
 * @website 	htt://landofcoder.com
 * @license		GNU General Public License version 2
 */
// no direct access
defined('_JEXEC') or die;
require_once JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php';
if( !defined('PhpThumbFactoryLoaded') ) {
	require_once dirname(__FILE__).DS.'libs'.DS.'phpthumb'.DS.'ThumbLib.inc.php';
	define('PhpThumbFactoryLoaded',1);
}
if( !class_exists("LofDataSourceBase") ){
	require_once dirname(__FILE__).DS."libs".DS."source".DS."source_base.php";
}

abstract class modK2ScrollerHelper {
	
	static $COOKIE_NAME='LOFK2S2';
	/**
	 * get list articles
	 */
	public static function getList( $params, $moduleName ){
		return self::getListBySourceName( $params, $moduleName );
	}
	
	/**
   	 * Processing action, getting data following to each function selected
     */
	public static function processFunction( $params, $moduleName ){
	 	return self::getList( $params, $moduleName ); 
	}
	
	/**
  	 * Get list of articles follow conditions user selected
     * 
     * @param JParameter $params
     * @return array containing list of article
     */ 
	public static function getListBySourceName( &$params, $moduleName ) {
	 	// create thumbnail folder 	

	 	$tmppath = JPATH_SITE.DS.'cache';//.'lofthumbs';
		$moduleName = 'lofthumbs' ;
	 	$thumbPath = $tmppath.DS. $moduleName.DS;
		if( !file_exists($tmppath) ) {
			JFolder::create( $tmppath, 0777 );
		}; 
		if( !file_exists($thumbPath) ) {
			JFolder::create( $thumbPath, 0777 );
		}; 
		// get call object to process getting source
		$source =  $params->get( 'data_source', 'content' );
		$path = dirname(__FILE__).DS."libs".DS."source".DS.$source.DS."source.php";
	
		if( !file_exists($path) ){
			return array();	
		}
		require_once $path;
		$objectName = "Lof".ucfirst($source)."DataSource";
	
	 	$object = new $objectName();
	 	$items= $object->setThumbPathInfo($thumbPath, JURI::base()."cache/".$moduleName."/" )
			->setImagesRendered( array( 'thumbnail' => array( (int)$params->get( 'thumbnail_width', 960 ), (int)$params->get( 'thumbnail_height', 320 )))																						
																															)
			->getList( $params );
  		return $items;
	}
 
       
	/**
	 * load css - javascript file.
	 * 
	 * @param JParameter $params;
	 * @param JModule $module
	 * @return void.
	 */
	public static function loadMediaFiles( $params, $module, $theme='basic' ){
		
		$mainframe = JFactory::getApplication();
		$template = self::getTemplate();
	 	$document = JFactory::getDocument();	
		// load style of theme follow the setting
 		$document->addStyleSheet( JURI::base().'modules/'.$module->module.'/assets/layout.css' );	
		$tPath = JPATH_BASE.DS.'templates'.DS.$template.DS.'css'.DS.$module->module.'_'.$theme.'.css';
		if( file_exists($tPath) ){
			$document->addStyleSheet( JURI::base().'/templates/'.$template.'/css/'.$module->module.'_'.$theme.'.css');
		} else { 
			$document->addStyleSheet( JURI::base().'modules/'.$module->module.'/assets/theme/'.$theme.'/theme.css' );	
		}
	 	
		if( $params->get("enable_jquery",1)  ){
			if( !defined("LOF_LOADJQUERY") ){
				$document->addScript( JURI::base(). 'modules/'.$module->module.'/assets/'.'jquery-1.6.4.min.js' );
				define ("LOF_LOADJQUERY",1);
			}
		}
		$document->addScript(  JURI::base().'modules/'.$module->module.'/assets/jscript.min.js');
  	
	}
	
	/**
	 * get name of current template
	 */
	public static function getTemplate(){
		$mainframe = JFactory::getApplication();
		return $mainframe->getTemplate();
	}
	
	/**
	 * Get Layout of the item, if found the overriding layout in the current template, the module will use this file
	 * 
	 * @param string $moduleName is the module's name;
	 * @params string $theme is name of theme choosed
	 * @params string $itemLayoutName is name of item layout.
	 * @return string is full path of the layout
	 */
	public static function getItemLayoutPath($moduleName, $theme ='', $itemLayoutName='_item' ){

		$layout = trim($theme)?trim($theme).DS.'_item'.DS.$itemLayoutName:'_item'.DS.$itemLayoutName;	
		$path = JModuleHelper::getLayoutPath($moduleName, $layout);	
		if( trim($theme) && !file_exists($path) ){
			// if could not found any item layout in the theme folder, so the module will use the default layout.
			return JModuleHelper::getLayoutPath( $moduleName, '_item'.DS.$itemLayoutName );
		}
		return $path;
	}
}
?>