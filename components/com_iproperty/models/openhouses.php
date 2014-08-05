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

class IpropertyModelOpenhouses extends JModel
{
	var $_properties    = null;
    var $_where         = null;
	var $_total         = null;

	function __construct()
	{
		parent::__construct();

		$app        = JFactory::getApplication();
        $option     = JRequest::getCmd('option');

		$settings =  ipropertyAdmin::config();
		$perpage = $settings->perpage;

		if(JRequest::getVar('format') != 'feed'){
            // Get the pagination request variables
            $this->setState('limit', $perpage);
            $this->setState('limitstart', JRequest::getVar('limitstart', 0, '', 'int'));
            $this->setState('limitstart', ($this->getState('limit') != 0 ? (floor($this->getState('limitstart') / $this->getState('limit')) * $this->getState('limit')) : 0));
		}else{
            // if feed, want to display rss limit
            $this->setState( 'limit', $settings->rss );
            $this->setState( 'limitstart', 0 );
        }
	}

    function getProperties()
	{
	    $app        = JFactory::getApplication();
        $option     = JRequest::getCmd('option');
		$debug      = false;

		if (empty($this->_properties))
		{
			// Get the WHERE and ORDER BY clauses for the query
			$where		= $this->_buildContentWhere();
			$properties = new ipropertyHelperproperty($this->_db);
			$properties->setType('openhouses');
			$properties->setWhere( $where );
			$this->_properties = $properties->getProperty($this->getState('limitstart'),$this->getState('limit'), $debug);
			$this->_total = $properties->getTotal();
		}
		return $this->_properties;
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
        $where = array(); //empty for now until we add filters
		$this->_where = $where;

		return $this->_where;
	}
}

?>