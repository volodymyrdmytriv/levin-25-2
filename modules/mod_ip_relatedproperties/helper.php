<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Iproperty
 * @copyright (C) 2013 the Thinkery
 * @license see LICENSE.php
 */

defined('_JEXEC') or die('Restricted access');
require_once(JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'helpers'.DS.'html.helper.php');
require_once(JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'helpers'.DS.'property.php');
require_once(JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'helpers'.DS.'route.php');
require_once(JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'helpers'.DS.'query.php');
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_iproperty'.DS.'classes'.DS.'admin.class.php');

class modIPRelatedHelper
{
    function getPropertiesList( $where, $limitstart=0, $limit=9999, $sort = 'p.title', $order = 'ASC' )
	{
		$db = JFactory::getDBO();
        $property = new ipropertyHelperproperty($db);
        $property->setType('properties');
        $property->setWhere( $where );
        $property->setOrderBy( $sort, $order );
        $properties = $property->getProperty($limitstart,$limit);
        return $properties;
	}

    function getList(&$params)
	{
		$prop_id                = JRequest::getInt('id');
        $count                  = (int) $params->get('count', 5);
		$titlelength            = (int) $params->get('titlelength', 50);
        $search_cat             = (int) $params->get('search_cat', 1);
        $search_city            = (int) $params->get('search_city', 1);
        $search_state           = (int) $params->get('search_state', 1);
        $search_province        = (int) $params->get('search_province', 1);
        $search_county          = (int) $params->get('search_county', 1); //1.5.5
        $search_region          = (int) $params->get('search_region', 1); //1.5.5
        $search_country         = (int) $params->get('search_country', 1);        

        //get current property data
        $db = JFactory::getDBO();
        $property = new ipropertyHelperproperty($db);
        $property->setType('property');
        $property->setWhere( array('p.id = '.$prop_id ));
        $property->setOrderBy( 'p.id', 'ASC' );
        $properties = $property->getProperty(0,1);
        $p = $properties[0];
        $available_cats = ipropertyHTML::getAvailableCats($p->id);
        $cats = implode(',', $available_cats);

        //set where statement for query
        $where = array();
        $searchwhere = array();
        $where[] = 'p.id != '.(int)$p->id;
        if($cats && $search_cat) $searchwhere[] = 'pm.cat_id IN ('.$cats.')';
        if($p->city && $search_city) $searchwhere[] = 'p.city = '.$db->Quote($p->city);
        if($p->locstate && $search_state) $searchwhere[] = 'p.locstate = '.(int)$p->locstate;
        if($p->province && $search_province) $searchwhere[] = 'p.province = '.$db->Quote($p->province);
        if($p->county && $search_county) $searchwhere[] = 'p.county = '.$db->Quote($p->county); //1.5.5
        if($p->region && $search_region) $searchwhere[] = 'p.region = '.(int)$p->region; //1.5.5
        if( count($searchwhere)) $where[] = "(".implode( ' OR ', $searchwhere ).")";

        $where 		= ( count( $where ) ? implode( ' AND ', $where ) : '' );
        $rows = modIPRelatedHelper::getPropertiesList($where, 0, $count, 'RAND()', '');

        $i		= 0;
        $lists	= array();
        if( $rows ){
            foreach ( $rows as $row )
            {
                $available_cats = ipropertyHTML::getAvailableCats($row->id);
                $first_cat      = $available_cats[0];

                $lists[$i]->link            = JRoute::_(ipropertyHelperRoute::getPropertyRoute($row->id.':'.$row->prop_alias, $first_cat, true));
                $lists[$i]->street_address  = ipropertyHTML::snippet(htmlspecialchars( $row->street_address ), $titlelength, '...');
                $i++;
            }
        }

		return $lists;
	}
}