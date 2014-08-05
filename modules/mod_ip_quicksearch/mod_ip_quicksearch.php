<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Iproperty
 * @copyright (C) 2013 the Thinkery
 * @license see LICENSE.php
 */

defined('_JEXEC') or die('Restricted access');

$document           = JFactory::getDocument();

require_once('components'.DS.'com_iproperty'.DS.'helpers'.DS.'html.helper.php');
require_once('components'.DS.'com_iproperty'.DS.'helpers'.DS.'query.php');
require_once('components'.DS.'com_iproperty'.DS.'helpers'.DS.'route.php');
require_once('administrator'.DS.'components'.DS.'com_iproperty'.DS.'classes'.DS.'admin.class.php');

require_once('components'.DS.'com_iproperty'.DS.'models'.DS.'foundproperties.php');
require_once('administrator'.DS.'components'.DS.'com_iproperty'.DS.'models'.DS.'company.php');

$model = new IpropertyModelFoundProperties();

$types = $model->getTypes();
$states = $model->getAllStates();
$cities = $model->getAllCities();

$companies_folder = JURI::root(true).'/media/com_iproperty/companies/';

// levin management
$company_model = new IpropertyModelCompany();
$portfolio_avail_report = $company_model->getFilesByTitle(IpropertyModelCompany::$LEVIN_MANAGEMENT_ID, 'portfolio_avail_report');


// 	check if jQuery is loaded before adding it
if (!JFactory::getApplication()->get('jquery')) {
  	JFactory::getApplication()->set('jquery', true);
	//$document->addScript( "https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js" );
	$document->addScript( "http://code.jquery.com/jquery-1.9.1.min.js" );
}

$js_script =  'var j_token = "'.JUtility::getToken().'"; ';
$js_script .= 'var jurl_base = "'.JURI::base('true').'"; ';

$document->addScriptDeclaration($js_script);
$document->addScript( JURI::root(true).'/components/com_iproperty/assets/js/ipQuickSearch.js' );

require (JModuleHelper::getLayoutPath('mod_ip_quicksearch', 'default'));