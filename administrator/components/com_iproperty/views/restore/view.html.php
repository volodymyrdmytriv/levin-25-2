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

class IpropertyViewRestore extends JView 
{
	protected $user;
    protected $backupFiles;
    
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
        
        $backupFiles    = JFolder::files(JPATH_SITE.DS.'media'.DS.'com_iproperty', '.sql.gz');
		$boptions       = array();
		foreach ($backupFiles as $bfile):
			$boptions[] = JHTML::_('select.option', $bfile, $bfile);
		endforeach;

		$this->backupFiles = JHTML::_('select.genericlist', $boptions, 'bak_file', 'size="10" class="inputbox" style="width: 300px;"');

        $this->addToolbar();
		parent::display($tpl);
    }
    
    protected function addToolbar()
	{
		JRequest::setVar('hidemainmenu', true);

		JToolBarHelper::title('<span class="ip_adminHeader">'.JText::_('COM_IPROPERTY_RESTORE_FROM_BACKUP_COPY').'</span>', 'iproperty');
        if($this->user->authorise('core.admin')){
            JToolBarHelper::custom( 'backup.restoreDB', 'restore.png', 'restore_f2.png', JText::_( 'COM_IPROPERTY_RESTORE' ), false, false );
        }
        JToolBarHelper::divider();
		JToolBarHelper::back();
	}

    public function _displayNoAccess($tpl = null){
        JToolBarHelper::title( '<span class="ip_adminHeader">'.JText::_( 'COM_IPROPERTY_NO_ACCESS' ).'</span>', 'iproperty' );
        JToolBarHelper::back();
        parent::display($tpl);
    }
}
?>