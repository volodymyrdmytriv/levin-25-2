<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.model');

class IpropertyModelAgentProperties extends JModel
{
	var $_data          = null;
	var $_id            = null;
	var $_where         = null;
	var $_total         = null;
    var $_agent         = null;
    var $_featured      = null;
    
    //search fields
    var $_stype         = null;
    var $_ptype         = null;
	var $_city          = null;
    var $_curstate      = null;
    var $_province      = null;
    var $_county        = null;
    var $_region        = null;
    var $_country       = null;
    var $_beds          = null;
    var $_baths         = null;
    var $_price_low     = null;
    var $_price_high    = null;
    var $_sort          = null;
    var $_order         = null;
	var $_search        = null;
	var $_searchwhere   = null;
	
	function __construct()
	{
		parent::__construct();
		
		$app  = JFactory::getApplication();
        $option     = JRequest::getCmd('option');
        
		$settings =  ipropertyAdmin::config();
        $perpage  = $settings->perpage;
		
		if(JRequest::getVar('format') != 'feed'){
            // Get the pagination request variables
            $this->setState('limit', $perpage);
            $this->setState('limitstart', JRequest::getVar('limitstart', 0, '', 'int'));
            $this->setState('limitstart', ($this->getState('limit') != 0 ? (floor($this->getState('limitstart') / $this->getState('limit')) * $this->getState('limit')) : 0));
		}else{
            // if feed, want to display 100
            $this->setState( 'limit', $settings->rss );
            $this->setState( 'limitstart', 0 );
        }

		// Set id for property type
		$id = JRequest::getInt('id');
		$this->setId($id);
	}
	
	function setId($id)
	{
		$this->_id	    = $id;
		$this->_data	= null;
	}
	
	function getData()
	{
		$app  = JFactory::getApplication();
        $option     = JRequest::getCmd('option');
        
		$debug = '';
        $settings = ipropertyAdmin::config();
		$perpage  = $settings->perpage;

		if (empty($this->_properties))
		{
			// Get the WHERE and ORDER BY clauses for the query
			$where		= $this->_buildContentWhere();

			$this->_property = new ipropertyHelperproperty($this->_db);
			$this->_property->setType('properties');
			$this->_property->setWhere( $where );
			$this->_property->setOrderBy( $this->_sort, $this->_order );
			$this->_properties  = $this->_property->getProperty($this->getState('limitstart'),$this->getState('limit'), $debug);
            $this->_total       = $this->_property->getTotal();
		}
		return $this->_properties;
	}

    function getFeatured()
	{
	    $app  = JFactory::getApplication();
        
		$settings = ipropertyAdmin::config();
		$fperpage = $settings->num_featured;
        $where    = $this->_where;
        $where[]  = 'p.featured = 1';
		
		$this->_featured = new ipropertyHelperproperty($this->_db);
		$this->_featured->setType('properties');
        $this->_featured->setWhere( $where );
		$this->_featured->setOrderBy('RAND()', '');
		$this->_featured = $this->_featured->getProperty(0,$fperpage);

		return $this->_featured;
	}
	
	function getPagination()
	{
        // Lets load the content if it doesn't already exist
        if (empty($this->_pagination))
        {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination( $this->_total, $this->getState('limitstart'), $this->getState('limit') );
        }
        return $this->_pagination;
	}
	
