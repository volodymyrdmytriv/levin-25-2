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

class IpropertyControllerAmenities extends JControllerAdmin
{
	protected $text_prefix = 'COM_IPROPERTY';

	function __construct($config = array())
	{
		parent::__construct($config);
        $this->registerTask( 'delete', 'remove' );
	}

    public function getModel($name = 'Amenity', $prefix = 'IpropertyModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
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
			if ($count = $model->deleteAmenity($cid)) {
				$this->setMessage(JText::plural($this->text_prefix.'_N_ITEMS_DELETED', $count));
			} else {
				JError::raiseWarning(500, $model->getError());
			}
		}

		$this->setRedirect('index.php?option=com_iproperty&view=amenities');
	}
    
    public function saveCats()
    {
        // Check for request forgeries
		JRequest::checkToken() or die(JText::_('JINVALID_TOKEN'));
        
        // Get items from the request.
		$cid	= JRequest::getVar('cid', array(), '', 'array');
        $post   = JRequest::get('post');
        
        if (empty($cid)) {
			JError::raiseWarning(500, JText::_($this->text_prefix.'_NO_ITEM_SELECTED'));
		}
		else {
			// Get the model.
			$model = $this->getModel();
            
            // Publish the items.
			if ($count = $model->saveCats($cid, $post)) {
                $ntext = $this->text_prefix.'_N_ITEMS_SAVED';
                $this->setMessage(JText::plural($ntext, $count));				
			}else{
                JError::raiseWarning(500, $model->getError());
            }
        }
        $this->setRedirect(JRoute::_('index.php?option=com_iproperty&view=amenities', false));
    }
}
?>
