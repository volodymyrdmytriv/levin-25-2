<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
// constants for setting the $units data member
define('_UNIT_MILES', 'm');
define('_UNIT_KILOMETERS', 'k');

// constants for passing $sort to get_zips_in_range()
define('_ZIPS_SORT_BY_DISTANCE_ASC', 1);
define('_ZIPS_SORT_BY_DISTANCE_DESC', 2);
define('_ZIPS_SORT_BY_ZIP_ASC', 3);
define('_ZIPS_SORT_BY_ZIP_DESC', 4);

// constant for miles to kilometers conversion
define('_M2KM_FACTOR', 1.609344);

jimport('joomla.application.component.model');

class IpropertyModelAdvsearch extends JModel
{	
	var $_ptype = null;
    var $_stype = null;
    var $_city = null;
    var $_country = null;
    var $_county = null;
    var $_region = null;
    var $_locstate = null;
    var $_province = null;
	var $_price_high = null;
	var $_price_low = null;
	var $_sqft_high = null;
	var $_sqft_low = null;
    var $_beds_high = null;
    var $_beds_low = null;
    var $_baths_high = null;
    var $_baths_low = null;
    var $_search = null;
    var $_searchwhere = null;
    var $_reo = null;
    var $_hoa = null;
    var $_waterfront = null;
    var $_geopoint = null;
	
	var $_prev_search = null;
    var $_id = null;
    var $_data = null;
    var $_where = null;
    var $_property = null;
    var $_total = null;
	
	function __construct()
	{
		
		parent::__construct();
		
		$app  = JFactory::getApplication();
        $option     = JRequest::getCmd('option');
        
        $db = JFactory::getDBO();
		$settings = ipropertyAdmin::config();
		$session  = JFactory::getSession();
        $perpage  = $settings->adv_perpage;

        // if requested limit and request is smaller than the max perpage in IP settings
        // set the limit to the requested limit
        if(JRequest::getInt('limit') && (JRequest::getInt('limit') <= $perpage)){
            $perpage = JRequest::getInt('limit');
        }
		
		// Get the pagination request variables
		$this->setState('limit', $perpage);
		$this->setState('limitstart', JRequest::getVar('limitstart', 0, '', 'int'));
		
		// In case limit has been changed, adjust limitstart accordingly
		$this->setState('limitstart', ($this->getState('limit') != 0 ? (floor($this->getState('limitstart') / $this->getState('limit')) * $this->getState('limit')) : 0));
		
		// Set id for property type
        $id  = JRequest::getInt('id');
		$this->setId($id);

        //nolimit settings
        $this->_setprice_high   = $settings->adv_price_high;
        $this->_setprice_low    = $settings->adv_price_low;
        $this->nolimit          = $settings->adv_nolimit;

        /* Set pre-defined values */
        $this->pdptype          = JRequest::getInt('cat');
		$this->pdstype          = JRequest::getInt('stype');
		$this->pdcity           = JRequest::getString('city');
		$this->pdlocstate       = JRequest::getInt('locstate');
        $this->pdprovince       = JRequest::getString('province');
        $this->pdcounty         = JRequest::getString('county');
        $this->pdregion         = JRequest::getString('region');
        $this->pdcountry        = JRequest::getInt('country');
        $this->pdreo            = JRequest::getInt('reo');
        $this->pdhoa            = JRequest::getInt('hoa');
        $this->pdwf             = JRequest::getInt('waterfront');

	}
	
	function setId($id)
	{
		$this->_id	    = $id;
		$this->_data	= null;
	}
	
	function getData($geopoint = false)
	{
	    $app  = JFactory::getApplication();
        $option     = JRequest::getCmd('option');
        
        $settings = ipropertyAdmin::config();
		
		if (empty($this->_data))
		{	
			$where		= $this->_buildContentWhere($geopoint);     
			$sort		= $app->getUserStateFromRequest( $option.'.advsearch.filter_order', 'filter_order', $settings->default_p_sort, 'cmd' );
			$order	    = $app->getUserStateFromRequest( $option.'.advsearch.filter_order_Dir', 'filter_order_Dir', $settings->default_p_order, 'word' );
			
			$this->_property = new IpropertyHelperProperty($this->_db);
			$this->_property->setType('advsearch');
			$this->_property->setWhere( $where );
			$this->_property->setOrderBy( $sort, $order );
            $this->_data    = $this->_property->getProperty($this->getState('limitstart'),$this->getState('limit'));
            $this->_total   = $this->_property->getTotal();
		}

		return $this->_data;
	}
	
