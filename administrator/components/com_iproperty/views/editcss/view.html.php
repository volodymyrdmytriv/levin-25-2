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

class IpropertyViewEditcss extends JView 
{
    protected $settings;
    protected $user;
    
    function display($tpl = null)
	{
		// Initialiase variables.
        $this->settings = ipropertyAdmin::config(); 
        $this->user     = JFactory::getUser();

        // Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

        // if no agent id and user is not admin - no access
        if (!$this->user->authorise('core.admin')){
            $this->setLayout('noaccess');
            $this->_displayNoAccess($tpl);
            return;
        }else if(JRequest::getVar('edit_css_file')){
            $this->setLayout('edit');
            $this->edit();
            return;
        }

		JToolBarHelper::title('<span class="ip_adminHeader">'.JText::_( 'COM_IPROPERTY_SELECT_CSS' ).'</span>', 'iproperty' );

		JToolBarHelper::custom('editcss.edit', 'edit.png', 'edit_f2.png', 'COM_IPROPERTY_EDIT_CSS', false, false );
        JToolBarHelper::divider();
        JToolBarHelper::cancel('editcss.cancel');
        
        $css_files = JFolder::files(JPATH_COMPONENT_SITE.DS.'assets'.DS.'css', '.css');
        $css_list = array();
        foreach ($css_files as $css):
            $cssfiles[] = JHTML::_('select.option', $css, $css);
        endforeach;
        $this->cssList = JHTML::_('select.radiolist', $cssfiles, 'edit_css_file', 'size="5" class="inputbox"', 'text', 'text', 'iproperty.css');
        
		parent::display($tpl);
	}
	
	public function edit()
	{
		$tpl = null;
        JRequest::setVar( 'hidemainmenu', 1 );
        
        $app                = JFactory::getApplication();
        $this->fname	    = JRequest::getVar('edit_css_file');        
        $this->filename     = JPATH_COMPONENT_SITE.DS.'assets'.DS.'css'.DS.$this->fname;
        
        // raise a notice explaining that template css files will override default css styles if they exist
        if($this->fname == 'iproperty.css' || $this->fname == 'advsearch.css' || $this->fname == 'catmap.css'){
            JError::raiseNotice(JText::_('SOME_ERROR_CODE'), sprintf(JText::_('COM_IPROPERTY_CSS_OVERRIDE_NOTICE'), $this->fname));
        }

        jimport('joomla.filesystem.file');

        if (JFile::getExt($this->filename) !== 'css') {
            $msg = JText::_( 'COM_IPROPERTY_CSS_WRONG_TYPE' );
            $app->redirect(JRoute::_('index.php?option=com_iproperty', false), $msg, 'error');
        }

        $content = JFile::read($this->filename);

        if (!$content){
            $msg = JText::sprintf('Operation Failed Could not open', $this->filename);
            $app->redirect(JRoute::_('index.php?option=com_iproperty', false), $msg, 'error');
        }
            
        $this->content = htmlspecialchars($content, ENT_COMPAT, 'UTF-8');

		JToolBarHelper::title( '<span class="ip_adminHeader">'.JText::_( 'COM_IPROPERTY_EDIT_CSS' ).'</span> <span class="ip_adminSubheader">['.$this->fname.']</span>', 'iproperty' );

		JToolBarHelper::apply('editcss.apply');
		JToolBarHelper::save('editcss.save');
		JToolBarHelper::divider();
        JToolBarHelper::custom('editcss.copy2template', 'copy.png', 'copy_f2.png', 'JTOOLBAR_DUPLICATE', false);
		JToolBarHelper::divider();
		JToolBarHelper::cancel('editcss.cancel');
		
		parent::display($tpl);
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