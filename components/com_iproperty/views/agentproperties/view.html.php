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

class IpropertyViewAgentProperties extends JView
{
	function display($tpl = null)
	{
        $app  = JFactory::getApplication();
        $option     = JRequest::getCmd('option');
        $this->params   = $app->getParams();

		JHTML::_('behavior.tooltip');
        JPluginHelper::importPlugin( 'iproperty' );
        $dispatcher = JDispatcher::getInstance();
	
		$featured = '';
        $this->ipbaseurl    = JURI::root(true);
        $document           = JFactory::getDocument();
		$settings           = ipropertyAdmin::config();
        $this->ipauth       = new ipropertyHelperAuth();
	
		$model          = $this->getModel();
		$properties		= $this->get('data');
        $agent          = $this->get('agent');
        $pagination     = $this->get('Pagination');
        if($settings->show_featured) $featured = $this->get('featured');
        
        if(!$agent){
            $this->_displayNoResult('noresult');
            return;
        }
        
        // include gmap if we need it
        if($this->params->get('show_ip_gmap', 0) && $properties){
            ipropertyHTML::doCatmap($document, $this->params, $properties);
        }        
        
        //create toolbar
        $dispatcher->trigger( 'onBeforeRenderToolbar', array( &$settings ) );
		$extra = array();
        $extra['agentid']  = JRequest::getVar('id');
		echo ipropertyHTML::buildToolbar('agentproperties', $extra);

        //search criteria
        $stype          = $this->get('stype');
        $ptype          = $this->get('ptype');
		$city           = $this->get('city');
		$curstate       = $this->get('curstate');
        $province       = $this->get('province');
        $county         = $this->get('county');
        $region         = $this->get('region');
        $country        = $this->get('country');
        $beds           = $this->get('beds');
        $baths          = $this->get('baths');
        $search         = $this->get('search');
        $price_low      = $this->get('pricelow');
        $price_high     = $this->get('pricehigh');
        $sort           = $this->get('sort');
        $order          = $this->get('order');

		$lists = array();
		$lists['sort']      = ipropertyHTML::buildSortList($sort, 'class="inputbox"');
        $lists['order']     = ipropertyHTML::buildOrderList($order, 'class="inputbox"');
        $lists['cat']       = ipropertyHTML::multicatSelectList('cat','class="inputbox"', $ptype);
        $lists['stype']     = ipropertyHTML::stype_select_list('stype','class="inputbox"', $stype, true);
        $lists['city']      = ipropertyHTML::city_select_list('city','class="inputbox"', $city);
        $lists['state']     = ipropertyHTML::state_select_list('locstate','class="inputbox"', $curstate, true);
        $lists['province']  = ipropertyHTML::province_select_list('province','class="inputbox"', $province);
        $lists['county']    = ipropertyHTML::county_select_list('county','class="inputbox"', $county);
        $lists['region']    = ipropertyHTML::region_select_list('region','class="inputbox"', $region);
        $lists['country']   = ipropertyHTML::country_select_list('country','class="inputbox"', $country, true);
        $lists['beds']      = ipropertyHTML::beds_select_list('beds','class="inputbox"', $beds);
        $lists['baths']     = ipropertyHTML::baths_select_list('baths','class="inputbox"', $baths,0);
        $lists['search']    = $search;
        $lists['price_low'] = $price_low;
        $lists['price_high']= $price_high;        
	
		$agent_photo_width    = ( $settings->agent_photo_width ) ? $settings->agent_photo_width : '90';
        $agents_folder        = $this->ipbaseurl.'/media/com_iproperty/agents/';
        $thumb_width          = ( $settings->thumbwidth ) ? $settings->thumbwidth . 'px' : '200px';
		$thumb_height         = round((( $thumb_width ) / 1.5 ), 0) . 'px';
        $enable_featured      = $settings->show_featured;
        $picfolder            = $this->ipbaseurl.$settings->imgpath;

        $this->assignRef('properties', $properties);
        $this->assignRef('agent', $agent);
		$this->assignRef('lists', $lists);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('settings', $settings);
        $this->assignRef('featured', $featured);
        $this->assignRef('agent_photo_width', $agent_photo_width);
        $this->assignRef('agents_folder', $agents_folder);
        $this->assignRef('thumb_width', $thumb_width);
        $this->assignRef('thumb_height', $thumb_height);
        $this->assignRef('enable_featured', $enable_featured);
        $this->assignRef('folder', $picfolder);
        $this->assignRef('dispatcher', $dispatcher);

        $this->_prepareDocument($agent);
		
		parent::display($tpl);
	}

    protected function _prepareDocument($agent)
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

        $title = (is_object($menu) && $menu->query['view'] == 'agentproperties' && $menu->query['id'] == $agent->id) ? $menu->title : ipropertyHTML::getAgentName($agent->id).' '.JText::_( 'COM_IPROPERTY_PROPERTIES' );
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

        // set meta keywords
        $orig_metakey = $this->document->getMetaData('keywords');
        if( $agent->name ) $orig_metakey .= ','.$agent->name;
        if( $agent->companyname ) $orig_metakey .= ','.$agent->companyname;
        $this->document->setMetaData( 'keywords', $orig_metakey);

        // set meta description
		$orig_metadesc = $this->document->getMetaData('description');
        if( $agent->name ) $orig_metadesc .= '. '.$agent->name;
        if( $agent->companyname ) $orig_metadesc .= ', an agent of '.$agent->companyname;
		$this->document->setMetaData( "description", $orig_metadesc);

		// Breadcrumbs
        if(is_object($menu) && $menu->query['view'] != 'agentproperties') {
			$pathway->addItem($title);
		}
	}
    
    function _displayNoResult($tpl = null)
    {
        $app  = JFactory::getApplication();
        $option     = JRequest::getCmd('option');

        $document       = JFactory::getDocument();
        $settings       = ipropertyAdmin::config();

        $document->setTitle( JText::_( 'COM_IPROPERTY_NO_RESULTS' ) );

        parent::display($tpl);
    }
}

?>
