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

class IpropertyViewCompanies extends JView
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
        $companies      = $this->get('data');
        $pagination     = $this->get('Pagination');
        if($settings->co_show_featured) $featured = $this->get('featured');

        //search criteria
        $search         = $this->get('search');
		$sort           = $this->get('sort');
		$order          = $this->get('order');
		
		//create toolbar
        $dispatcher->trigger( 'onBeforeRenderToolbar', array( &$settings ) );
        $extra = array();
		echo ipropertyHTML::buildToolbar('company', $extra);

        $lists = array();
        $lists['sort']      = ipropertyHTML::buildCompanySortList($sort, 'class="inputbox"');
        $lists['order']     = ipropertyHTML::buildOrderList($order, 'class="inputbox"');
        $lists['search']    = $search;
	
		$co_photo_width = ( $settings->company_photo_width ) ? $settings->company_photo_width : '90';
        $company_folder = $this->ipbaseurl.'/media/com_iproperty/companies/';

        $this->assignRef('companies', $companies);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('settings', $settings);
		$this->assignRef('company_photo_width', $co_photo_width);
        $this->assignRef('company_folder', $company_folder);
        $this->assignRef('lists', $lists);
        $this->assignRef('featured', $featured);
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

        $title = (is_object($menu) && $menu->query['view'] == 'companies') ? $menu->title : JText::_('COM_IPROPERTY_COMPANIES_TITLE');
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
        if(is_object($menu) && $menu->query['view'] != 'companies') {
			$pathway->addItem($title);
		}
	}
}

?>
