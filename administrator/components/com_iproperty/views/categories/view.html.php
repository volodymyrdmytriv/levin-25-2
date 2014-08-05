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

class IpropertyViewCategories extends JView
{
	protected $state;
    protected $settings;
    protected $ipauth;
    
    public function display($tpl = null)
	{
        // Initialise variables.
		$this->state		= $this->get('State');
        $this->settings     = ipropertyAdmin::config();
        $this->ipauth       = new ipropertyHelperAuth();

        // Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

        // if user is not admin - no access
        if (!$this->ipauth->getAdmin()){
            $this->setLayout('noaccess');
            $this->_displayNoAccess($tpl);
            return;
        }

		$this->addToolbar();
		parent::display($tpl);
	}

    protected function addToolbar($tpl = null)
    {
        //create the toolbar
        JToolBarHelper::title( '<span class="ip_adminHeader">'.JText::_( 'COM_IPROPERTY_CATEGORIES' ).'</span>', 'iproperty' );

        if($this->getLayout() != 'remove'){
            JToolBarHelper::custom('categories.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
            JToolBarHelper::custom('categories.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            JToolBarHelper::divider();
            JToolBarHelper::addNew('category.add','JTOOLBAR_NEW');
            JToolBarHelper::editList('category.edit','JTOOLBAR_EDIT');
            JToolBarHelper::divider();
            JToolBarHelper::deleteList('', 'categories.delete','JTOOLBAR_DELETE');
		}else{
			JToolBarHelper::back();
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