	function getTotal()
	{
		return $this->_total;
	}
	
	function getPagination()
	{
	  if (empty($this->_pagination))
	  {
		 jimport('joomla.html.pagination');
		 $this->_pagination = new JPagination( $this->_total, $this->getState('limitstart'), $this->getState('limit') );				  
	  }	
	  return $this->_pagination;
	}
	
	function _buildContentWhere($geopoint = false)
	{
        $app    = JFactory::getApplication();
        $option = JRequest::getCmd('option');
        
        $db     = JFactory::getDBO();
        $currid = JRequest::getInt('Itemid');

        $this->_geopoint    = $geopoint;
        $this->_stype       = ($this->pdstype) ? $this->pdstype : $app->getUserStateFromRequest( $option.'.advsearch.stype'.$currid, 'stype', '', 'int' );
        $this->_ptype       = ($this->pdptype) ? $this->pdptype : $app->getUserStateFromRequest( $option.'.advsearch.ptype'.$currid, 'ptype', '', 'string' );
        $this->_city        = ($this->pdcity) ? $this->pdcity : $app->getUserStateFromRequest( $option.'.advsearch.city'.$currid, 'city', '', 'string' );
        $this->_locstate    = ($this->pdlocstate) ? $this->pdlocstate : $app->getUserStateFromRequest( $option.'.advsearch.locstate'.$currid, 'locstate', '', 'int' );
        $this->_province    = ($this->pdprovince) ? $this->pdprovince : $app->getUserStateFromRequest( $option.'.advsearch.province'.$currid, 'province', '', 'string' );
        $this->_county      = ($this->pdcounty) ? $this->pdcounty : $app->getUserStateFromRequest( $option.'.advsearch.county'.$currid, 'county', '', 'string' );
        $this->_region      = ($this->pdregion) ? $this->pdregion : $app->getUserStateFromRequest( $option.'.advsearch.region'.$currid, 'region', '', 'string' );
        $this->_country     = ($this->pdcountry) ? $this->pdcountry : $app->getUserStateFromRequest( $option.'.advsearch.country'.$currid, 'country', '', 'int' );
        $this->_waterfront  = ($this->pdwf) ? $this->pdwf : $app->getUserStateFromRequest( $option.'.advsearch.waterfront'.$currid, 'waterfront', '', 'bool' );
        $this->_hoa         = ($this->pdhoa) ? $this->pdhoa : $app->getUserStateFromRequest( $option.'.advsearch.hoa'.$currid, 'hoa', '', 'bool' );
        $this->_reo         = ($this->pdreo) ? $this->pdreo : $app->getUserStateFromRequest( $option.'.advsearch.reo'.$currid, 'reo', '', 'bool' );

        $this->_price_low   = $app->getUserStateFromRequest( $option.'.advsearch.price_low'.$currid, 'price_low', '', 'int' );
        $this->_price_high  = $app->getUserStateFromRequest( $option.'.advsearch.price_high'.$currid, 'price_high', '', 'int' );
        $this->_beds_low    = $app->getUserStateFromRequest( $option.'.advsearch.beds_low'.$currid, 'beds_low', '', 'int' );
        $this->_beds_high   = $app->getUserStateFromRequest( $option.'.advsearch.beds_high'.$currid, 'beds_high', '', 'int' );
        $this->_baths_low   = $app->getUserStateFromRequest( $option.'.advsearch.baths_low'.$currid, 'baths_low', '', 'int' );
        $this->_baths_high  = $app->getUserStateFromRequest( $option.'.advsearch.baths_high'.$currid, 'baths_high', '', 'int' );
        $this->_sqft_low    = $app->getUserStateFromRequest( $option.'.advsearch.sqft_low'.$currid, 'sqft_low', '', 'int' );
        $this->_sqft_high   = $app->getUserStateFromRequest( $option.'.advsearch.sqft_high'.$currid, 'sqft_high', '', 'int' );

        $this->_start_price = $app->getUserStateFromRequest( $option.'.advsearch.start_price'.$currid, 'start_price', '', 'int' );
        $this->_end_price   = $app->getUserStateFromRequest( $option.'.advsearch.end_price'.$currid, 'end_price', '', 'int' );
        $this->_start_beds  = $app->getUserStateFromRequest( $option.'.advsearch.start_beds'.$currid, 'start_beds', '', 'int' );
        $this->_end_beds    = $app->getUserStateFromRequest( $option.'.advsearch.end_beds'.$currid, 'end_beds', '', 'int' );
        $this->_start_baths = $app->getUserStateFromRequest( $option.'.advsearch.start_baths'.$currid, 'start_baths', '', 'int' );
        $this->_end_baths   = $app->getUserStateFromRequest( $option.'.advsearch.end_baths'.$currid, 'end_baths', '', 'int' );
        $this->_start_sqft  = $app->getUserStateFromRequest( $option.'.advsearch.start_sqft'.$currid, 'start_sqft', '', 'int' );
        $this->_end_sqft    = $app->getUserStateFromRequest( $option.'.advsearch.end_sqft'.$currid, 'end_sqft', '', 'int' );

        $search_string      = $app->getUserStateFromRequest( $option.'.advsearch.search'.$currid, 'search', '', 'string' );
        $this->_search	    = urldecode($search_string);
		$this->_search	    = JString::strtolower($this->_search);
		if( $this->_search ){
			$this->_searchwhere = array();
            $this->_searchwhere[] = 'LOWER( p.mls_id ) LIKE '.$db->Quote( '%'.$db->getEscaped( $this->_search, true ).'%', false );
			$this->_searchwhere[] = 'LOWER( p.street ) LIKE '.$db->Quote( '%'.$db->getEscaped( $this->_search, true ).'%', false );
            $this->_searchwhere[] = 'LOWER( p.street2 ) LIKE '.$db->Quote( '%'.$db->getEscaped( $this->_search, true ).'%', false );
			$this->_searchwhere[] = 'LOWER( p.description ) LIKE '.$db->Quote( '%'.$db->getEscaped( $this->_search, true ).'%', false );
            $this->_searchwhere[] = 'LOWER( p.city ) LIKE '.$db->Quote( '%'.$db->getEscaped( $this->_search, true ).'%', false );
            $this->_searchwhere[] = 'LOWER( p.county ) LIKE '.$db->Quote( '%'.$db->getEscaped( $this->_search, true ).'%', false );
            $this->_searchwhere[] = 'LOWER( p.region ) LIKE '.$db->Quote( '%'.$db->getEscaped( $this->_search, true ).'%', false );
            $this->_searchwhere[] = 'LOWER( p.title ) LIKE '.$db->Quote( '%'.$db->getEscaped( $this->_search, true ).'%', false );
		}

        $where = array();

        //search string
        if( $this->_searchwhere ) $where[] = "(".implode( ' OR ', $this->_searchwhere ).")";
        // property type checkboxes
        // 2.0 changed where to return comma separated list to query helper
        if($this->_ptype){
            $scats = $this->_ptype;
            $temptypes  = explode(',', $this->_ptype);
            foreach($temptypes as $t){
                $subcats    = ipropertyHTML::getCategories($t);
                foreach($subcats as $s){
                    $scats .= ','.$s->value;
                }  
            }
            
            $where[] = 'pm.cat_id = '.$scats;
        }
        // location search
        if($this->_city) $where[] = 'LOWER(p.city) = '.JString::strtolower($db->Quote( $this->_city ));
        if($this->_country) $where[] = 'p.country = '.(int) $this->_country;
        if($this->_county) $where[] = 'LOWER(p.county) = '.JString::strtolower($db->Quote( $this->_county ));
        if($this->_region) $where[] = 'LOWER(p.region) = '.JString::strtolower($db->Quote( $this->_region ));
        if($this->_locstate) $where[] = 'p.locstate = '.(int) $this->_locstate;
        if($this->_province) $where[] = 'LOWER(p.province) = '.JString::strtolower($db->Quote( $this->_province ));
        // sale type
        // note: v1.5.5 - removed check for sale or lease because of dynamic sale type list
        if( $this->_stype ) $where[] = 'p.stype = ' . (int)$this->_stype;
        
        //price
        $price_low  = (($this->_price_low == $this->_setprice_low) && $this->nolimit) ? false : (int) $this->_price_low;
        $price_hi   = (($this->_price_high == $this->_setprice_high) && $this->nolimit) ? false : (int) $this->_price_high;
        
        if($price_low && $price_hi) {
			$where[] = '(p.price BETWEEN ' . (int)$price_low . ' AND ' . (int)$price_hi . ')';
		} elseif ($price_low && !$price_hi) {
			$where[] = 'p.price >= ' . (int)$price_low;
		} elseif ($price_hi && !$price_low) {
			$where[] = 'p.price <= ' . (int)$price_hi;
		}

        // square ft
        if($this->_sqft_low && $this->_sqft_high) $where[] = '(p.sqft BETWEEN ' . (int)$this->_sqft_low . ' AND ' . (int)$this->_sqft_high . ')';
		if($this->_sqft_low && !$this->_sqft_high) $where[] = 'p.sqft >= ' . (int)$this->_sqft_low;
		if($this->_sqft_high && !$this->_sqft_low) $where[] = 'p.sqft <= ' . (int)$this->_sqft_high;

        // beds
        if($this->_beds_low && $this->_beds_high) $where[] = '(p.beds BETWEEN ' . (int)$this->_beds_low . ' AND ' . (int)$this->_beds_high . ')';
		if($this->_beds_low && !$this->_beds_high) $where[] = 'p.beds >= ' . (int)$this->_beds_low;
		if($this->_beds_high && !$this->_beds_low) $where[] = 'p.beds <= ' . (int)$this->_beds_high;

        // baths
        if($this->_baths_low && $this->_baths_high) $where[] = '(p.baths BETWEEN ' . (int)$this->_baths_low . ' AND ' . (int)$this->_baths_high . ')';
		if($this->_baths_low && !$this->_baths_high) $where[] = 'p.baths >= ' . (int)$this->_baths_low;
		if($this->_baths_high && !$this->_baths_low) $where[] = 'p.baths <= ' . (int)$this->_baths_high;

        // waterfront, hoa, reo
        if($this->_waterfront) $where[] = 'p.frontage = 1';
        if($this->_hoa) $where[] = 'p.hoa = 1';
        if($this->_reo) $where[] = 'p.reo = 1';
        
        // Geopoint
        if($this->_geopoint){
            // check for shape data
            if ($this->_geopoint->type == 'circle'){    
                if(isset($this->_geopoint->lat) && isset($this->_geopoint->lon) && isset($this->_geopoint->rad)){
                    // it's a radius search
                    // thanks to Chris Veness for basic code
                    // (c) http://www.movable-type.co.uk/scripts/latlong-db.html
                    // rad must be in KM!!
                    $R 		= 6371; // radius of Earth in KM
                    $arad	= $this->_geopoint->rad / $R; // angular radius
                    $max_lat = $this->_geopoint->lat + rad2deg($this->_geopoint->rad/$R);
                    $min_lat = $this->_geopoint->lat - rad2deg($this->_geopoint->rad/$R);
                    $max_lon = $this->_geopoint->lon + rad2deg($this->_geopoint->rad/$R/cos(deg2rad($this->_geopoint->lat)));
                    $min_lon = $this->_geopoint->lon - rad2deg($this->_geopoint->rad/$R/cos(deg2rad($this->_geopoint->lat)));

                    $where[] = '(p.latitude > ' . $min_lat . ' AND p.latitude < ' . $max_lat . ')';
                    $where[] = '(p.longitude > ' . $min_lon . ' AND p.longitude < ' . $max_lon . ')';
                    // refining query
                    $where[] = 'acos(sin('.deg2rad($this->_geopoint->lat).') * sin(radians(p.latitude)) + cos('.deg2rad($this->_geopoint->lat).') * cos(radians(p.latitude)) * cos(radians(p.longitude) - ('.deg2rad($this->_geopoint->lon).'))) <= '.$arad;
                } 
            } else if ($this->_geopoint->type == 'rectangle'){
                // it's a rectangle!
				$min_lat = (float) $this->_geopoint->sw[0];
				$min_lon = (float) $this->_geopoint->sw[1];
				$max_lat = (float) $this->_geopoint->ne[0];
				$max_lon = (float) $this->_geopoint->ne[1];
                $where[] = '(p.latitude >= ' . $min_lat . ' AND p.latitude <= ' . $max_lat . ')';
                $where[] = '(p.longitude >= ' . $min_lon . ' AND p.longitude <= ' . $max_lon . ')';
            }
        }

        $this->_where = $where;
        return $this->_where;
	}
	
	function getMapdata()
    {
		$this->_json = "{\"markers\":" . json_encode($this->_data) . "}";
		return $this->_json;
	}
}

?>
