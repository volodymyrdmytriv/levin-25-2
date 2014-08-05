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

class modIPFeaturedcompaniesHelper
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

    function getCompaniesList( $where, $limitstart=0, $limit=9999, $sort = 'c.ordering', $order = 'ASC' )
    {
        $db = JFactory::getDBO();

        $query = $db->getQuery(true);
        $query->select('c.*')->from('#__iproperty_companies AS c');

        if($where){
            foreach ($where as $w){
                $query->where($w);
            }
        }

        $query->order($sort.' '.$order);
        $db->setQuery($query, $limitstart, $limit);
        $companies = $db->loadObjectList();

        return $companies;
    }

    function getRandString()
    {
        $length = 5;
        $characters = '0123456789';
        $string = '';

        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $string;
    }

    function getList(&$params)
    {
        $thumb_width      = (int) $params->get('thumb_width', 200) . 'px';
        $thumb_height     = (int) $params->get('thumb_height', 120) . 'px';
        $count            = (int) $params->get('count', 5);
        $text_length      = intval($params->get( 'preview_count', 75) );

        // Ordering
        switch ($params->get( 'ordering' ))
        {
            case '1':
                $sort           = 'c.name';
                $order          = 'ASC';
                break;
            case '2':
                $sort           = 'RAND()';
                $order          = '';
                break;
            case '3':
            default:
                $sort           = 'c.ordering';
                $order          = 'ASC';
                break;
        }

        $where = array();
        $where[] = 'c.featured = 1';

        if( $params->get('city')) $where[] = 'c.city = "'.$params->get('city').'"';

        $rows = modIPFeaturedcompaniesHelper::getCompaniesList($where,0,$count, $sort, $order);

        $i      = 0;
        $lists  = array();
        if( $rows ){
            foreach ( $rows as $row )
            {
                $lists[$i]->link            = JRoute::_(ipropertyHelperRoute::getCompanyPropertyRoute($row->id.':'.$row->alias));
                $lists[$i]->mainimage       = $row->icon ?  IpropertyHTML::getIconpath($row->icon, 'company') :  IpropertyHTML::getIconpath('nopic.png', 'company');
                $lists[$i]->name            = $row->name;

                $prepared_text = $row->description ? modIPFeaturedcompaniesHelper::prepareContent($row->description, $params->get('preview_count', 250)) : '';

                if($params->get('clean_desc', 0)){
                    $lists[$i]->introtext = ipropertyHTML::sentence_case($prepared_text);
                }else{
                    $lists[$i]->introtext = $prepared_text;
                }

                $lists[$i]->introtext .= ' <a href="' . $lists[$i]->link . '">' . JTEXT::_('MOD_IP_FEATUREDCOMPANIES_READ_MORE') . '</a>';

                $i++;

                $prepared_text = '';
            }
        }

        return $lists;
    }
}
