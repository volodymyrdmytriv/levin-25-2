<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class IpropertyTableSettings extends JTable
{
	function __construct(&$_db)
	{
		parent::__construct('#__iproperty_settings', 'id', $_db);
	}

    public function bind($array, $ignore = '')
	{
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
			$oldrow = JTable::getInstance('Settings', 'IpropertyTable');
			if (!$oldrow->load($this->id) && $oldrow->getError()){
				$this->setError($oldrow->getError());
			}

			// Store the new row
			parent::store($updateNulls);
		}
		return count($this->getErrors())==0;
	}
}
?>