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

class IpropertyViewCompanies extends JView
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

        // if user is not admin AND not super agent or IP auth is disabled - no access
        if (!$this->ipauth->getAdmin() && (!$this->ipauth->getSuper() || !$this->ipauth->getAuthLevel())){
            $this->setLayout('noaccess');
            $this->_displayNoAccess($tpl);
            return;
        }

		$this->addToolbar();
		parent::display($tpl);
	}

    protected function addToolbar()
	{
		JToolBarHelper::title('<span class="ip_adminHeader">'.JText::_('COM_IPROPERTY_COMPANIES').'</span>', 'iproperty');

        // Only show these options to super agents or admin
        if ($this->ipauth->getAdmin()){
            JToolBarHelper::custom('companies.feature', 'featured.png', 'featured_f2.png', JText::_( 'COM_IPROPERTY_FEATURE' ), true );
            JToolBarHelper::custom('companies.unfeature', 'remove.png', 'remove_f2.png', JText::_( 'COM_IPROPERTY_UNFEATURE' ), true );
            JToolBarHelper::divider();
            JToolBarHelper::custom('companies.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
            JToolBarHelper::custom('companies.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            JToolBarHelper::divider();
            JToolBarHelper::addNew('company.add','JTOOLBAR_NEW');
        }
        if ($this->ipauth->getAdmin() || $this->ipauth->getSuper()){
            JToolBarHelper::editList('company.edit','JTOOLBAR_EDIT');
        }
        if ($this->ipauth->getAdmin()){
			JToolBarHelper::divider();
            JToolBarHelper::deleteList(JText::_('COM_IPROPERTY_CONFIRM_DELETE'), 'companies.delete','JTOOLBAR_DELETE');
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