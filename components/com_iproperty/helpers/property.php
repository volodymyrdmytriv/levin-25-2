<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class IpropertyHelperProperty extends JObject
{
    var $_db    = null;
    var $type   = null;
    var $_sort  = null;
    var $_order = null;
    var $_id    = null;
    var $_where = null;
    var $_total = null;

    function __construct(&$db)
    {
        $this->_db      = $db;
    }

    function setType($type)
    {
        $this->type     = $type;
    }

    function setId($id)
    {
        $this->_id      = $id;
    }

    function setWhere($where)
    {
        $this->_where   = $where;
    }

    function setOrderBy($sort, $order)
    {
        $this->_sort    = $sort;
        $this->_order   = $order;
    }

    function setTotal($total)
    {
        $this->_total   = $total;
    }

    function getTotal(){
        if ($this->_total){
            return $this->_total;
        }
    }
    
    // Volodya
	function getPropertyTenants($prop_id)
	{
		$db = JFactory::getDbo();
		
        $query = $db->getQuery(true);
        $query->select('*')
            ->from('#__iproperty_tenants')
            ->where('prop_id = '.$prop_id);

        $db->setQuery($query);
        $result = $db->loadObjectList();
        
		return $result;
	}
	

    function getProperty($limitstart = 0, $limit = null, $debug = null)
    {
    	
        switch($this->get('type'))
        {
        	
            case 'properties':
            case 'property':
            case 'googlemap_search':
            
                $query = ipropertyHelperQuery::buildPropertiesQuery($this->_where, $debug);
            break;
            
            case 'advsearch':
                $query = ipropertyHelperQuery::buildAdvPropertiesQuery($this->_where, $debug);
            break;

            case 'openhouses':
                $query = ipropertyHelperQuery::buildOpenhouseQuery($this->_where, $debug);
            break;
        
            case 'ipuser':
                $query = ipropertyHelperQuery::buildIPUserPropertiesQuery($this->_where, $debug);
            break;

            default:
                $query = ipropertyHelperQuery::buildPropertiesQuery($this->_where, $debug);
                
            break;

        }
        
        // set total rows for pagination
        $this->_db->setQuery($query);
        $this->_db->query();
        $this->setTotal($this->_db->getNumRows());
        
        // begin outputting objects
        $settings    = ipropertyAdmin::config();
        $config      = JFactory::getConfig();
        $tzoffset    = $config->getValue('config.offset');
        $hide_round  = 3;
        
        // set query for displayed results
        $this->_db->setQuery($query, $limitstart, $limit);
        $p  = $this->_db->loadObjectList();
echo mysql_error();
        if( count($p) ){
            switch($this->get('type'))
            {
                case 'advsearch':
                    for($i = 0; $i < count($p); $i++) {
                        # Get avialable categories for listing
                        $available_cats             = ipropertyHTML::getAvailableCats($p[$i]->id);
                        
                        $p[$i]->street_address      = ipropertyHTML::getStreetAddress($settings, $p[$i]->title, $p[$i]->street_num, $p[$i]->street, $p[$i]->street2, $p[$i]->apt, $p[$i]->hide_address);
                        $p[$i]->street_address2  = ipropertyHTML::getStreetAddress2($settings, $p[$i]->title, $p[$i]->street_num, $p[$i]->street, $p[$i]->street2, $p[$i]->apt, $p[$i]->hide_address);
                        $p[$i]->short_description   = ($p[$i]->short_description) ? $p[$i]->short_description : $p[$i]->description;
                        $p[$i]->baths               = (!$settings->baths_fraction) ? round($p[$i]->baths) : $p[$i]->baths; //round to integer if admin setting to show no fractions
                        $p[$i]->lat_pos             = ($p[$i]->hide_address) ? round($p[$i]->latitude, $hide_round) : $p[$i]->latitude;
                        $p[$i]->long_pos            = ($p[$i]->hide_address) ? round($p[$i]->longitude, $hide_round) : $p[$i]->longitude;

                        # Get the thumbnail
                        $p[$i]->thumb               = ipropertyHTML::getThumbnail($p[$i]->id, '', '', '', '', '', true, false);
                        
                        # Get category icons                        
                        $p[$i]->caticons[]          = array();                        
                        if($available_cats){
                            foreach( $available_cats as $c ){
                                $p[$i]->caticons[]  = ipropertyHTML::getCatIcon($c, 20);
                            }
                        }

                        # Format Price and SQft output
                        $p[$i]->formattedprice      = ipropertyHTML::getFormattedPrice($p[$i]->price, $p[$i]->stype_freq, false, $p[$i]->call_for_price);
                        $p[$i]->formattedsqft       = number_format($p[$i]->sqft);

                        # Get banner display
                        $new                        = ipropertyHTML::isNew($p[$i]->created, $settings->new_days);
                        $updated                    = ipropertyHTML::isNew($p[$i]->modified, $settings->updated_days);
                        $p[$i]->banner              = ipropertyHTML::displayBanners($p[$i]->stype, $new, JURI::root(true), $settings, $updated);

                        //get sef url for use in js                       
                        //$first_cat                  = $available_cats[0];
                        //$p[$i]->proplink            = JRoute::_(ipropertyHelperRoute::getPropertyRoute($p[$i]->id, $first_cat));
                        $p[$i]->proplink            = JRoute::_(ipropertyHelperRoute::getPropertyRoute($p[$i]->id.':'.$p[$i]->prop_alias));
                        $p[$i]->tenants = $this->getPropertyTenants($p[$i]->id);
                    }
                break;
                
                case 'ipuser':
                    for($i = 0; $i < count($p); $i++){
                        $p[$i]->street_address      = ipropertyHTML::getStreetAddress($settings, '', $p[$i]->street_num, $p[$i]->street, $p[$i]->street2);
                        $p[$i]->street_address2  = ipropertyHTML::getStreetAddress2($settings, $p[$i]->title, $p[$i]->street_num, $p[$i]->street, $p[$i]->street2, $p[$i]->apt, $p[$i]->hide_address);
                        
                        # Get the thumbnail
                        $p[$i]->thumb               = ipropertyHTML::getThumbnail($p[$i]->id, '', '', $settings->thumbwidth);
                        # We don't want the nopic image - only useful images that have been uploaded
                        if(strpos($p[$i]->thumb, 'nopic.png')) $p[$i]->thumb = '';
                    }
                break;
				
                case 'googlemap_search':
                	
            		for($i = 0; $i < count($p); $i++) {
                        # Get avialable categories for listing
                        $available_cats             = ipropertyHTML::getAvailableCats($p[$i]->id);
                        
                        $p[$i]->street_address      = ipropertyHTML::getStreetAddress($settings, $p[$i]->title, $p[$i]->street_num, $p[$i]->street, $p[$i]->street2, $p[$i]->apt, $p[$i]->hide_address);
                        $p[$i]->street_address2  = ipropertyHTML::getStreetAddress2($settings, $p[$i]->title, $p[$i]->street_num, $p[$i]->street, $p[$i]->street2, $p[$i]->apt, $p[$i]->hide_address);
                        $p[$i]->lat_pos             = ($p[$i]->hide_address) ? round($p[$i]->latitude, $hide_round) : $p[$i]->latitude;
                        $p[$i]->long_pos            = ($p[$i]->hide_address) ? round($p[$i]->longitude, $hide_round) : $p[$i]->longitude;

                        # Get the thumbnail
                        $p[$i]->thumb               = ipropertyHTML::getThumbnail($p[$i]->id, '', '', '', '', '', true, false);
                        
                        # Format Price and SQft output
                        $p[$i]->formattedprice      = ipropertyHTML::getFormattedPrice($p[$i]->price, $p[$i]->stype_freq, false, $p[$i]->call_for_price);
                        $p[$i]->formattedsqft       = number_format($p[$i]->sqft);

                        # Get banner display
                        $new                        = ipropertyHTML::isNew($p[$i]->created, $settings->new_days);
                        $updated                    = ipropertyHTML::isNew($p[$i]->modified, $settings->updated_days);
                        $p[$i]->banner              = ipropertyHTML::displayBanners($p[$i]->stype, $new, JURI::root(true), $settings, $updated);

                        //get sef url for use in js                       
                        //$first_cat                  = $available_cats[0];
                        //$p[$i]->proplink            = JRoute::_(ipropertyHelperRoute::getPropertyRoute($p[$i]->id, $first_cat));
                        $p[$i]->proplink            = JRoute::_(ipropertyHelperRoute::getPropertyRoute($p[$i]->id.':'.$p[$i]->prop_alias));
                        
                        $p[$i]->state_code = ipropertyHTML::getStateCode($p[$i]->locstate);
                        
            			# Get category icons                        
                        $p[$i]->caticons[]          = array();                        
                        if($available_cats){
                            foreach( $available_cats as $c ){
                                $p[$i]->caticons[]  = ipropertyHTML::getCatIcon($c, 20);
                            }
                        }
                    }
                	
                break;
                case 'properties':
                case 'property':
                case 'openhouses':
                default:
                    for($i = 0; $i < count($p); $i++){
                        $p[$i]->available       = ($p[$i]->available && $p[$i]->available != '0000-00-00') ? $p[$i]->available : '';
                        $p[$i]->street_address  = ipropertyHTML::getStreetAddress($settings, $p[$i]->title, $p[$i]->street_num, $p[$i]->street, $p[$i]->street2, $p[$i]->apt, $p[$i]->hide_address);
                        $p[$i]->street_address2  = ipropertyHTML::getStreetAddress2($settings, $p[$i]->title, $p[$i]->street_num, $p[$i]->street, $p[$i]->street2, $p[$i]->apt, $p[$i]->hide_address);
                        
                        $p[$i]->short_description   = ($p[$i]->short_description) ? $p[$i]->short_description : strip_tags($p[$i]->description);
                        $p[$i]->baths           = (!$settings->baths_fraction) ? round($p[$i]->baths) : $p[$i]->baths; //round to integer if admin setting to show no fractions
                        $p[$i]->lat_pos         = ($p[$i]->hide_address) ? round($p[$i]->latitude, $hide_round) : $p[$i]->latitude;
                        $p[$i]->long_pos        = ($p[$i]->hide_address) ? round($p[$i]->longitude, $hide_round) : $p[$i]->longitude;

                        # Get the thumbnail
                        $p[$i]->thumb           = ipropertyHTML::getThumbnail($p[$i]->id, '', '', $settings->thumbwidth);

                        # Format Price and SQft output
                        $p[$i]->formattedprice  = ipropertyHTML::getFormattedPrice($p[$i]->price, $p[$i]->stype_freq, false, $p[$i]->call_for_price, $p[$i]->price2);
                        $p[$i]->formattedsqft   = number_format($p[$i]->sqft) . ' sq. ft.';
                        
                        # Check if new or updated
                        $p[$i]->new        = ipropertyHTML::isNew($p[$i]->created, $settings->new_days);
                        $p[$i]->updated    = ipropertyHTML::isNew($p[$i]->modified, $settings->updated_days);

                        # Get last modified date if available
                        $p[$i]->last_updated    = ($p[$i]->modified != '0000-00-00 00:00:00') ? JHTML::_('date', htmlspecialchars($p[$i]->modified),JText::_('DATE_FORMAT_LC2'), $tzoffset) : '';                        

                        // get property link
                        $p[$i]->proplink            = JRoute::_(ipropertyHelperRoute::getPropertyRoute($p[$i]->id.':'.$p[$i]->prop_alias));
                        $p[$i]->tenants = $this->getPropertyTenants($p[$i]->id);
                        
                    }
                break;
            }
        }

        return $p;
    }
    
    function getChildren($id)
    {
        $db     = JFactory::getDbo();
        $user   = JFactory::getUser();
        $groups = $user->getAuthorisedViewLevels();
        
        // Filter by start and end dates.
        $nullDate   = $db->Quote($db->getNullDate());
        $date       = JFactory::getDate();
        $nowDate    = $db->Quote($date->toSql());
        
        $query = $db->getQuery(true);
        $query->select('*')
                ->from('#__iproperty_categories')
                ->where('(publish_up = '.$nullDate.' OR publish_up <= '.$nowDate.')')
                ->where('(publish_down = '.$nullDate.' OR publish_down >= '.$nowDate.')')
                ->where('state = 1');
        if(is_numeric($id)){
            $query->where('parent = '.(int)$id);
        }
        if(is_array($groups) && !empty($groups)){
            $query->where('access IN ('.implode(",", $groups).')');
        }
        $query->order('ordering ASC');
        
        $db->setQuery($query);
        return $db->loadObjectList();
    }

    function countObjects($cat = "")
    {
        $db = JFactory::getDBO();
        $subcat_count = ipropertyHelperProperty::getChildren($cat);
        if( $subcat_count ){
            $child_array = array();
            foreach( $subcat_count as $c ){
                $child_array[] = $c->id;
            }
            $child_array = implode(',', $child_array);
            $where = 'pm.cat_id IN (' . (int)$cat . ',' . $child_array . ')';
        }else{
            $where = 'pm.cat_id = ' . (int)$cat;
        }

        $query = 'SELECT COUNT(pm.id) FROM #__iproperty_propmid pm'
                .' JOIN #__iproperty p ON pm.prop_id = p.id'
                .' WHERE '.$where.' and p.state = 1';

        $db->setQuery($query);
        return $db->loadResult();
    }
}
?>