	function _buildContentWhere()
	{
        $app  = JFactory::getApplication();
        $option     = JRequest::getCmd('option');
        
        $settings = ipropertyAdmin::config();
        $db = JFactory::getDBO();
        $currid = JRequest::getInt('id', 0).':'.JRequest::getInt('Itemid', 0);

        //get search criteria from form unless rss feed format
        if(JRequest::getVar('format') != 'feed'){
            $this->_stype       = $app->getUserStateFromRequest( $option.'.agentproperties.stype'.$currid, 'stype', '', 'int' );
            $this->_ptype       = $app->getUserStateFromRequest( $option.'.agentproperties.cat'.$currid, 'cat', '', 'int' );
            $this->_city        = $app->getUserStateFromRequest( $option.'.agentproperties.city'.$currid, 'city', '', 'string' );
            $this->_curstate    = $app->getUserStateFromRequest( $option.'.agentproperties.locstate'.$currid, 'locstate', '', 'int' );
            $this->_province    = $app->getUserStateFromRequest( $option.'.agentproperties.province'.$currid, 'province', '', 'string' );
            $this->_county      = $app->getUserStateFromRequest( $option.'.agentproperties.county'.$currid, 'county', '', 'string' );
            $this->_region      = $app->getUserStateFromRequest( $option.'.agentproperties.region'.$currid, 'region', '', 'string' );
            $this->_country     = $app->getUserStateFromRequest( $option.'.agentproperties.country'.$currid, 'country', '', 'int' );
            $this->_beds        = $app->getUserStateFromRequest( $option.'.agentproperties.beds'.$currid, 'beds', '', 'int' );
            $this->_baths       = $app->getUserStateFromRequest( $option.'.agentproperties.baths'.$currid, 'baths', '', 'int' );
            $this->_price_low   = $app->getUserStateFromRequest( $option.'.agentproperties.price_low'.$currid, 'price_low', '', 'int' );
            $this->_price_high  = $app->getUserStateFromRequest( $option.'.agentproperties.price_high'.$currid, 'price_high', '', 'int' );
            $this->_sort        = $app->getUserStateFromRequest( $option.'.agentproperties.filter_order'.$currid, 'filter_order', $settings->default_p_sort, 'cmd' );
            $this->_order	    = $app->getUserStateFromRequest( $option.'.agentproperties.filter_order_dir'.$currid, 'filter_order_dir', $settings->default_p_order, 'word' );

            $search_string      = $app->getUserStateFromRequest( $option.'.agentproperties.search'.$currid, 'search', '', 'string' );
            $this->_search	= urldecode($search_string);
            $this->_search	= JString::strtolower($this->_search);
            if( $this->_search ){
                $search_array = explode(' ', $this->_search);
                $this->_searchwhere = array();
                
                if (is_array($search_array)){ //more than one search word
                    foreach ($search_array as $word){
                        $this->_searchwhere[] = 'LOWER( p.mls_id ) LIKE '.$db->Quote( '%'.$db->getEscaped( $word, true ).'%', false );
                        $this->_searchwhere[] = 'LOWER( p.street_num ) LIKE '.$db->Quote( '%'.$db->getEscaped( $word, true ).'%', false );
                        $this->_searchwhere[] = 'LOWER( p.street ) LIKE '.$db->Quote( '%'.$db->getEscaped( $word, true ).'%', false );
                        $this->_searchwhere[] = 'LOWER( p.street2 ) LIKE '.$db->Quote( '%'.$db->getEscaped( $word, true ).'%', false );
                        $this->_searchwhere[] = 'LOWER( p.description ) LIKE '.$db->Quote( '%'.$db->getEscaped( $word, true ).'%', false );
                        $this->_searchwhere[] = 'LOWER( p.city ) LIKE '.$db->Quote( '%'.$db->getEscaped( $word, true ).'%', false );
                        $this->_searchwhere[] = 'LOWER( p.title ) LIKE '.$db->Quote( '%'.$db->getEscaped( $word, true ).'%', false );
                    }
                } else {
                    $this->_searchwhere[] = 'LOWER( p.mls_id ) LIKE '.$db->Quote( '%'.$db->getEscaped( $this->_search, true ).'%', false );
                    $this->_searchwhere[] = 'LOWER( p.street_num ) LIKE '.$db->Quote( '%'.$db->getEscaped( $this->_search, true ).'%', false );
                    $this->_searchwhere[] = 'LOWER( p.street ) LIKE '.$db->Quote( '%'.$db->getEscaped( $this->_search, true ).'%', false );
                    $this->_searchwhere[] = 'LOWER( p.street2 ) LIKE '.$db->Quote( '%'.$db->getEscaped( $this->_search, true ).'%', false );
                    $this->_searchwhere[] = 'LOWER( p.description ) LIKE '.$db->Quote( '%'.$db->getEscaped( $this->_search, true ).'%', false );
                    $this->_searchwhere[] = 'LOWER( p.city ) LIKE '.$db->Quote( '%'.$db->getEscaped( $this->_search, true ).'%', false );
                    $this->_searchwhere[] = 'LOWER( p.title ) LIKE '.$db->Quote( '%'.$db->getEscaped( $this->_search, true ).'%', false );
                }                
            }
        }else{
            $this->_sort    = 'p.created';
            $this->_order   = 'DESC';
        }

        $where = array();
        $where[] = 'am.agent_id = '.(int)$this->_id;       
        
        // v1.5.5 - removed check for sale and lease; does not work with dynamic sale types list
        if( $this->_stype ) $where[] = 'p.stype = ' . (int)$this->_stype;

        if($this->_searchwhere) $where[]    = "(".implode( ' OR ', $this->_searchwhere ).")";
        if($this->_ptype){
            $children    = ipropertyHelperProperty::getChildren($this->_ptype);
            if($children){
                $child_array = array();
                foreach( $children as $c ){
                    $child_array[] = $c->id;
                }
                $child_array = implode(',', $child_array);
                $where[] = '(pm.cat_id = ' . (int)$this->_ptype . ' OR pm.cat_id IN (' . $child_array . '))';
            }else{
                $where[] = 'pm.cat_id = ' . (int)$this->_ptype;
            }
            //$where[]          = 'pm.cat_id = '.(int)$this->_ptype;
        }
		if($this->_city) $where[]           = 'LOWER(p.city) = '.$db->Quote(JString::strtolower($this->_city));
        if($this->_curstate) $where[]       = 'p.locstate = '.(int)$this->_curstate;
        if($this->_province) $where[]       = 'LOWER(p.province) = '.$db->Quote(JString::strtolower($this->_province));
        if($this->_county) $where[]         = 'LOWER(p.county) = '.$db->Quote(JString::strtolower($this->_county));
        if($this->_region) $where[]         = 'LOWER(p.region) = '.$db->Quote(JString::strtolower($this->_region));
        if($this->_country) $where[]        = 'p.country = '.(int)$this->_country;
        if($this->_beds) $where[]           = 'p.beds >= '.(int)$this->_beds;
        if($this->_baths) $where[]          = 'p.baths >= '.(int)$this->_baths;
        //price
        if($this->_price_low && $this->_price_high) $where[] = '(p.price BETWEEN ' . (int)$this->_price_low . ' AND ' . (int)$this->_price_high . ')';
		if($this->_price_low && !$this->_price_high) $where[] = 'p.price >= ' . (int)$this->_price_low;
		if($this->_price_high && !$this->_price_low) $where[] = 'p.price <= ' . (int)$this->_price_high;

		$this->_where = $where;
		return $this->_where;
	}

    function getAgent()
    {
        $this->_agent = IpropertyHelperQuery::buildAgent($this->_id);
        return $this->_agent;
    }

    function getStype()
	{
		return $this->_stype;
	}

    function getPtype()
	{
		return $this->_ptype;
	}

	function getCity()
	{
		return $this->_city;
	}

    function getCurState()
	{
		return $this->_curstate;
	}

    function getProvince()
	{
		return $this->_province;
	}

    function getCounty()
	{
		return $this->_county;
	}

    function getRegion()
	{
		return $this->_region;
	}

    function getCountry()
	{
		return $this->_country;
	}

    function getBeds()
	{
		return $this->_beds;
	}

    function getBaths()
	{
		return $this->_baths;
	}

    function getSearch()
	{
		return $this->_search;
	}

    function getPricehigh()
	{
		return $this->_price_high;
	}

    function getPricelow()
	{
		return $this->_price_low;
	}

    function getSort()
	{
		return $this->_sort;
	}

    function getOrder()
	{
		return $this->_order;
	}
}

?>