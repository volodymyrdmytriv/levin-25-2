<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @license see LICENSE.php
 */

defined('_JEXEC') or die('Restricted access');

class modIpCityLinksHelper
{
    function getList(&$params, $cat = false)
    {
        $db         = JFactory::getDbo();
        $limit      = (int) $params->get('limit', '');
        $order      = (int) $params->get('order_by', 0);
        $order      = ($order) ? 'count DESC' : 'p.city ASC';
        
        $user       = JFactory::getUser();
        $groups     = $user->getAuthorisedViewLevels(); 
        
        // Filter by start and end dates.
        $nullDate   = $db->Quote($db->getNullDate());
        $date       = JFactory::getDate();
        $nowDate    = $db->Quote($date->toSql());        
        
        $query = $db->getQuery(true);
        $query->select('count(p.id) as count, p.city')
                ->from('#__iproperty as p')
                ->where('p.state')
                ->where('(p.publish_up = '.$nullDate.' OR p.publish_up <= '.$nowDate.')')
                ->where('(p.publish_down = '.$nullDate.' OR p.publish_down >= '.$nowDate.')');
        if($cat){
            $query->join('', '#__iproperty_propmid as pm on pm.prop_id = p.id')
                ->join('', '#__iproperty_categories as c on c.id = pm.cat_id')
                ->where('pm.cat_id = '.(int)$cat)
                ->where('(c.publish_up = '.$nullDate.' OR c.publish_up <= '.$nowDate.')')
                ->where('(c.publish_down = '.$nullDate.' OR c.publish_down >= '.$nowDate.')');
        }
        if(is_array($groups) && !empty($groups)){
            $query->where('p.access IN ('.implode(",", $groups).')');
            if($cat) $query->where('c.access IN ('.implode(",", $groups).')');
        }
        $query->group('p.city')
                ->order($order); 

        $db->setQuery($query, 0, $limit);
        if ($results = $db->loadObjectList()) return $results;

        return false;
    }
}
