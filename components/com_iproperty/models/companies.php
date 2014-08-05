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

class IpropertyModelCompanies extends JModel
{
	var $_data          = null;
    var $_total         = null;

    //search criteria
    var $_search        = null;
    var $_searchwhere   = null;
    var $_sort          = null;
    var $_order         = null;

	function __construct()
	{
		parent::__construct();

		$app        = JFactory::getApplication();
        $option     = JRequest::getCmd('option');
        
        $db             = JFactory::getDBO();
		$settings       = ipropertyAdmin::config();
		$perpage        = $settings->perpage;
        $currid         = JRequest::getInt('id', 0).':'.JRequest::getInt('Itemid', 0);

        // Get the pagination request variables
        $this->setState('limit', $perpage);
        $this->setState('limitstart', JRequest::getVar('limitstart', 0, '', 'int'));
        $this->setState('limitstart', ($this->getState('limit') != 0 ? (floor($this->getState('limitstart') / $this->getState('limit')) * $this->getState('limit')) : 0));

        $this->_sort		= $app->getUserStateFromRequest( $option.'.companies.filter_order'.$currid, 'filter_order', $settings->default_c_sort, 'cmd' );
		$this->_order	    = $app->getUserStateFromRequest( $option.'.companies.filter_order_dir'.$currid, 'filter_order_dir', $settings->default_c_order, 'word' );
        $search_string      = $app->getUserStateFromRequest( $option.'.companies.search'.$currid, 'search', '', 'string' );
        $this->_search      = urldecode($search_string);
        $this->_search      = JString::strtolower($this->_search);
		if( $this->_search ){
			$this->_searchwhere = 'LOWER(name) LIKE '.$db->Quote( '%'.$db->getEscaped( $this->_search, true ).'%', false );
		}
    }

	function getData()
	{
	    $app        = JFactory::getApplication();
        $option     = JRequest::getCmd('option');
        
		if (empty($this->_data))
		{
            $where = $this->_searchwhere;
            
            $query = $this->_db->getQuery(true);
            $query->select('id')
                    ->from('#__iproperty_companies')
                    ->where('state = 1');
                    if($where){
                        $query->where($where);
                    }
                    $query->order($this->_sort.' '.$this->_order);

            $this->_db->setQuery($query, $this->getState('limitstart'), $this->getState('limit'));
			$this->_data = $this->_db->loadObjectList();            
		}
		return $this->_data;
	}

    function getTotal()
    {
        $app  = JFactory::getApplication();
        $option     = JRequest::getCmd('option');
        
		if (empty($this->_total))
		{
            $where = $this->_searchwhere;
            
            $query = $this->_db->getQuery(true);
            $query->select('count(id)')
                    ->from('#__iproperty_companies')
                    ->where('state = 1');
                    if($where){
                        $query->where($where);
                    }
            
            $this->_db->setQuery($query);
            $this->_total = $this->_db->loadResult();
        }
        return $this->_total;
    }

	function getPagination()
	{
        // Lets load the content if it doesn't already exist
        if (empty($this->_pagination))
        {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
        }
        return $this->_pagination;
	}

    function getFeatured()
	{
	    $app        = JFactory::getApplication();
        $option     = JRequest::getCmd('option');
        
		if (empty($this->_featured))
		{
            $settings   = ipropertyAdmin::config();
            $fperpage   = $settings->co_feat_num;
            $where      = $this->_searchwhere;
            
            $query = $this->_db->getQuery(true);
            $query->select('id')
                    ->from('#__iproperty_companies')
                    ->where('state = 1')
                    ->where('featured = 1');
                    if($where){
                        $query->where($where);
                    }
                    $query->order('RAND()');

            $this->_db->setQuery($query, 0, $fperpage);
			$this->_featured = $this->_db->loadObjectList();
		}
		return $this->_featured;
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