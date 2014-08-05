<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controlleradmin');

class IpropertyControllerProperties extends JControllerAdmin
{
    protected $text_prefix = 'COM_IPROPERTY';

	function __construct($config = array())
	{
		parent::__construct($config);
        $this->registerTask('unpublish',	'publish');
        $this->registerTask('unfeature',	'feature');
        $this->registerTask('delete',       'remove');
        $this->registerTask('unapprove',    'approve');
	}
		
	public function getModel($name = 'Property', $prefix = 'IpropertyModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
    
    public function publish()
	{
		// Check for request forgeries
        JRequest::checkToken() or die( 'Invalid Token' );
        $cid	= JRequest::getVar('cid', array(), '', 'array');
		$values	= array('publish' => 1, 'unpublish' => 0);
		$task	= $this->getTask();
		$value	= JArrayHelper::getValue($values, $task, 0, 'int');

        if (empty($cid)) {
			JError::raiseWarning(500, JText::_($this->text_prefix.'_NO_ITEM_SELECTED'));
		}else{
			// Get the model.
			$model = $this->getModel();
            
            // Make sure the item ids are integers
			jimport('joomla.utilities.arrayhelper');
			JArrayHelper::toInteger($cid);

            // Change the items.
            if ($count = $model->publishProp($cid, $value)) {
                $msg = ($value) ? $this->text_prefix.'_N_ITEMS_PUBLISHED' : $this->text_prefix.'_N_ITEMS_UNPUBLISHED';
				$this->setMessage(JText::plural($msg, $count));
			} else {
				JError::raiseWarning(500, $model->getError());
			}
		}

		$this->setRedirect('index.php?option=com_iproperty&view=properties');
	}

    public function feature()
	{
		// Check for request forgeries
        JRequest::checkToken() or die( 'Invalid Token' );
        $cid	= JRequest::getVar('cid', array(), '', 'array');
		$values	= array('feature' => 1, 'unfeature' => 0);
		$task	= $this->getTask();
		$value	= JArrayHelper::getValue($values, $task, 0, 'int');

        if (empty($cid)) {
			JError::raiseWarning(500, JText::_($this->text_prefix.'_NO_ITEM_SELECTED'));
		}else{
			// Get the model.
			$model = $this->getModel();
            
            // Make sure the item ids are integers
			jimport('joomla.utilities.arrayhelper');
			JArrayHelper::toInteger($cid);

            // Change the items.
            if ($count = $model->featureProp($cid, $value)) {
                $msg = ($value) ? $this->text_prefix.'_N_ITEMS_FEATURED' : $this->text_prefix.'_N_ITEMS_UNFEATURED';
				$this->setMessage(JText::plural($msg, $count));
			} else {
				JError::raiseWarning(500, $model->getError());
			}
		}

		$this->setRedirect('index.php?option=com_iproperty&view=properties');
	}    

	public function remove()
	{
		// Check for request forgeries
        JRequest::checkToken() or die( 'Invalid Token' );
        $cid	= JRequest::getVar('cid', array(), '', 'array');

        if (empty($cid)) {
			JError::raiseWarning(500, JText::_($this->text_prefix.'_NO_ITEM_SELECTED'));
		}else{
			// Get the model.
			$model = $this->getModel();

			// Make sure the item ids are integers
			jimport('joomla.utilities.arrayhelper');
			JArrayHelper::toInteger($cid);

			// Remove the items.
			if ($model->deleteProp($cid)) {
				$this->setMessage(JText::plural($this->text_prefix.'_N_ITEMS_DELETED', count($cid)));
			} else {
				JError::raiseWarning(500, $model->getError());
			}
		}

		$this->setRedirect('index.php?option=com_iproperty&view=properties');
	}
    
    public function clearHits()
	{
        // Check for request forgeries
        JRequest::checkToken() or die( 'Invalid Token' );
        $cid	= JRequest::getVar('cid', array(), '', 'array');

        if (empty($cid)) {
			JError::raiseWarning(500, JText::_($this->text_prefix.'_NO_ITEM_SELECTED'));
		}else{
			// Get the model.
			$model = $this->getModel();

			// Make sure the item ids are integers
			jimport('joomla.utilities.arrayhelper');
			JArrayHelper::toInteger($cid);

			// Remove the items.
			if ($model->clearHits($cid)) {
				$this->setMessage(JText::plural($this->text_prefix.'_N_ITEMS_RESET', count($cid)));
			} else {
				JError::raiseWarning(500, $model->getError());
			}
		}

		$this->setRedirect('index.php?option=com_iproperty&view=properties');
	}  
    
    public function approve()
	{
		// Check for request forgeries
        JRequest::checkToken() or die( 'Invalid Token' );
        $cid	= JRequest::getVar('cid', array(), '', 'array');
		$values	= array('approve' => 1, 'unapprove' => 0);
		$task	= $this->getTask();
		$value	= JArrayHelper::getValue($values, $task, 0, 'int');

        if (empty($cid)) {
			JError::raiseWarning(500, JText::_($this->text_prefix.'_NO_ITEM_SELECTED'));
		}else{
			// Get the model.
			$model = $this->getModel();
            
            // Make sure the item ids are integers
			jimport('joomla.utilities.arrayhelper');
			JArrayHelper::toInteger($cid);

            // Change the items.
            if ($count = $model->approveProp($cid, $value)) {
                $msg = ($value) ? $this->text_prefix.'_N_ITEMS_APPROVED' : $this->text_prefix.'_N_ITEMS_UNAPPROVED';
				$this->setMessage(JText::plural($msg, $count));
			} else {
				JError::raiseWarning(500, $model->getError());
			}
		}

		$this->setRedirect('index.php?option=com_iproperty&view=properties');
	}
}
?>