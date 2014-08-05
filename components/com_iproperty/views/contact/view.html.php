<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.view');

class IpropertyViewContact extends JView
{
	function display($tpl = null)
	{		
        $layout     = $this->getLayout();
        
        if(!$layout || $layout == 'default'){
            $layout = JRequest::getVar('layout');
        }

        $model      = $this->getModel();
        $contact    = $model->contactInfo($layout);

        if(!$contact){
            $this->_displayNoResult('noresult');
            return;
        }        

        if($layout == 'company'){
            $this->_displayCompany($contact);
            return;
        }else if($layout == 'agent'){
            $this->_displayAgent($contact);
            return;
        }
	}

    protected function _prepareDocument($contact)
    {
        $app            = JFactory::getApplication();
		$menus          = $app->getMenu();
		$pathway        = $app->getPathway();
		$this->params   = $app->getParams();
		$title          = null;

        $menu = $menus->getActive();
		if ($menu) {
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		} else {
			$this->params->def('page_heading', JText::_( 'COM_IPROPERTY_INTELLECTUAL_PROPERTY' ));
		}

        $title = JText::_('COM_IPROPERTY_CONTACT').' '.$contact->name;
        $this->iptitle = $title;
        if (empty($title)) {
			$title = $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
			$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
		}
		$this->document->setTitle($title);

        // Set meta data according to menu params
        if ($this->params->get('menu-meta_description')) $this->document->setDescription($this->params->get('menu-meta_description'));
        if ($this->params->get('menu-meta_keywords')) $this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
        if ($this->params->get('robots')) $this->document->setMetadata('robots', $this->params->get('robots'));

		// Breadcrumbs
        if(is_object($menu) && $menu->query['view'] != 'contact') {
			$pathway->addItem($title);
		}
	}

    function _displayCompany($company)
    {
        $app  = JFactory::getApplication();
        $option     = JRequest::getCmd('option');
        
        JHTML::_('behavior.tooltip');
        JHTML::_('behavior.formvalidation');
        JPluginHelper::importPlugin( 'iproperty' );
        $dispatcher = JDispatcher::getInstance();

        $this->ipbaseurl = JURI::root(true);
        $this->ctype = 'company';

		$document           = JFactory::getDocument();
		$settings           = ipropertyAdmin::config();
        $this->ipauth       = new ipropertyHelperAuth();

        if(!$settings->co_show_contact){
            $this->_displayNoAccess('noaccess');
            return;
        }

		//create toolbar
        $dispatcher->trigger( 'onBeforeRenderToolbar', array( &$settings ) );
		echo ipropertyHTML::buildToolbar();

        $lists = array();
        $lists['copyme']    = ipropertyHTML::checkbox( 'copy_me', '', 1, JText::_( 'COM_IPROPERTY_COPY_ME_EMAIL' ), 1, JRequest::getVar('copy_me'));
        //contact preferences
        $prefs = array();
        $prefs[] 	= JHTML::_('select.option', JText::_( 'COM_IPROPERTY_PHONE' ), JText::_( 'COM_IPROPERTY_PHONE' ) );
        $prefs[] 	= JHTML::_('select.option', JText::_( 'COM_IPROPERTY_EMAIL' ), JText::_( 'COM_IPROPERTY_EMAIL' ) );
        $prefs[] 	= JHTML::_('select.option', JText::_( 'COM_IPROPERTY_EITHER' ), JText::_( 'COM_IPROPERTY_EITHER' ) );
        $lists['preference'] = JHTML::_('select.radiolist', $prefs, 'sender_preference', 'size="5" class="inputbox"', 'value', 'text', JRequest::getVar('sender_preference'));

        $co_photo_width = ( $settings->company_photo_width ) ? $settings->company_photo_width : '90';
        $company_folder = $this->ipbaseurl.'/media/com_iproperty/companies/';

        $this->assignRef('lists', $lists);
        $this->assignRef('company', $company);
        $this->assignRef('settings', $settings);
        $this->assignRef('company_photo_width', $co_photo_width);
        $this->assignRef('company_folder', $company_folder);
        $this->assignRef('dispatcher', $dispatcher);

        $form_js = '
                function formValidate(f) {
                   if (document.formvalidator.isValid(f)) {
                      return true;
                   }
                   else {
                      alert("' . JText::_( 'COM_IPROPERTY_ENTER_REQUIRED' ) . '");
                   }
                   return false;
                }';
        $document->addScriptDeclaration( $form_js );  
        
        $this->_prepareDocument($company);
		parent::display();
    }

