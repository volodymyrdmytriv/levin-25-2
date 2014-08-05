<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class IpropertyTableOpenhouse extends JTable
{
	function __construct(&$_db)
	{
		parent::__construct('#__iproperty_openhouses', 'id', $_db);
	}

	function check()
	{
		$config = new JConfig();
        jimport('joomla.filter.output');
        $ipauth = new IpropertyHelperAuth(array('msg'=>false));

		// Set name
		$this->name = htmlspecialchars_decode($this->name, ENT_QUOTES);
        $this->comments = htmlspecialchars_decode($this->comments, ENT_QUOTES);
        
        if(!$this->openhouse_start || !$this->openhouse_end){        
            $this->setError(JText::_('COM_IPROPERTY_START_END_DATE_REQUIRED'));
            return false;
        }

		return true;
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
		$table = JTable::getInstance('Openhouse','IpropertyTable');

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
}
?>