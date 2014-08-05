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

class IpropertyViewAgents extends JView
{
	function display($tpl = null)
	{
		$app  = JFactory::getApplication();
        $option     = JRequest::getCmd('option');

		JHTML::_('behavior.tooltip');
        JPluginHelper::importPlugin( 'iproperty' );
        $dispatcher = JDispatcher::getInstance();
	
		$featured = '';
        $this->ipbaseurl    = JURI::root(true);
        $document           = JFactory::getDocument();
		$settings           = ipropertyAdmin::config();
        $this->ipauth       = new ipropertyHelperAuth();
		
		$model          = $this->getModel();
        $agents         = $this->get('data');
        $pagination     = $this->get('Pagination');
        if($settings->agent_show_featured) $featured = $this->get('featured');

        //search criteria
        $search         = $this->get('search');
        $company        = $this->get('company');
		$sort           = $this->get('sort');
		$order          = $this->get('order');
		
		//create toolbar
        $dispatcher->trigger( 'onBeforeRenderToolbar', array( &$settings ) );
        $extra = array();
		echo ipropertyHTML::buildToolbar('agents', $extra);       

        $lists = array();
        $lists['company']   = ipropertyHTML::companySelectList('company', 'class="inputbox"', $company);
        $lists['sort']      = ipropertyHTML::buildAgentSortList($sort, 'class="inputbox"');
        $lists['order']     = ipropertyHTML::buildOrderList($order, 'class="inputbox"');
        $lists['search']    = $search;
	
		$agent_photo_width  = ( $settings->agent_photo_width ) ? $settings->agent_photo_width : '90';
        $agents_folder      = $this->ipbaseurl.'/media/com_iproperty/agents/';

        $this->assignRef('agents', $agents);
		$this->assignRef('pagination', $pagination);
        $this->assignRef('featured', $featured);
		$this->assignRef('settings', $settings);
        $this->assignRef('agent_photo_width', $agent_photo_width);
        $this->assignRef('agents_folder', $agents_folder);
        $this->assignRef('lists', $lists);
        $this->assignRef('dispatcher', $dispatcher);

        $this->_prepareDocument();
        parent::display($tpl);
	}
    
    protected function _prepareDocument()
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

        $title = (is_object($menu) && $menu->query['view'] == 'agents') ? $menu->title : JText::_('COM_IPROPERTY_AGENTS_TITLE');
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
        if(is_object($menu) && $menu->query['view'] != 'agents') {
			$pathway->addItem($title);
		}
	}
}

?>
