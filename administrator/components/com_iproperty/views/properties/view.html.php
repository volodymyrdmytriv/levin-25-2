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

class IpropertyViewProperties extends JView 
{
    protected $items;
	protected $pagination;
	protected $state;
    protected $settings;
    protected $ipauth;
    
    public function display($tpl = null)
	{
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

        // if user is not admin AND user does not have and agent id or IP auth is disabled - no access
        if (!$this->ipauth->getAdmin() && (!$this->ipauth->getUagentId() || !$this->ipauth->getAuthLevel())){
            $this->setLayout('noaccess');
            $this->_displayNoAccess($tpl);
            return;
        }

		$this->addToolbar();
		require_once JPATH_COMPONENT .'/models/fields/company.php';
        require_once JPATH_COMPONENT .'/models/fields/stypes.php';
        require_once JPATH_COMPONENT .'/models/fields/city.php';
        require_once JPATH_COMPONENT .'/models/fields/category.php';
        require_once JPATH_COMPONENT .'/models/fields/agent.php';
        require_once JPATH_COMPONENT .'/models/fields/beds.php';
        require_once JPATH_COMPONENT .'/models/fields/baths.php';
		parent::display($tpl);
	}

    protected function addToolbar()
	{
		JToolBarHelper::title('<span class="ip_adminHeader">'.JText::_('COM_IPROPERTY_PROPERTIES').'</span>', 'iproperty');

        // Only show these options to super agents or admin
        if ($this->ipauth->getAdmin() || $this->ipauth->getSuper()){
            if($this->settings->edit_rights){
                JToolBarHelper::custom('properties.approve', 'apply.png', 'deny_f2.png', JText::_( 'COM_IPROPERTY_APPROVE' ), true );
                JToolBarHelper::custom('properties.unapprove', 'deny.png', 'deny_f2.png', JText::_( 'COM_IPROPERTY_UNAPPROVE' ), true );
                JToolBarHelper::divider();
            }
                
            JToolBarHelper::custom('properties.feature', 'featured.png', 'featured_f2.png', JText::_( 'COM_IPROPERTY_FEATURE' ), true );
            JToolBarHelper::custom('properties.unfeature', 'remove.png', 'remove_f2.png', JText::_( 'COM_IPROPERTY_UNFEATURE' ), true );
            JToolBarHelper::divider();            
		}
        
        // Any user with access to this view should see these
        JToolBarHelper::custom('properties.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
        JToolBarHelper::custom('properties.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
        JToolBarHelper::divider();
        JToolBarHelper::addNew('property.add','JTOOLBAR_NEW');
        JToolBarHelper::editList('property.edit','JTOOLBAR_EDIT');
        JToolBarHelper::divider();
        JToolBarHelper::deleteList(JText::_('COM_IPROPERTY_CONFIRM_DELETE'), 'properties.delete','JTOOLBAR_DELETE');

		// Only show these options to super agents or admin
        if ($this->ipauth->getAdmin() || $this->ipauth->getSuper()){
            JToolBarHelper::deleteList(JText::_('COM_IPROPERTY_CONFIRM_CLEAR'), 'properties.clearHits','COM_IPROPERTY_CLEAR_HITS');
		}
	}

    public function _displayNoAccess($tpl = null)
    {
        JToolBarHelper::title( '<span class="ip_adminHeader">'.JText::_( 'COM_IPROPERTY_NO_ACCESS' ).'</span>', 'iproperty' );
        JToolBarHelper::back();
        JToolBarHelper::spacer();

        parent::display($tpl);
    }
}
?>