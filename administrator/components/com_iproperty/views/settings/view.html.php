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

class IpropertyViewSettings extends JView 
{
    protected $form;
	protected $item;
	protected $state;
    protected $settings;
    protected $ipauth;

	public function display($tpl = null)
	{
        // default to the editing layout
        JRequest::setVar('id', 1);
        $this->setLayout('edit');
        
        // Initialiase variables.
		$this->form		= $this->get('Form');
		$this->item		= $this->get('Item');
		$this->state	= $this->get('State');
        $this->settings = ipropertyAdmin::config(); 
        $this->ipauth   = new ipropertyHelperAuth();

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		parent::display($tpl);
	}

    protected function addToolbar()
	{
		$user       = JFactory::getUser();
        $notadmin   = (!$user->authorise('core.admin')) ? ' <span class="ip_adminSubheader">['.JText::_( 'COM_IPROPERTY_NOT_ADMIN_SETTINGS' ).']</span>' : '';

		JToolBarHelper::title( '<span class="ip_adminHeader">'.JText::_( 'COM_IPROPERTY_EDIT_SETTINGS' ).$notadmin.'</span>', 'iproperty' );

		// If admin let them save and edit css
        if($user->authorise('core.admin')){
            JToolBarHelper::apply('settings.apply', 'JTOOLBAR_APPLY');
            JToolBarHelper::divider();
            JToolBarHelper::custom('settings.edit_css', 'edit.png', 'edit_f2.png', 'COM_IPROPERTY_EDIT_CSS', false);
            JToolBarHelper::divider();
        }
        JToolBarHelper::cancel('settings.cancel', 'JTOOLBAR_CLOSE');
	}
}
?>