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

class modIPPopularHelper
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
        $thumb_width            = $params->get('thumb_width', 200) . 'px';
		$thumb_height           = $params->get('thumb_height', 120) . 'px';
		$count                  = (int) $params->get('count', 5);
        $usethumb               = ($params->get('usethumb', 1) == 1) ? true : false;
		$text_length            = intval($params->get( 'preview_count', 75) );
        $sort                   = 'p.hits';
        $order                  = 'DESC';

        $where = array();
        
        //specific stype - added 2.0.1
        if($params->get('prop_stype')) $where[] = 'p.stype = '.(int)$params->get('prop_stype');

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
        //update 2.0.1 - new option to select subcategories as well
        if($params->get('cat_id') && $params->get('cat_subcats')){
            $db = JFactory::getDbo();
            
            $cats_array = array( $params->get('cat_id') );
            $squery = $db->setQuery(IpropertyHelperQuery::getCategories($params->get('cat_id')));
            $subcats = $db->loadObjectList();
            
            foreach($subcats as $s){
                $cats_array[] = (int)$s->id;
            }
            $where[] = "pm.cat_id IN (".(implode(',', $cats_array)).")";
        }elseif( $params->get('cat_id')){
            $where[] = 'pm.cat_id = '.$params->get('cat_id');
        }
        $rows = modIPPopularHelper::getPropertiesList($where,0,$count, $sort, $order);

        $i		= 0;
        $lists	= array();
        if( $rows ){
            foreach ( $rows as $row )
            {
                // for route helper - if category is selected in module params, attempt to route to that category menu item
                if($params->get('cat_id')){
                    $cat    = $params->get('cat_id');
                }else{ // no category in module params - get related category for route helper
                    $available_cats = ipropertyHTML::getAvailableCats($row->id);
                    $cat    = $available_cats[0];
                }

                $lists[$i]->link            = ipropertyHelperRoute::getPropertyRoute($row->id.':'.$row->prop_alias, $cat, true);
                $lists[$i]->mainimage       = ipropertyHTML::getThumbnail($row->id, $lists[$i]->link, $row->street_address, $thumb_width, ' class="ip_popular_img"', '', $usethumb);
                $lists[$i]->street_address  = htmlspecialchars( $row->street_address );
                $lists[$i]->city            = htmlspecialchars( $row->city );
                $lists[$i]->state           = htmlspecialchars( ipropertyHTML::getStateName($row->locstate));
                $lists[$i]->province        = htmlspecialchars( $row->province );
                $lists[$i]->created         = $row->created;
                $lists[$i]->modified        = $row->modified;
                $lists[$i]->stype           = $row->stype;

                $prepared_text = $row->short_description ? modIPPopularHelper::prepareContent($row->short_description, $params->get('preview_count', 250)) : modIPPopularHelper::prepareContent($row->description, $params->get('preview_count', 250));

                if($params->get('clean_desc', 0)){
                    $lists[$i]->introtext = ipropertyHTML::sentence_case($prepared_text);
                }else{
                    $lists[$i]->introtext = $prepared_text;
                }

                $lists[$i]->introtext .= ' <a href="' . $lists[$i]->link . '">' . JTEXT::_('MOD_IP_POPULAR_READ_MORE') . '</a>';
                $lists[$i]->formattedprice = $row->formattedprice;
                $i++;

                $prepared_text = '';
            }
        }

		return $lists;
	}
}