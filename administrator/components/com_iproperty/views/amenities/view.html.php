<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class IpropertyViewAmenities extends JView
{
    protected $items;
	protected $pagination;
	protected $state;
    protected $settings;
    protected $ipauth;

    public function display($tpl = null)
	{
		$user = JFactory::getUser();

        // Initialise variables.
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
        $this->settings     = ipropertyAdmin::config();
        $this->ipauth       = new ipropertyHelperAuth();        

        // Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

        /// if user is not admin - no access
        if (!$this->ipauth->getAdmin()){
            $this->setLayout('noaccess');
            $this->_displayNoAccess($tpl);
            return;
        }
        
        $hstyle = 'div.pagination .limit{display: none !important;}';
        $this->document->addStyleDeclaration($hstyle);        

		$this->addToolbar();
        require_once JPATH_COMPONENT .'/models/fields/amenitycat.php';
		parent::display($tpl);
	}

    protected function addToolbar()
	{
		JToolBarHelper::title('<span class="ip_adminHeader">'.JText::_('COM_IPROPERTY_AMENITIES').'</span>', 'iproperty');

        // Only show these options to admin
        if ($this->ipauth->getAdmin()){
            JToolBarHelper::custom('amenities.saveCats', 'save.png', 'save_f2.png','JTOOLBAR_APPLY', false);
            JToolBarHelper::divider();
            JToolBarHelper::addNew('amenity.add','JTOOLBAR_NEW');
            JToolBarHelper::editList('amenity.edit','JTOOLBAR_EDIT');
            JToolBarHelper::divider();
            JToolBarHelper::deleteList(JText::_('COM_IPROPERTY_CONFIRM_DELETE'), 'amenities.delete','JTOOLBAR_DELETE');
		}
	}

    public function _displayNoAccess($tpl = null)
    {
        JToolBarHelper::title( '<span class="ip_adminHeader">'.JText::_( 'COM_IPROPERTY_NO_ACCESS' ).'</span>', 'iproperty' );
        JToolBarHelper::back();
        parent::display($tpl);
    }
}
?>