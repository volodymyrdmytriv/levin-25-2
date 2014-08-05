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

class IpropertyModelCompanyAgents extends JModel
{
	var $_data          = null;
	var $_id            = null;
	var $_where         = null;
	var $_total         = null;
    var $_agent         = null;
    var $_featured      = null;

    //search criteria
    var $_search        = null;
    var $_searchwhere   = null;
    var $_sort          = null;
    var $_order         = null;
	
	function __construct()
	{
		parent::__construct();
		
		$app  = JFactory::getApplication();
        $option     = JRequest::getCmd('option');
        
        $db = JFactory::getDBO();
		$settings =  ipropertyAdmin::config();
        $perpage = $settings->perpage;
		
        // Get the pagination request variables
        $this->setState('limit', $perpage);
        $this->setState('limitstart', JRequest::getVar('limitstart', 0, '', 'int'));
        $this->setState('limitstart', ($this->getState('limit') != 0 ? (floor($this->getState('limitstart') / $this->getState('limit')) * $this->getState('limit')) : 0));
		
		// Set id for company
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

		if (empty($this->_agents))
		{
			// Get the WHERE and ORDER BY clauses for the query
			$where		= $this->_buildContentWhere();

			$this->_agent = new ipropertyHelperagent($this->_db);
			$this->_agent->setType('agents');
			$this->_agent->setWhere( $where );
			$this->_agent->setOrderBy( $this->_sort, $this->_order );
			$this->_agents  = $this->_agent->getAgent($this->getState('limitstart'),$this->getState('limit'), $debug);
            $this->_total   = $this->_agent->getTotal();
		}
		return $this->_agents;
	}

    function getFeatured()
	{
	    $app  = JFactory::getApplication();
        
		$settings = ipropertyAdmin::config();
		$fperpage = $settings->num_featured;
        $where    = $this->_where;
        $where[]  = 'a.featured = 1';
		
		$this->_featured = new ipropertyHelperagent($this->_db);
		$this->_featured->setType('agents');
        $this->_featured->setWhere( $where );
		$this->_featured->setOrderBy('RAND()', '');
		$this->_featured = $this->_featured->getAgent(0,$fperpage);

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

        $this->_sort		= $app->getUserStateFromRequest( $option.'.companyagents.filter_order'.$currid, 'filter_order', $settings->default_a_sort, 'cmd' );
		$this->_order	    = $app->getUserStateFromRequest( $option.'.companyagents.filter_order_dir'.$currid, 'filter_order_dir', $settings->default_a_order, 'word' );
        $search_string      = $app->getUserStateFromRequest( $option.'.companyagents.search'.$currid, 'search', '', 'string' );
        $this->_search      = urldecode($search_string);
        $this->_search      = JString::strtolower($this->_search);
		if( $this->_search ){
			$this->_searchwhere = array();
			$this->_searchwhere[] = 'LOWER(a.fname) LIKE '.$db->Quote( '%'.$db->getEscaped( $this->_search, true ).'%', false );
			$this->_searchwhere[] = 'LOWER(a.lname) LIKE '.$db->Quote( '%'.$db->getEscaped( $this->_search, true ).'%', false );
		}

        $where = array();
        $where[] = 'a.company = '.(int)$this->_id;
        
        if( $this->_searchwhere ) $where[] = "(".implode( ' OR ', $this->_searchwhere ).")";
		$this->_where = $where;

		return $this->_where;
	}

    function getCompany()
    {
        $this->_company = IpropertyHelperQuery::buildCompany($this->_id);
        return $this->_company;
    }

    function getSearch()
	{
		return $this->_search;
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