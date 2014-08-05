<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class IpropertyHelperAgent extends JObject
{
	var $_db	= null;
	var $type	= null;
	var $_sort	= null;
	var $_order	= null;
	var $_id	= null;
	var $_where	= null;
    var $_total = null;
	
	function __construct(&$db)
	{
		$this->_db = $db;
	}
	
	function setType($type)
	{
		$this->type = $type;
	}
	
	function setId($id)
	{
		$this->_id = $id;
	}

	function setWhere($where)
	{
		$this->_where = $where;
	}
	
	function setOrderBy($sort, $order)
	{
		$this->_sort = $sort;
		$this->_order = $order;
	}
    
    function setTotal($total)
	{
		$this->_total = $total;
	}    
    
	function getTotal(){
		if ($this->_total){
			return $this->_total;
		}
	}  
	
	function getAgent($limitstart = 0, $limit = null, $debug = null)
	{
		switch($this->get('type'))
		{
			case 'agents':
				$query = ipropertyHelperQuery::buildAgentsQuery($this->_where, $debug);
            break;
				
			case 'agent':
				$query = ipropertyHelperQuery::buildAgentsQuery($this->_where, $debug);
			break;
        
            case 'ipuser':
				$query = ipropertyHelperQuery::buildIPUserAgentsQuery($this->_where, $debug);
			break;
				
			default:
				$query = ipropertyHelperQuery::buildAgentsQuery($this->_where, $debug);
            break;
				
		}
        
        // set total rows for pagination
        $this->_db->setQuery($query);
        $this->_db->query();
        $this->setTotal($this->_db->getNumRows());
        
		// set query for displayed results
        $this->_db->setQuery($query, $limitstart, $limit);
        $agents  = $this->_db->loadObjectList();
        
        return $agents;
	}     
}
?>