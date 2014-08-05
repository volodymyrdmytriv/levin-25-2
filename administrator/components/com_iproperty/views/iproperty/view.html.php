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

class IpropertyViewIproperty extends JView 
{
    protected $user;
    protected $dispatcher;
    protected $fproperties;
    protected $tproperties;
    protected $ausers; 
    protected $settings;
    protected $ipauth;
    
    public function display($tpl = null)
	{
        jimport('joomla.filesystem.file');
        JPluginHelper::importPlugin( 'iproperty' );        

        // Initialiase variables.
        $this->user             = JFactory::getUser();
        $this->dispatcher       = JDispatcher::getInstance();
		$this->fproperties		= $this->get('Fprops');
		$this->tproperties		= $this->get('Tprops');
		$this->ausers           = $this->get('Ausers');
        $this->settings         = ipropertyAdmin::config(); 
        $this->ipauth           = new ipropertyHelperAuth();

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
		JToolBarHelper::title('<span class="ip_adminHeader">'.JText::_('COM_IPROPERTY').'</span>', 'iproperty');

        // Only show config option to admin
        if ($this->ipauth->getAdmin()){
            JToolBarHelper::preferences('com_iproperty');
        }
	}
}
?>