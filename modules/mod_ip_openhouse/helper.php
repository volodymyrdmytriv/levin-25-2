<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Iproperty
 * @copyright (C) 2013 the Thinkery
 * @license see LICENSE.php
 */

defined('_JEXEC') or die('Restricted access');
require_once(JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'helpers'.DS.'route.php');
require_once(JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'helpers'.DS.'html.helper.php');
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_iproperty'.DS.'classes'.DS.'admin.class.php');

jimport('joomla.utilities.date');

class modIPOpenhouseHelper
{
    function getList(&$params)
	{
		$db         = JFactory::getDBO();
        $count 		= $params->get('count', 10);
        
        // Filter by start and end dates.
        $nullDate   = $db->Quote($db->getNullDate());
        $date       = JFactory::getDate();
        $nowDate    = $db->Quote($date->toSql());
        
        $query = $db->getQuery(true);
        $query->select('o.*, o.prop_id as prop_id, p.alias as alias')
                ->from('#__iproperty_openhouses as o')
                ->leftJoin('#__iproperty as p on p.id = o.prop_id')
                ->where('o.state = 1 AND p.state = 1 AND p.approved = 1')
                ->where('(p.publish_up = '.$nullDate.' OR p.publish_up <= '.$nowDate.')')
                ->where('(p.publish_down = '.$nullDate.' OR p.publish_down >= '.$nowDate.')')
                ->where('o.openhouse_end >= '.$nowDate)
                ->order('o.openhouse_start ASC');
        
        $db->setQuery($query, 0, $count);
        $rows = $db->loadObjectList();

        $i		= 0;
        $lists	= array();
        if( $rows ){
            foreach ( $rows as $row )
            {
                $available_cats = ipropertyHTML::getAvailableCats($row->prop_id);
                $first_cat      = $available_cats[0];

                $lists[$i]->name            = $row->name;
                $lists[$i]->link            = JRoute::_(ipropertyHelperRoute::getPropertyRoute($row->prop_id.':'.$row->alias, $first_cat, true));
                $lists[$i]->street_address  = htmlspecialchars( ipropertyHTML::getPropertyTitle($row->prop_id) );
                $lists[$i]->start           = JFactory::getDate($row->openhouse_start)->format($params->get('date_format', 'l, d F Y g:ia'));
                $lists[$i]->end             = JFactory::getDate($row->openhouse_end)->format($params->get('date_format', 'l, d F Y g:ia'));
                $i++;
            }
        }
        
        return $lists;
	}
}