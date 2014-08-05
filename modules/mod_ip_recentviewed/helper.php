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

jimport('joomla.utilities.date');

class modIPRecentviewedHelper
{
	function prepareContent( $text, $length=300 ) 
    {
		// strips tags won't remove the actual jscript
		$text = preg_replace( "'<script[^>]*>.*?</script>'si", "", $text );
		$text = preg_replace( '/{.+?}/', '', $text);
		// replace line breaking tags with whitespace
		$text = preg_replace( "'<(br[^/>]*?/|hr[^/>]*?/|/(div|h[1-6]|li|p|td))>'si", ' ', $text );
		$text = strip_tags( $text );
		if (strlen($text) > $length) $text = substr($text, 0, $length) . "...";
		return $text;
	}

    function getPropertiesList( $where, $limitstart=0, $limit=9999, $sort = 'p.created', $order = 'DESC' )
	{
		$db = JFactory::getDBO();
        $property = new ipropertyHelperproperty($db);
        $property->setType('properties');
        $property->setWhere( $where );
        $property->setOrderBy( $sort, $order );
        $properties = $property->getProperty($limitstart,$limit);
        return $properties;
	}

	function getList(&$params, $list)
	{
        $thumb_width            = $params->get('thumb_width', 200) . 'px';
		$thumb_height           = $params->get('thumb_height', 120) . 'px';
		$count                  = (int) $params->get('count', 5);
        $usethumb               = ($params->get('usethumb', 1) == 1) ? true : false;
		$text_length            = intval($params->get( 'preview_count', 75) );
        
        if($params->get('random', 1)){
            $sort                   = 'RAND()';
            $order                  = '';
        }else{
            $sort                   = 'p.created';
            $order                  = 'DESC';
        }

        $where = array();
           
        $proplist   = implode(',', $list);         
        $where[]    = 'p.id IN ('.$proplist.')'; 
        
        //hide sale types
        if($params->get('hide_stypes')){
            $hide_stypes = explode(',', $params->get('hide_stypes'));
            $hide = array();
            foreach($hide_stypes as $h){
                if(is_numeric($h)) $hide[] = $h;
            }
            $hide = implode(',', $hide);
            $where[] = 'p.stype NOT IN ('.trim($hide).')';
        }

        $rows = modIPRecentviewedHelper::getPropertiesList($where,0,$count, $sort, $order);

        $i		= 0;
        $lists	= array();
        if( $rows ){
            foreach ( $rows as $row )
            {
                $available_cats = ipropertyHTML::getAvailableCats($row->id);
                $first_cat      = $available_cats[0];

                $lists[$i]->link            = ipropertyHelperRoute::getPropertyRoute($row->id.':'.$row->prop_alias, $first_cat, true);
                $lists[$i]->mainimage       = ipropertyHTML::getThumbnail($row->id, $lists[$i]->link, $row->street_address, $thumb_width, ' class="ip_recent_img"', '', $usethumb);
                $lists[$i]->street_address  = htmlspecialchars( $row->street_address );
                $lists[$i]->city            = htmlspecialchars( $row->city );
                $lists[$i]->state           = htmlspecialchars( ipropertyHTML::getStateName($row->locstate));
                $lists[$i]->province        = htmlspecialchars( $row->province );
                $lists[$i]->created         = $row->created;
                $lists[$i]->modified        = $row->modified;
                $lists[$i]->stype           = $row->stype;

                $prepared_text = $row->short_description ? modIPRecentviewedHelper::prepareContent($row->short_description, $params->get('preview_count', 250)) : modIPRecentviewedHelper::prepareContent($row->description, $params->get('preview_count', 250));

                if($params->get('clean_desc', 0)){
                    $lists[$i]->introtext = ipropertyHTML::sentence_case($prepared_text);
                }else{
                    $lists[$i]->introtext = $prepared_text;
                }

                $lists[$i]->introtext .= ' <a href="' . $lists[$i]->link . '">' . JTEXT::_('MOD_IP_RECENT_VIEWED_READ_MORE') . '</a>';
                $lists[$i]->formattedprice = $row->formattedprice;
                $i++;

                $prepared_text = '';
            }
        }

		return $lists;
	}
}