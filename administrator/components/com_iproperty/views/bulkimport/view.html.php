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

class IpropertyViewBulkimport extends JView 
{
    protected $user;
    protected $dataFiles;
    
    public function display($tpl = null)
	{
        $this->user   = JFactory::getUser();
        
        // Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

        // Check if the user should be in this editing area
        if (!$this->user->authorise('core.admin')){
            $this->setLayout('noaccess');
            $this->_displayNoAccess($tpl);
            return;
        }
        
        $dataFiles       = JFolder::files(JPATH_SITE.DS.'media'.DS.'com_iproperty', '.');
		$coptions       = array();
		foreach ($dataFiles as $cfiles):
			$coptions[] = JHTML::_('select.option', $cfiles, $cfiles);
		endforeach;
        
		$this->dataFiles = JHTML::_('select.genericlist', $coptions, 'datafile', 'size="10" class="inputbox" style="width: 300px;"');		

		$this->addToolbar();
		parent::display($tpl);
	}
    
    protected function addToolbar()
	{
		JToolBarHelper::title('<span class="ip_adminHeader">'.JText::_('COM_IPROPERTY_BULKIMPORT_FILE').'</span>', 'iproperty');

        // Only show these options to admin
        if ($this->user->authorise('core.admin')){
            JToolBarHelper::custom( 'bulkimport.import', 'restore.png', 'restore_f2.png', JText::_( 'COM_IPROPERTY_IMPORT' ), false, false );
            JToolBarHelper::divider();
        }  
        JToolBarHelper::cancel('bulkimport.cancel','JTOOLBAR_CANCEL');
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