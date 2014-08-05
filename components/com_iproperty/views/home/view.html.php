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

class IpropertyViewHome extends JView
{
	function display($tpl = null)
	{
		$app  = JFactory::getApplication();
        $option     = JRequest::getCmd('option');
        
        JHTML::_('behavior.tooltip');
        JPluginHelper::importPlugin( 'iproperty' );
        $dispatcher = JDispatcher::getInstance();
	
		$featured           = '';
        $this->ipbaseurl    = JURI::root(true);
        $document           = JFactory::getDocument();
		$settings           = ipropertyAdmin::config();
        $this->ipauth       = new ipropertyHelperAuth();
	
		$model          = $this->getModel();
		$catinfo		= $this->get('data');
		if($settings->show_featured) $featured = $this->get('featured');

        //create toolbar
		if( $tpl == null && !JRequest::getVar('layout') ){
            $dispatcher->trigger( 'onBeforeRenderToolbar', array( &$settings ) );
            echo ipropertyHTML::buildToolbar();
        }

        $thumb_width        = ( $settings->thumbwidth ) ? $settings->thumbwidth . 'px' : '200px';
		$thumb_height       = round((( $thumb_width ) / 1.5 ), 0) . 'px';
        $picfolder          = $this->ipbaseurl.$settings->imgpath;
        $catfolder          = $this->ipbaseurl.'/media/com_iproperty/categories/';

        $this->assignRef('catinfo', $catinfo);
		$this->assignRef('featured', $featured);
		$this->assignRef('lists', $lists);
		$this->assignRef('settings', $settings);
        $this->assignRef('thumb_width', $thumb_width);
        $this->assignRef('thumb_height', $thumb_height);
        $this->assignRef('folder', $picfolder);
        $this->assignRef('cat_folder', $catfolder);
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

		$title = (is_object($menu) && $menu->query['view'] == 'home') ? $menu->title : JText::_( 'COM_IPROPERTY_INTELLECTUAL_PROPERTY' );
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
        if(is_object($menu) && $menu->query['view'] != 'home') {
			$pathway->addItem($title);
		}
	}
}

?>
