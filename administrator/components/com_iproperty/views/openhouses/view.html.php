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

class IpropertyViewOpenhouses extends JView 
{
	protected $items;
	protected $pagination;
	protected $state;
    protected $settings;
    protected $ipauth;
    
    public function display($tpl = null)
	{
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
		JToolBarHelper::title('<span class="ip_adminHeader">'.JText::_('COM_IPROPERTY_OPENHOUSES').'</span>', 'iproperty');

        JToolBarHelper::custom('openhouses.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
        JToolBarHelper::custom('openhouses.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
        JToolBarHelper::divider();
        JToolBarHelper::addNew('openhouse.add','JTOOLBAR_NEW');
        JToolBarHelper::editList('openhouse.edit','JTOOLBAR_EDIT');
        JToolBarHelper::divider();
        JToolBarHelper::deleteList(JText::_('COM_IPROPERTY_CONFIRM_DELETE'), 'openhouses.delete','JTOOLBAR_DELETE');
	}

    function _displayNoAccess($tpl = null)
    {
        JToolBarHelper::title( '<span class="ip_adminHeader">'.JText::_( 'COM_IPROPERTY_NO_ACCESS' ).'</span>', 'iproperty' );
        JToolBarHelper::back();
        JToolBarHelper::spacer();
        
        parent::display($tpl);
    }
}
?>
