<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class IpropertyHelperQuery extends JObject
{
    var $_sort  = null;
    var $_order = null;
    var $_db    = null;

    function setOrderBy($_sort, $_order)
    {
        $this->_sort = $_sort;
        $this->_order = $_order;
    }

    function getOrderBy()
    {
        if(!isset($this->_sort) || !isset($this->_order)) {
            $this->_sort = 'p.street';
            $this->_order = 'ASC';
        }
        return ' ORDER BY ' . $this->_sort . ' ' . $this->_order;
    }
    
function buildPropertiesQuery( $where, $debug = null )
    {
        $user       = JFactory::getUser();
        $groups     = $user->getAuthorisedViewLevels();

        // Filter by start and end dates.
        $nullDate   = $this->_db->Quote($this->_db->getNullDate());
        $date       = JFactory::getDate();
        $nowDate    = $this->_db->Quote($date->toSql());

        // parse where statement and pull out non-prop table items
        $searchterms = array();
        if(!empty($where)){
            foreach ($where as $k => $w){
                $parts = explode('=', $w);
                if ( stripos($w, 'p.') === false ) {
                    $searchterms[trim($parts[0])] = trim($parts[1]);
                    unset($where[$k]);
                }
            }
        }
		
        // first builing query to filer properties by available space
        $property_space = JRequest::getString('property_space', '');
        $query_property = '#__iproperty';
        
		$query_tenants = $this->_db->getQuery(true);
		$query_tenants->select('*')
			->from('#__iproperty_tenants');
			//->where('available=1');
		
		$query_spaces = $this->_db->getQuery(true);
		$query_spaces->select('s.*, st.id as tenant_id')
			->from('#__iproperty_spaces AS s LEFT JOIN ('.$query_tenants.') AS st ON (s.id = st.space_id)');
		
		if(!empty($property_space))
	     {
	       	// filtering properties by space
	       	
	        $property_space_arr = explode('_', $property_space);
	        $start_space = $property_space_arr[0];
	        $end_space = $property_space_arr[1];
	        	
			$query_s_available = $this->_db->getQuery(true);
			$query_s_available->select('s2.prop_id, COUNT(s2.prop_id) as avail_spaces, 100 as count_spaces')
				->from('('.$query_spaces->__toString().') as s2')
				->where('s2.tenant_id IS NULL')
				->where('s2.space_sqft >= '.$start_space)
				->where('s2.space_sqft <= '.$end_space)
				->group('s2.prop_id');
			
			
	        $query_property = $this->_db->getQuery(true);
	        $query_property->select('p.*, s_avail.avail_spaces, s_avail.count_spaces')
	        	->from('#__iproperty AS p')	
	        	->from('('.$query_s_available.') AS s_avail')
	        	->where('p.id = s_avail.prop_id');
	    }
	    else
	    {
	    	// showing all properties with space info
	    	
			$query_s_available = $this->_db->getQuery(true);
			$query_s_available->select('s2.prop_id, SUM(IF(s2.tenant_id IS NULL, 1, 0)) as avail_spaces, SUM(1) as count_spaces ')
				->from('('.$query_spaces->__toString().') as s2')
				->group('s2.prop_id');
			
        	$query_property = $this->_db->getQuery(true);
        	$query_property->select('p.*, IFNULL(s_avail.avail_spaces, 0) as avail_spaces, IFNULL(s_avail.count_spaces, 0) as count_spaces')
	        	->from('#__iproperty AS p LEFT JOIN ('.$query_s_available.') AS s_avail ON (p.id = s_avail.prop_id)');
	        
	    }
	    
        
        $query = $this->_db->getQuery(true);
        //$query->select('p.*, p.id AS id, p.title AS title, p.street_num, p.street, p.street2, p.description as description, p.created as fcreated, p.alias as prop_alias')
        //    ->from('#__iproperty AS p');
        // Volodya
        //$query_property query results property info + avail_spaces - count of available spaces
	    
       	$query->select('p.*, p.id AS id, p.title AS title, p.street_num, p.street, p.street2, p.description as description, p.created as fcreated, p.alias as prop_alias ')
            ->from('('.$query_property.') AS p ');
        
        // if we have a cat ID create statement
        $cat_search = (array_key_exists('pm.cat_id', $searchterms)) ? ' AND pm.cat_id = '.$this->_db->Quote($searchterms['pm.cat_id']) : '';
        $subcat_search = (array_key_exists('(pm.cat_id', $searchterms)) ? ' AND (pm.cat_id = '.$searchterms['(pm.cat_id'] : '';

        // get list of props in published cat
        $query->where('p.id IN (SELECT pm.prop_id FROM #__iproperty_propmid pm WHERE pm.cat_id IN (SELECT id FROM #__iproperty_categories c WHERE c.state = 1 AND (c.publish_up = '.$nullDate.' OR c.publish_up <= '.$nowDate.') AND (c.publish_down = '.$nullDate.' OR c.publish_down >= '.$nowDate.') AND c.access IN ('.implode(",", $groups).'))'.$cat_search.$subcat_search.')');

        // if we have an agent ID search for it
        if(array_key_exists('am.agent_id', $searchterms)){
            $query->where('p.id IN (SELECT am.prop_id FROM #__iproperty_agentmid am WHERE am.agent_id = '.$this->_db->Quote($searchterms['am.agent_id']).')');
        }

        $query->where('(p.publish_up = '.$nullDate.' OR p.publish_up <= '.$nowDate.')')
            ->where('(p.publish_down = '.$nullDate.' OR p.publish_down >= '.$nowDate.')')
            ->where('p.state = 1')
            ->where('p.approved = 1');

        if(is_array($groups) && !empty($groups)){
            $query->where('p.access IN ('.implode(",", $groups).')');
        }
        if( !empty($where) ) {
            if(is_array($where)) {
                foreach($where as $w){
                    $query->where($w);
                }
            } else {
                $query->where($where);
            }
        }
        $query->group('p.id');
        /*
        if(!isset($this->_sort) || !isset($this->_order)) {
        	
            $query->order('p.street ASC');
        } else {
        	
            $query->order($this->_sort.' '.$this->_order);
        }
		*/
        //$query->order('p.id ASC');
        $query->order('p.locstate ASC');
        $query->order('p.street ASC');
		
        if($debug == 1) echo $query . '<br /><br />';
        return $query;
    }
    
	/* Volodya
    function buildPropertiesQuery( $where, $debug = null )
    {
        $user       = JFactory::getUser();
        $groups     = $user->getAuthorisedViewLevels();

        // Filter by start and end dates.
        $nullDate   = $this->_db->Quote($this->_db->getNullDate());
        $date       = JFactory::getDate();
        $nowDate    = $this->_db->Quote($date->toSql());

        // parse where statement and pull out non-prop table items
        $searchterms = array();
        if(!empty($where)){
            foreach ($where as $k => $w){
                $parts = explode('=', $w);
                if ( stripos($w, 'p.') === false ) {
                    $searchterms[trim($parts[0])] = trim($parts[1]);
                    unset($where[$k]);
                }
            }
        }

        $query = $this->_db->getQuery(true);
        //$query->select('p.*, p.id AS id, p.title AS title, p.street_num, p.street, p.street2, p.description as description, p.created as fcreated, p.alias as prop_alias')
        //    ->from('#__iproperty AS p');
        // Volodya
       	$query->select('p.*, p.id AS id, p.title AS title, p.street_num, p.street, p.street2, p.description as description, p.created as fcreated, p.alias as prop_alias ')
            ->from('#__iproperty AS p ');
        
        // if we have a cat ID create statement
        $cat_search = (array_key_exists('pm.cat_id', $searchterms)) ? ' AND pm.cat_id = '.$this->_db->Quote($searchterms['pm.cat_id']) : '';
        $subcat_search = (array_key_exists('(pm.cat_id', $searchterms)) ? ' AND (pm.cat_id = '.$searchterms['(pm.cat_id'] : '';

        // get list of props in published cat
        $query->where('p.id IN (SELECT pm.prop_id FROM #__iproperty_propmid pm WHERE pm.cat_id IN (SELECT id FROM #__iproperty_categories c WHERE c.state = 1 AND (c.publish_up = '.$nullDate.' OR c.publish_up <= '.$nowDate.') AND (c.publish_down = '.$nullDate.' OR c.publish_down >= '.$nowDate.') AND c.access IN ('.implode(",", $groups).'))'.$cat_search.$subcat_search.')');

        // if we have an agent ID search for it
        if(array_key_exists('am.agent_id', $searchterms)){
            $query->where('p.id IN (SELECT am.prop_id FROM #__iproperty_agentmid am WHERE am.agent_id = '.$this->_db->Quote($searchterms['am.agent_id']).')');
        }

        $query->where('(p.publish_up = '.$nullDate.' OR p.publish_up <= '.$nowDate.')')
            ->where('(p.publish_down = '.$nullDate.' OR p.publish_down >= '.$nowDate.')')
            ->where('p.state = 1')
            ->where('p.approved = 1');

        if(is_array($groups) && !empty($groups)){
            $query->where('p.access IN ('.implode(",", $groups).')');
        }
        if( !empty($where) ) {
            if(is_array($where)) {
                foreach($where as $w){
                    $query->where($w);
                }
            } else {
                $query->where($where);
            }
        }
        $query->group('p.id');
        if(!isset($this->_sort) || !isset($this->_order)) {
            $query->order('p.street ASC');
        } else {
            $query->order($this->_sort.' '.$this->_order);
        }

        if($debug == 1) echo $query . '<br /><br />';
        return $query;
    }
    */

    function buildIPUserPropertiesQuery( $where, $debug = null )
    {
        $user       = JFactory::getUser();
        $groups     = $user->getAuthorisedViewLevels();

        // Filter by start and end dates.
        $nullDate   = $this->_db->Quote($this->_db->getNullDate());
        $date       = JFactory::getDate();
        $nowDate    = $this->_db->Quote($date->toSql());

        $query = $this->_db->getQuery(true);
        $query->select('p.mls_id, p.id AS id, p.price, p.title AS title, p.show_map, p.street_num, p.street, p.street2, p.city, p.locstate, p.state, p.featured, p.approved, p.created as fcreated, p.alias as alias')
            ->from('#__iproperty as p')
            ->join('', '#__iproperty_agentmid as am ON am.prop_id = p.id');
        if(is_array($groups) && !empty($groups)){
            $query->where('p.access IN ('.implode(",", $groups).')');
        }
        if( !empty($where) ) {
            if(is_array($where)) {
                foreach($where as $w){
                    $query->where($w);
                }
            } else {
                $query->where($where);
            }
        }
        $query->group('p.id');
        if(!isset($this->_sort) || !isset($this->_order)) {
            $query->order('p.id ASC');
        } else {
            $query->order($this->_sort.' '.$this->_order);
        }

        if($debug == 1) echo $query . '<br /><br />';
        return $query;
    }

    function buildAdvPropertiesQuery( $where, $debug = null )
    {
        $user       = JFactory::getUser();
        $groups     = $user->getAuthorisedViewLevels();

        // Filter by start and end dates.
        $nullDate   = $this->_db->Quote($this->_db->getNullDate());
        $date       = JFactory::getDate();
        $nowDate    = $this->_db->Quote($date->toSql());
        
        // parse where statement and pull out non-prop table items
        $searchterms = array();
        foreach ($where as $k => $w){
            $parts = explode('=', $w);
            if ( stripos($w, 'p.') === false ) {
                $searchterms[trim($parts[0])] = trim($parts[1]);
                unset($where[$k]);
            }
        }

        $query = $this->_db->getQuery(true);
        $query->select('p.id AS id, p.title AS title, p.show_map, p.street_num, p.street, p.street2, p.apt, p.city, p.short_description as short_description, p.mls_id, p.stype_freq, p.latitude, p.longitude, p.price, p.beds, p.baths, p.sqft, p.call_for_price, p.created, p.modified, p.stype, p.hide_address, LEFT(p.description,300) as description, p.alias as prop_alias')
            ->from('#__iproperty AS p');

        // if we have a cat ID create statement
        $cat_search = (array_key_exists('pm.cat_id', $searchterms)) ? ' AND pm.cat_id IN ('.$searchterms['pm.cat_id'].')' : '';
        $subcat_search = (array_key_exists('(pm.cat_id', $searchterms)) ? ' AND (pm.cat_id = '.$searchterms['(pm.cat_id'] : '';

        // get list of props in published cat
        $query->where('p.id IN (SELECT pm.prop_id FROM #__iproperty_propmid pm WHERE pm.cat_id IN (SELECT id FROM #__iproperty_categories c WHERE c.state = 1 AND (c.publish_up = '.$nullDate.' OR c.publish_up <= '.$nowDate.') AND (c.publish_down = '.$nullDate.' OR c.publish_down >= '.$nowDate.') AND c.access IN ('.implode(",", $groups).'))'.$cat_search.$subcat_search.')');

        // if we have an agent ID search for it
        if(array_key_exists('am.agent_id', $searchterms)){
            $query->where('p.id IN (SELECT am.prop_id FROM #__iproperty_agentmid am WHERE am.agent_id = '.$this->_db->Quote($searchterms['am.agent_id']).')');
        }

        $query->where('(p.publish_up = '.$nullDate.' OR p.publish_up <= '.$nowDate.')')
            ->where('(p.publish_down = '.$nullDate.' OR p.publish_down >= '.$nowDate.')')
            ->where('p.state = 1')
            ->where('p.approved = 1');

        if(is_array($groups) && !empty($groups)){
            $query->where('p.access IN ('.implode(",", $groups).')');
        }
        if( !empty($where) ) {
            if(is_array($where)) {
                foreach($where as $w){
                    $query->where($w);
                }
            } else {
                $query->where($where);
            }
        }
        $query->group('p.id');
        if(!isset($this->_sort) || !isset($this->_order)) {
            $query->order('p.street ASC');
        } else {
            $query->order($this->_sort.' '.$this->_order);
        }

        if($debug == 1) echo $query . '<br /><br />';
        return $query;
    }

    function buildOpenhouseQuery( $where, $debug = null )
    {
        $user       = JFactory::getUser();
        $groups     = $user->getAuthorisedViewLevels();
        
        $config     =& JFactory::getConfig();
		$offset     = $config->getValue('config.offset');

        // Filter by start and end dates.
        $nullDate   = $this->_db->Quote($this->_db->getNullDate());
        $date       = JFactory::getDate('now', $offset);
        $nowDate    = $this->_db->Quote($date->toSql(true));

        $query = $this->_db->getQuery(true);
        $query->select('p.*, p.id AS id, p.title AS title, p.street_num, p.street, p.street2, p.description as description, oh.name as ohname, oh.openhouse_start as ohstart, oh.openhouse_end as ohend, oh.comments as comments, p.created as fcreated, oh.openhouse_start as startdate, oh.openhouse_end as enddate')
            ->from('#__iproperty AS p')
            ->leftJoin('#__iproperty_openhouses as oh ON oh.prop_id = p.id')
            ->leftJoin('#__iproperty_propmid as pm on pm.prop_id = p.id')
            ->leftJoin('#__iproperty_agentmid as am on am.prop_id = p.id')
            ->leftJoin('#__iproperty_categories as c on c.id = pm.cat_id')
            ->leftJoin('#__iproperty_companies as co on co.id = p.listing_office')
            ->leftJoin('#__iproperty_agents as a on a.id = am.agent_id')
            ->where('(p.publish_up = '.$nullDate.' OR p.publish_up <= '.$nowDate.')')
            ->where('(p.publish_down = '.$nullDate.' OR p.publish_down >= '.$nowDate.')')
            ->where('(c.publish_up = '.$nullDate.' OR c.publish_up <= '.$nowDate.')')
            ->where('(c.publish_down = '.$nullDate.' OR c.publish_down >= '.$nowDate.')')
            ->where('p.state = 1 AND c.state = 1 AND a.state = 1 AND co.state = 1 AND oh.state = 1')
            ->where('oh.openhouse_end >= '.$nowDate)
            ->where('p.approved = 1');
        if(is_array($groups) && !empty($groups)){
            $query->where('p.access IN ('.implode(",", $groups).')')
                ->where('c.access IN ('.implode(",", $groups).')');
        }
        if( !empty($where) ) {
            if(is_array($where)) {
                foreach($where as $w){
                    $query->where($w);
                }
            } else {
                $query->where($where);
            }
        }
        $query->group('p.id, oh.openhouse_end');
        if(!isset($this->_sort) || !isset($this->_order)) {
            $query->order('oh.openhouse_end ASC');
        } else {
            $query->order($this->_sort.' '.$this->_order);
        }

        if($debug == 1) echo $query . '<br /><br />';
        return $query;
    }

    function buildAgentsQuery( $where, $debug = null )
    {
        $query = $this->_db->getQuery(true);

        $query->select('a.*, c.id AS companyid, c.name AS companyname, CONCAT_WS(" ",fname,lname) AS name, c.alias as co_alias')
            ->from('#__iproperty_agents as a')
            ->leftJoin('#__iproperty_companies as c on c.id = a.company')
            ->where('a.state = 1 AND c.state = 1');
        if( !empty($where) ) {
            if(is_array($where)) {
                foreach($where as $w){
                    $query->where($w);
                }
            } else {
                $query->where($where);
            }
        }
        $query->group('a.id');
        if(!isset($this->_sort) || !isset($this->_order)) {
            $query->order('a.ordering ASC');
        } else {
            $query->order($this->_sort.' '.$this->_order);
        }

        if($debug == 1) echo $query . '<br /><br />';
        return $query;
    }

    function buildIPUserAgentsQuery( $where, $debug = null )
    {
        $query = $this->_db->getQuery(true);

        $query->select('a.*, c.id AS companyid, c.name AS companyname, CONCAT_WS(" ",fname,lname) AS name, a.alias as alias')
            ->from('#__iproperty_agents as a')
            ->leftJoin('#__iproperty_companies as c on c.id = a.company');
        if( !empty($where) ) {
            if(is_array($where)) {
                foreach($where as $w){
                    $query->where($w);
                }
            } else {
                $query->where($where);
            }
        }
        $query->group('a.id');
        if(!isset($this->_sort) || !isset($this->_order)) {
            $query->order('a.ordering ASC');
        } else {
            $query->order($this->_sort.' '.$this->_order);
        }

        if($debug == 1) echo $query . '<br /><br />';
        return $query;
    }

    function incrementPropertyHits($propid = '')
    {
        if($propid){
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->update('#__iproperty')
                ->set('hits=(hits+1)')
                ->where('id = '.(int)$propid);

            return $query;
        }
    }

    function getCategories($parent = '', $order = 'ordering ASC')
    {
        $db         = JFactory::getDbo();
        $user       = JFactory::getUser();
        $groups     = $user->getAuthorisedViewLevels();

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
        if(is_numeric($parent)){
            $query->where('parent = '.(int)$parent);
        }
        $query->order($order);

        return $query;
    }

    function getSavedProperties( $user_id )
    {
        $db         = JFactory::getDbo();

        // Filter by start and end dates.
        $nullDate   = $db->Quote($db->getNullDate());
        $date       = JFactory::getDate();
        $nowDate    = $db->Quote($date->toSql());

        $query = $db->getQuery(true);
        $query->select('*, p.title AS title, p.street AS street, s.id AS id, s.timestamp AS created, p.id as prop_id, s.id as id, p.alias as alias')
            ->from('#__iproperty_saved as s')
            ->leftJoin('#__iproperty as p on p.id = s.prop_id')
            ->where('s.user_id = '.(int)$user_id)
            ->where('s.active = 1 AND s.type = 0')
            ->where('(p.publish_up = '.$nullDate.' OR p.publish_up <= '.$nowDate.')')
            ->where('(p.publish_down = '.$nullDate.' OR p.publish_down >= '.$nowDate.')')
            ->order('timestamp DESC');

        return $query;
    }

    function getSavedSearches( $user_id )
    {
        $db         = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->select('*, s.notes AS title, s.id AS id, s.timestamp AS created')
            ->from('#__iproperty_saved as s')
            ->where('s.user_id = '.(int)$user_id)
            ->where('s.active = 1 AND s.type != 0')
            ->order('timestamp DESC');

        return $query;
    }

    function deleteSavedProperty( $id, $user_id )
    {
        $db         = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->update('#__iproperty_saved')
            ->set('active = 0')
            ->where('id = '.(int)$id)
            ->where('user_id = '.(int)$user_id);

        return $query;
    }

    function saveProperty( $id, $user_id, $notes = '', $email_update = 1 )
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->insert('#__iproperty_saved')
                ->columns('user_id, prop_id, notes, email_update, active')
                ->values((int)$user_id.', '.(int)$id.', '.$db->Quote($notes).', '.(int)$email_update.', 1');
        return $query;
    }

    function saveSearch( $searchstring, $user_id, $notes = '', $email_update = 1 )
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->insert('#__iproperty_saved')
                ->columns('user_id, notes, search_string, email_update, active, type')
                ->values((int)$user_id.', '.$db->Quote($notes).', '.$db->Quote($searchstring).', '.(int)$email_update.', 1, 1');
        return $query;
    }

    function buildAgent($agent_id)
    {
        $db = JFactory::getDBO();

        $query = $db->getQuery(true);
        $query->select('a.*, c.id AS companyid, c.name AS companyname, CONCAT_WS(" ",fname,lname) AS name, a.alias as alias, c.alias as co_alias')
            ->from('#__iproperty_agents as a')
            ->leftJoin('#__iproperty_companies as c on c.id = a.company')
            ->where('a.id = '.(int)$agent_id)
            ->where('a.state = 1');

        $db->setQuery($query, 0, 1);
        return $db->loadObject();
    }

    function buildCompany($co_id)
    {
        $db = JFactory::getDBO();

        $query = $db->getQuery(true);
        $query->select('*')
            ->from('#__iproperty_companies')
            ->where('id = '.(int)$co_id)
            ->where('state = 1');

        $db->setQuery($query, 0, 1);
        return $db->loadObject();
    }
}
?>
