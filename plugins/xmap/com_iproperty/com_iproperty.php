<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access.' );

require_once(JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'helpers'.DS.'html.helper.php');
require_once(JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'helpers'.DS.'route.php');
require_once(JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_iproperty'.DS.'classes'.DS.'admin.class.php');

class xmap_com_iproperty
{
	static function getTree( $xmap, $parent, &$params) 
    {
		$link_query = parse_url($parent->link);
        if (!isset($link_query['query'])) {
            return;
        }

        parse_str(html_entity_decode($link_query['query']), $link_vars);
        $view   = JArrayHelper::getValue($link_vars, 'view', '');
        $catid  = JArrayHelper::getValue($link_vars, 'id', 0);

        $include_props = JArrayHelper::getValue( $params, 'include_props', 1 );
        $include_props = ( $include_props == 1 || ( $include_props == 2 && $xmap->view == 'xml') || ( $include_props == 3 && $xmap->view == 'html'));
        $params['include_props'] = $include_props;

        $priority = JArrayHelper::getValue($params,'cat_priority',$parent->priority,'');
        $changefreq = JArrayHelper::getValue($params,'cat_changefreq',$parent->changefreq,'');
        if ($priority  == '-1')
            $priority = $parent->priority;
        if ($changefreq  == '-1')
            $changefreq = $parent->changefreq;

        $params['cat_priority'] = $priority;
        $params['cat_changefreq'] = $changefreq;

        $priority = JArrayHelper::getValue($params,'prop_priority',$parent->priority,'');
        $changefreq = JArrayHelper::getValue($params,'prop_changefreq',$parent->changefreq,'');
        if ($priority  == '-1')
            $priority = $parent->priority;
        if ($changefreq  == '-1')
            $changefreq = $parent->changefreq;

        $params['prop_priority'] = $priority;
        $params['prop_changefreq'] = $changefreq;
        $params['limit'] = '';
        $params['days'] = '';

        if ( $include_props ) {
            $limit = JArrayHelper::getValue($params,'max_props','','');

            if ( intval($limit) )
                $params['limit'] = $limit;

            $days = JArrayHelper::getValue($params,'max_age','','');
            if ( intval($days) )
                $params['days'] = 'p.created >= '.$db->Quote(date('Y-m-d H:m:s', ($xmap->now - ($days*86400))));
        }

        $result = true;
        switch ($view){
            case 'cat':
                if ($params['include_props'] && $catid) {
                    $result = self::expandCategory($xmap, $parent, $catid, $params, $parent->id);
                }
                break;
            default:
                $result = true;   // Do not expand links to posts
                break;
        }

        return $result;
	}

	static function expandCategory ( $xmap, $parent, $catid, &$params, $itemid ) 
    {
		$db = JFactory::getDbo();
        $settings = ipropertyAdmin::config();
        
        // Filter by start and end dates.
        $nullDate   = $db->Quote($db->getNullDate());
        $date       = JFactory::getDate();
        $nowDate    = $db->Quote($date->toSql());

        $include_maincats = JArrayHelper::getValue($params, 'include_maincats', 1);
        
        $query = $db->getQuery(true);
        $query->select('id AS cat_id, title AS cat_title, parent AS parent_id, alias')
                ->from('#__iproperty_categories')
                ->where('parent = '.(int)$catid)
                ->where('state = 1')
                ->where('(publish_up = '.$nullDate.' OR publish_up <= '.$nowDate.')')
                ->where('(publish_down = '.$nullDate.' OR publish_down >= '.$nowDate.')');
        //if(!$include_maincats){
            $query->where('(SELECT parent FROM #__iproperty_categories WHERE id = '.(int)$catid.' LIMIT 1) != 0');
        //}
        $query->order('ordering ASC');
        
		$db->setQuery($query);
        //echo nl2br(str_replace('#__','jos_',$db->getQuery()));exit;
		$cats = $db->loadObjectList();

		if (count($cats) > 0) {
            $xmap->changeLevel(1);
            foreach($cats as $cat) {
                $node = new stdclass;
                $node->id   = $parent->id;
                $node->browserNav = $parent->browserNav;
                $node->uid  = $parent->uid.'c'.$cat->cat_id;   // Uniq ID for the category
                $node->name = $cat->cat_title;
                $node->priority   = $params['cat_priority'];
                $node->changefreq = $params['cat_changefreq'];
                $node->link = ipropertyHelperRoute::getCatRoute($cat->cat_id.':'.$cat->alias);
                if (strpos($node->link, 'Itemid=') === false) {
                    $node->itemid = $itemid;
                    $node->link .= '&Itemid='.$itemid;
                } else {
                    $node->itemid = preg_replace('/.*Itemid=([0-9]+).*/','$1', $node->link);
                }
                // Added for today's date on category listings
                // thanks to IP user ukfilm
				$node->modified = time();
                $node->expandible = true;
                if ($xmap->printNode($node)) {
                    //echo 'here';
                    self::expandCategory($xmap, $parent, $cat->id, $params, $node->itemid);
                }
            }
            $xmap->changeLevel(-1);
        }

        // Include Category's content
        self::includeCategoryContent($xmap, $parent, $catid, $params, $itemid);
        return true;
	}

    static function includeCategoryContent($xmap, $parent, $catid, &$params, $itemid)
    {
        $db = JFactory::getDbo();
        $settings = ipropertyAdmin::config();
        
        $app            = JFactory::getApplication();
        $menu           = $app->getMenu();
        $mitem          = $menu->getItem($itemid);
        $mparams        = $menu->getParams($itemid);
        
        // Filter by start and end dates.
        $nullDate   = $db->Quote($db->getNullDate());
        $date       = JFactory::getDate();
        $nowDate    = $db->Quote($date->toSql());
        
        if ($mparams || $mitem->query['hotsheet'])
        {
            $eqarray = array('stype', 'city', 'locstate', 'province', 
                'county', 'region', 'country');
            
            $gtarray = array('beds', 'baths', 'price_low');
            $ltarray = array('price_high');
            
            $eqwhere = array();
            foreach($eqarray as $ip){
                if($mparams->get($ip)){
                    $eqwhere[] = 'p.'.$ip.' = '.$db->Quote($mparams->get($ip));
                }
            }
            
            $gtwhere = array();
            foreach($gtarray as $ip){
                if($mparams->get($ip)){
                    $gtwhere[] = 'p.'.$ip.' >= '.$db->Quote($mparams->get($ip));
                }
            }
            
            $ltwhere = array();
            foreach($ltarray as $ip){
                if($mparams->get($ip)){
                    $ltwhere[] = 'p.'.$ip.' <= '.$db->Quote($mparams->get($ip));
                }
            }           
            
            $where = array_merge($eqwhere, $gtwhere, $ltwhere);
            if($mitem->query['hotsheet'] == 1){
                $where[]	= 'p.created > DATE_SUB('.$nowDate.', INTERVAL '.(int)$settings->new_days.' DAY)';
            }
            if($mitem->query['hotsheet'] == 2){
                $where[]	= 'p.modified > DATE_SUB('.$nowDate.', INTERVAL '.(int)$settings->updated_days.' DAY)';
            }
        }       

        if ( $params['include_props'] ) {
            $query = $db->getQuery(true);
			
			//added p.modified to query to add last modified date

            $query->select('p.id AS prop_id, p.title, p.street_num, p.street, p.street2, pm.cat_id, p.alias, p.modified')
                    ->from('#__iproperty as p')
                    ->leftJoin('#__iproperty_propmid as pm on p.id = pm.prop_id')
                    ->where('pm.cat_id = '.(int)$catid)
                    ->where('(p.publish_up = '.$nullDate.' OR p.publish_up <= '.$nowDate.')')
                    ->where('(p.publish_down = '.$nullDate.' OR p.publish_down >= '.$nowDate.')')
                    ->where('p.state = 1')
                    ->where('p.approved = 1');
            if(!empty($where)){
                foreach($where as $w){
                    $query->where($w);
                }
            }
            if($params['days']){
                $query->where($params['days']);
            }
            $query->order('p.created DESC');

			$db->setQuery($query, 0, $params['limit']);
			$props = $db->loadObjectList();

            if (count($props) > 0) {
                $xmap->changeLevel(1);
                foreach($props as $prop) {
                    $node = new stdclass;
                    $node->id           = $parent->id;
                    $node->browserNav   = $parent->browserNav;
                    $node->uid          = $parent->uid .'d'.$prop->prop_id; // Unique ID for the property
                    $node->name         = ($settings->showtitle && $prop->title) ? $prop->title : ((!$settings->street_num_pos) ? $prop->street_num.' '.$prop->street.' '.$prop->street2 : $prop->street.' '.$prop->street2.' '.$prop->street_num);
                    $node->priority     = $params['prop_priority'];
                    $node->changefreq   = $params['prop_changefreq'];
                    $node->link         = ipropertyHelperRoute::getPropertyRoute($prop->prop_id.':'.$prop->alias, $catid, true);
                    if (strpos($node->link, 'Itemid=') === false) {
                        $node->itemid = $itemid;
                        $node->link .= '&Itemid='.$itemid;
                    } else {
                        $node->itemid = preg_replace('/.*Itemid=([0-9]+).*/','$1',$node->link);
                    }
					// Added modified date from query to show accurate last modified date
                    // thanks to IP user ukfilm
					$node->modified     = $prop->modified;
                    $node->expandible   = false;
                    $xmap->printNode($node);
                }
            }
            $xmap->changeLevel(-1);
		}
		return true;
    }
}