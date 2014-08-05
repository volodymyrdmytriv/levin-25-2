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

class IpropertyViewCompany extends JView
{
	protected $form;
	protected $item;
	protected $state;
    protected $settings;
    protected $ipauth;

    public function display($tpl = null)
	{
        // Initialiase variables.
		$this->form		= $this->get('Form');
		$this->item		= $this->get('Item');
		$this->state	= $this->get('State');
        $this->settings = ipropertyAdmin::config(); 
        $this->ipauth   = new ipropertyHelperAuth();

        $folder = JURI::root(true) . '/media/com_iproperty/companies/';
        // it's array with one item
        $model = $this->getModel();
        $portfolio_avail_report = $model->getFilesByTitle($this->item->id, 'portfolio_avail_report');
        
        
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

        // if no agent id and user is not admin - no access
        if (!$this->ipauth->getAdmin() && !$this->ipauth->getSuper()){
            $this->setLayout('noaccess');
            $this->_displayNoAccess($tpl);
            return;
        }

		$this->addToolbar();
		$this->assignRef('folder', $folder);
		$this->assignRef('portfolio_avail_report', $portfolio_avail_report);
		parent::display($tpl);
	}

    protected function addToolbar()
	{
		JRequest::setVar('hidemainmenu', true);

		$isNew		= ($this->item->id == 0);

		JToolBarHelper::title($isNew ? '<span class="ip_adminHeader">'.JText::_('COM_IPROPERTY_ADD_COMPANY').'</span>' : '<span class="ip_adminHeader">'.JText::_('COM_IPROPERTY_EDIT_COMPANY').'</span> <span class="ip_adminSubheader">['.$this->item->name.']</span>', 'iproperty');

        // If not checked out, can save the item.
        JToolBarHelper::apply('company.apply', 'JTOOLBAR_APPLY');
        JToolBarHelper::save('company.save', 'JTOOLBAR_SAVE');
        JToolBarHelper::divider();
        // Only show these options to super agents or admin
        if ($this->ipauth->getAdmin()){
            JToolBarHelper::custom('company.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);

            // If an existing item, can save to a copy.
            if (!$isNew) {
                JToolBarHelper::custom('company.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
            }
            JToolBarHelper::divider();
        }        

		if (empty($this->item->id))  {
			JToolBarHelper::cancel('company.cancel','JTOOLBAR_CANCEL');
		}
		else {
			JToolBarHelper::cancel('company.cancel', 'JTOOLBAR_CLOSE');
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