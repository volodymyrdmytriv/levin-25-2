<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Iproperty
 * @copyright (C) 2013 the Thinkery
 * @license see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class modMlsSearchHelper
{
	function searchMLS($listing_id)
    {
        require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_iproperty'.DS.'classes'.DS.'admin.class.php');
        require_once(JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'helpers'.DS.'property.php');
        require_once(JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'helpers'.DS.'query.php');

		$db = JFactory::getDBO();

        $where      = array();
        $where[]    = 'p.mls_id = '.$db->Quote($listing_id);
        $property = new ipropertyHelperproperty($db);
        $property->setType('property');
        $property->setWhere( $where );
        $property = $property->getProperty();

        if($result = $property[0]->id.':'.$property[0]->prop_alias){
            return $result;
        }else{
            return false;
        }
	}
}