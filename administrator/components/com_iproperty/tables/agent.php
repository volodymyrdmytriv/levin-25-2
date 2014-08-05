<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class IpropertyTableAgent extends JTable
{
	function __construct(&$_db)
	{
		parent::__construct('#__iproperty_agents', 'id', $_db);
	}

	function check()
	{
		jimport('joomla.filter.output');
        $ipauth = new IpropertyHelperAuth(array('msg'=>false));

		// Set name
		$this->fname = htmlspecialchars_decode($this->fname, ENT_QUOTES);
        $this->lname = htmlspecialchars_decode($this->lname, ENT_QUOTES);
        
        // Set alias
		$this->alias = JApplication::stringURLSafe($this->alias);
		if (empty($this->alias)) {
            $ptitle         = $this->fname.' '.$this->lname;
			$this->alias    = JApplication::stringURLSafe($ptitle);
		}

		// Set ordering
		if (empty($this->ordering)) {
			// Set ordering to last if ordering was 0
			$this->ordering = self::getNextOrder('`company`=' . $this->_db->Quote($this->company));
		}
        if(!$ipauth->canFeatureAgent($this->id, $this->featured)){
            unset($this->featured);
        }
        if(!$ipauth->canPublishAgent($this->id, $this->state)){
            unset($this->state);
        }

		return true;
	}

	public function bind($array, $ignore = array())
	{       
        if (isset($array['params']) && is_array($array['params'])) {
			$registry = new JRegistry();
			$registry->loadArray($array['params']);
			$array['params'] = (string)$registry;
		}       
        
		return parent::bind($array, $ignore);
	}

	public function store($updateNulls = false)
	{
		if (empty($this->id)){
			parent::store($updateNulls);
		}
		else
		{
			// Get the old row
			$oldrow = JTable::getInstance('Agent', 'IpropertyTable');
			if (!$oldrow->load($this->id) && $oldrow->getError()){
				$this->setError($oldrow->getError());
			}

			// Store the new row
			parent::store($updateNulls);

			// Need to reorder ?
			if ($oldrow->state >= 0){
				// Reorder the oldrow
				$this->reorder('`company`=' . $this->_db->Quote($this->company).' AND state>=0');
			}
		}
		return count($this->getErrors())==0;
	}

	public function publish($pks = null, $state = 1)
	{
		// Initialise variables.
		$k = $this->_tbl_key;       

		// Sanitize input.
		JArrayHelper::toInteger($pks);
		$state      = (int) $state;

		// If there are no primary keys set check to see if the instance key is set.
		if (empty($pks))
		{
			if ($this->$k) {
				$pks = array($this->$k);
			}
			// Nothing to set publishing state on, return false.
			else {
				$this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
				return false;
			}
		}

		// Get an instance of the table
		$table = JTable::getInstance('Agent','IpropertyTable');

		// For all keys
		foreach ($pks as $pk)
		{
            // Load the banner
            if(!$table->load($pk)){
                $this->setError($table->getError());
            }

            // Change the state
            $table->state = $state;

            // Check the row
            $table->check();

            // Store the row
            if (!$table->store()){
                $this->setError($table->getError());
            }
		}
		return count($this->getErrors())==0;
	}
    
    public function feature($pks = null, $state = 0)
	{
		// Initialise variables.
		$k = $this->_tbl_key;      

		// Sanitize input.
		JArrayHelper::toInteger($pks);
		$state      = (int) $state;

		// If there are no primary keys set check to see if the instance key is set.
		if (empty($pks))
		{
			if ($this->$k) {
				$pks = array($this->$k);
			}
			// Nothing to set publishing state on, return false.
			else {
				$this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
				return false;
			}
		}

		// Get an instance of the table
		$table = JTable::getInstance('Agent','IpropertyTable');

		// For all keys
		foreach ($pks as $pk)
		{
            // Load the banner
            if(!$table->load($pk)){
                $this->setError($table->getError());
            }

            // Change the state
            $table->featured = $state;

            // Check the row
            $table->check();

            // Store the row
            if (!$table->store()){
                $this->setError($table->getError());
            }
		}
		return count($this->getErrors())==0;
	}
    
    public function super($pks = null, $state = 1)
	{
		// Initialise variables.
		$k = $this->_tbl_key;      

		// Sanitize input.
		JArrayHelper::toInteger($pks);
		$state      = (int) $state;

		// If there are no primary keys set check to see if the instance key is set.
		if (empty($pks))
		{
			if ($this->$k) {
				$pks = array($this->$k);
			}
			// Nothing to set publishing state on, return false.
			else {
				$this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
				return false;
			}
		}

		// Get an instance of the table
		$table = JTable::getInstance('Agent','IpropertyTable');

		// For all keys
		foreach ($pks as $pk)
		{
            // Load the banner
            if(!$table->load($pk)){
                $this->setError($table->getError());
            }

            // Change the state
            $table->agent_type = $state;

            // Check the row
            $table->check();

            // Store the row
            if (!$table->store()){
                $this->setError($table->getError());
            }
		}
		return count($this->getErrors())==0;
	}
    
    public function delete($pks)
	{
        // Initialise variables.
		$k = $this->_tbl_key;      

		// Sanitize input.
		JArrayHelper::toInteger($pks);

		// If there are no primary keys set check to see if the instance key is set.
		if (empty($pks))
		{
			if ($this->$k) {
				$pks = array($this->$k);
			}
			// Nothing to set publishing state on, return false.
			else {
				$this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
				return false;
			}
		}

		try
		{			
			// delete from agents table
            $query = $this->_db->getQuery(true);
            $query->delete();
            $query->from('#__iproperty_agents');
            $query->where('id IN ('.implode(',', $pks).')');
            $this->_db->setQuery($query);
            
			// Check for a database error.
            if (!$this->_db->query()) {
				throw new Exception($this->_db->getErrorMsg());
			}
            
            // delete from agent mid table
            $query = $this->_db->getQuery(true);
            $query->delete();
            $query->from('#__iproperty_agentmid');
            $query->where('agent_id IN ('.implode(',', $pks).')');
            $this->_db->setQuery($query);

			// Check for a database error.
            if (!$this->_db->query()) {
				throw new Exception($this->_db->getErrorMsg());
			}
		}
		catch (Exception $e)
		{
			$this->setError($e->getMessage());
			return false;
		}
		return count($this->getErrors())==0;
	}
}
?>