    function _displayAgent($agent)
    {
        $app  = JFactory::getApplication();
        $option     = JRequest::getCmd('option');

        JHTML::_('behavior.tooltip');
        JHTML::_('behavior.formvalidation');
        JPluginHelper::importPlugin( 'iproperty' );
        $dispatcher = JDispatcher::getInstance();

        $this->ipbaseurl = JURI::root(true);
        $this->ctype = 'agent';

		$document           = JFactory::getDocument();
		$settings           = ipropertyAdmin::config();
        $this->ipauth       = new ipropertyHelperAuth();

        if(!$settings->agent_show_contact){
            $this->_displayNoAccess('noaccess');
            return;
        }

		//create toolbar
        $dispatcher->trigger( 'onBeforeRenderToolbar', array( &$settings ) );
		echo ipropertyHTML::buildToolbar();

        $lists = array();
        $lists['copyme']    = ipropertyHTML::checkbox( 'copy_me', '', 1, JText::_( 'COM_IPROPERTY_COPY_ME_EMAIL' ), 1, JRequest::getVar('copy_me'));
        //contact preferences
        $prefs = array();
        $prefs[] 	= JHTML::_('select.option', JText::_( 'COM_IPROPERTY_PHONE' ), JText::_( 'COM_IPROPERTY_PHONE' ) );
        $prefs[] 	= JHTML::_('select.option', JText::_( 'COM_IPROPERTY_EMAIL' ), JText::_( 'COM_IPROPERTY_EMAIL' ) );
        $prefs[] 	= JHTML::_('select.option', JText::_( 'COM_IPROPERTY_EITHER' ), JText::_( 'COM_IPROPERTY_EITHER' ) );
        $lists['preference'] = JHTML::_('select.radiolist', $prefs, 'sender_preference', 'size="5" class="inputbox"', 'value', 'text', JRequest::getVar('sender_preference'));

        $agent_photo_width = ( $settings->agent_photo_width ) ? $settings->agent_photo_width : '90';
        $agents_folder = $this->ipbaseurl.'/media/com_iproperty/agents/';

        $this->assignRef('lists', $lists);
        $this->assignRef('agent', $agent);
        $this->assignRef('settings', $settings);
        $this->assignRef('agent_photo_width', $agent_photo_width);
        $this->assignRef('agents_folder', $agents_folder);
        $this->assignRef('dispatcher', $dispatcher);

        $form_js = '
                function formValidate(f) {
                   if (document.formvalidator.isValid(f)) {
                      return true;
                   }
                   else {
                      alert("' . JText::_( 'COM_IPROPERTY_ENTER_REQUIRED' ) . '");
                   }
                   return false;
                }';
        $document->addScriptDeclaration( $form_js );
        
        $this->_prepareDocument($agent);
		parent::display();
    }

    function _displayNoAccess($tpl = null)
    {
        $app  = JFactory::getApplication();
        $option     = JRequest::getCmd('option');

        $document       = JFactory::getDocument();
        $settings       = ipropertyAdmin::config();

        $document->setTitle( JText::_( 'COM_IPROPERTY_NO_ACCESS' ) );
        $this->assignRef('settings', $settings);

        parent::display($tpl);
    }
    
    function _displayNoResult($tpl = null)
    {
        $app  = JFactory::getApplication();
        $option     = JRequest::getCmd('option');

        $document       = JFactory::getDocument();
        $settings       = ipropertyAdmin::config();
        $this->ipbaseurl = JURI::root(true);

        $document->setTitle( JText::_( 'COM_IPROPERTY_NO_RESULTS' ) );

        parent::display($tpl);
    }
}

?>
