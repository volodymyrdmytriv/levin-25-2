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
require_once(JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'helpers'.DS.'agent.php');
require_once(JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'helpers'.DS.'route.php');
require_once(JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'helpers'.DS.'query.php');
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_iproperty'.DS.'classes'.DS.'admin.class.php');

class modIPAgentHelper
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

    function getAgentList( $where, $limitstart = 0, $limit = 9999, $sort = 'a.company', $order = 'ASC' )
    {
        $db = JFactory::getDBO();
        $agent = new ipropertyHelperagent($db);
        $agent->setType('agents');
        $agent->setWhere( $where );
        $agent->setOrderBy( $sort, $order );
        $agents = $agent->getAgent($limitstart,$limit);
        return $agents;
    }

    function getList(&$params)
    {       
        $thumb_width            = (int) $params->get('thumb_width', 200) . 'px';
		$thumb_height           = (int) $params->get('thumb_height', 120) . 'px';
		$count                  = (int) $params->get('count', 5);
		$text_length            = intval($params->get( 'preview_count', 75) );
        $sort                   = $params->get('random') ? 'RAND()' : 'company';
        $order                  = '';

        $where = array();
		$where[] = "a.icon != ''"; 
        $where[] = "a.icon != 'nopic.png'";
        if($params->get('featured', 0)) $where[] = 'a.featured = 1';
        if($params->get('company_id', 0)) $where[] = 'a.company = '.$params->get('company_id');
        $rows = modIPAgentHelper::getAgentList($where, 0, $count, $sort, $order);

        $i      = 0;
        $lists  = array();
        if( $rows ){
            foreach ( $rows as $row )
            {
                $lists[$i]->link            = ipropertyHelperRoute::getAgentPropertyRoute($row->id.':'.$row->alias);
                $lists[$i]->name            = $row->fname . ' ' . $row->lname;
                $lists[$i]->mainimage       = $row->icon ?  IpropertyHTML::getIconpath($row->icon, 'agent') :  IpropertyHTML::getIconpath('nopic.png', 'agent');
                $lists[$i]->company         = ipropertyHTML::getCompanyName($row->company);
                $lists[$i]->clink           = ipropertyHelperRoute::getCompanyPropertyRoute($row->company.':'.$row->co_alias);

                $prepared_text = $row->bio ? modIPAgentHelper::prepareContent($row->bio, $text_length) : '';

                if($params->get('clean_desc', 0)){
                    $lists[$i]->introtext = ipropertyHTML::sentence_case($prepared_text);
                }else{
                    $lists[$i]->introtext = $prepared_text;
                }
                //$lists[$i]->introtext .= ' <a href="' . $lists[$i]->link . '">' . JTEXT::_('READ MORE') . '</a>';
                $i++;

                $prepared_text = '';
            }
        }

        return $lists;
    }
}
