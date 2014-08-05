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

class IpropertyViewAgent extends JView
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

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

        // if no agent id and user is not admin - no access
        if (!$this->ipauth->getAdmin() && !$this->ipauth->getUagentId()){
            $this->setLayout('noaccess');
            $this->_displayNoAccess($tpl);
            return;
        }
        
		
		$document = JFactory::getDocument();
		$css = "input#jform_title {
			font-size: inherit;
		}";
		
		$document->addStyleDeclaration($css);
		
		$this->addToolbar();
		parent::display($tpl);
	}

    protected function addToolbar()
	{
		JRequest::setVar('hidemainmenu', true);

		$isNew		= ($this->item->id == 0);

		JToolBarHelper::title($isNew ? '<span class="ip_adminHeader">'.JText::_('COM_IPROPERTY_ADD_AGENT').'</span>' : '<span class="ip_adminHeader">'.JText::_('COM_IPROPERTY_EDIT_AGENT').'</span> <span class="ip_adminSubheader">['.$this->item->fname.' '.$this->item->lname.']</span>', 'iproperty');

		// If not checked out, can save the item.
        JToolBarHelper::apply('agent.apply', 'JTOOLBAR_APPLY');
        JToolBarHelper::save('agent.save', 'JTOOLBAR_SAVE');
        JToolBarHelper::divider();
        // Only show these options to admin
        if ($this->ipauth->getAdmin()){
            JToolBarHelper::custom('agent.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);

            // If an existing item, can save to a copy.
            if (!$isNew) {
                JToolBarHelper::custom('agent.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
            }
            JToolBarHelper::divider();
        }        

		if (empty($this->item->id))  {
			JToolBarHelper::cancel('agent.cancel','JTOOLBAR_CANCEL');
		}
		else {
			JToolBarHelper::cancel('agent.cancel', 'JTOOLBAR_CLOSE');
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