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

class IpropertyViewAgents extends JView
{
    protected $companies;
    protected $items;
	protected $pagination;
	protected $state;
    protected $settings;
    protected $ipauth;

	public function display($tpl = null)
	{
        // Initialise variables.
        $this->companies	= $this->get('CompanyOrders');
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

        // if user is not admin AND user does not have and agent id or IP auth is disabled - no access
        if (!$this->ipauth->getAdmin() && (!$this->ipauth->getUagentId() || !$this->ipauth->getAuthLevel())){
            $this->setLayout('noaccess');
            $this->_displayNoAccess($tpl);
            return;
        }

		$this->addToolbar();
		require_once JPATH_COMPONENT .'/models/fields/company.php';
		parent::display($tpl);
	}

    protected function addToolbar()
	{
		JToolBarHelper::title('<span class="ip_adminHeader">'.JText::_('COM_IPROPERTY_AGENTS').'</span>', 'iproperty');

        // Only show these options to super agents or admin
        if ($this->ipauth->getAdmin() || $this->ipauth->getSuper()){
            JToolBarHelper::custom('agents.feature', 'featured.png', 'featured_f2.png', JText::_( 'COM_IPROPERTY_FEATURE' ), true );
            JToolBarHelper::custom('agents.unfeature', 'remove.png', 'remove_f2.png', JText::_( 'COM_IPROPERTY_UNFEATURE' ), true );
            JToolBarHelper::divider();
            JToolBarHelper::custom('agents.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
            JToolBarHelper::custom('agents.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            JToolBarHelper::divider();
            JToolBarHelper::addNew('agent.add','JTOOLBAR_NEW');
		}
        
        // Any user with access to this view should be able to edit their own profile
        JToolBarHelper::editList('agent.edit','JTOOLBAR_EDIT');

		// Only show these options to super agents or admin
        if ($this->ipauth->getAdmin() || $this->ipauth->getSuper()){
			JToolBarHelper::divider();
            JToolBarHelper::deleteList(JText::_('COM_IPROPERTY_CONFIRM_DELETE'), 'agents.delete','JTOOLBAR_DELETE');
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