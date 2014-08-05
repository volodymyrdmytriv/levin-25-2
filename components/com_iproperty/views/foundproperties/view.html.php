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

class IpropertyViewFoundProperties extends JView
{
	function display($tpl = null)
	{
		$app  = JFactory::getApplication();
        $option = JRequest::getCmd('option');
        $itemid = (JRequest::getInt('recallSearch')) ? JRequest::getInt('recallSearch') : JRequest::getInt('Itemid', 99999);
        $property_type = JRequest::getString('property_type', '');
        $property_state = JRequest::getString('property_state', '');
        $property_city = JRequest::getString('property_city', '');
        $property_space = JRequest::getString('property_space', '');
        $space_slider_values = JRequest::getString('space_slider_values', '');
        
        require_once('administrator'.DS.'components'.DS.'com_iproperty'.DS.'models'.DS.'company.php');
        $company_model = new IpropertyModelCompany();
		$portfolio_avail_report = $company_model->getFilesByTitle(IpropertyModelCompany::$LEVIN_MANAGEMENT_ID, 'portfolio_avail_report');
        $companies_folder = JURI::root(true).'/media/com_iproperty/companies/';
        
        
        $this->params   = $app->getParams();
        $settings           = ipropertyAdmin::config();
        
        
        
		JHTML::_('behavior.tooltip');
        JPluginHelper::importPlugin( 'iproperty' );
        $dispatcher = JDispatcher::getInstance();
	
		$featured = '';
        $this->ipbaseurl    = JURI::root(true);
        $document           = JFactory::getDocument();
		$settings           = ipropertyAdmin::config();
        $this->ipauth       = new ipropertyHelperAuth();
		
		//create toolbar
        $dispatcher->trigger( 'onBeforeRenderToolbar', array( &$settings ) );
        $extra = array();
		echo ipropertyHTML::buildToolbar('allproperties', $extra);
		
		$document->addScript($this->ipbaseurl.'/media/system/js/mootools-core.js');
		
		// CREATING MAP
		// this is the google v3 maps api, no key required
        //$mapsurl = 'http://maps.google.com/maps/api/js?sensor=false';
        $mapsurl = 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false';
        if ($this->params->get('adv_show_shapetools', $settings->adv_show_shapetools)) $mapsurl .= '&libraries=drawing';
        
        $document->addScript($mapsurl);
        $document->addScript($this->ipbaseurl.'/components/com_iproperty/assets/js/ipGmap.js');
        
        // check for template map and property preview icons
        $map_house_icon     = '/components/com_iproperty/assets/images/map/icon56.png';
        $map_marker     = '/components/com_iproperty/assets/images/map/marker.png';
        $map_preview_icon   = '/components/com_iproperty/assets/images/map/map_preview.png';
        $prop_preview_icon  = '/components/com_iproperty/assets/images/map/prop_preview.png';
        $templatepath        = $app->getTemplate();
        if(JFile::exists('templates'.DS.$templatepath.DS.'images'.DS.'iproperty'.DS.'map'.DS.'icon56.png')) $map_house_icon = '/templates/'.$templatepath.'/images/iproperty/map/icon56.png';
        if(JFile::exists('templates'.DS.$templatepath.DS.'images'.DS.'iproperty'.DS.'map'.DS.'map_preview.png')) $map_preview_icon = '/templates/'.$templatepath.'/images/iproperty/map/map_preview.png';
        if(JFile::exists('templates'.DS.$templatepath.DS.'images'.DS.'iproperty'.DS.'map'.DS.'prop_preview.png')) $prop_preview_icon = '/templates/'.$templatepath.'/images/iproperty/map/prop_preview.png';
        
        $mapscript = "
        var langOptions = {
            tprop:'".addslashes(JText::_('COM_IPROPERTY_RESULTS'))."',
            price:'".addslashes(JText::_('COM_IPROPERTY_PRICE'))."',
            nolimit: '".addslashes(JText::_('COM_IPROPERTY_NO_LIMIT'))."',
            pid: '".addslashes(JText::_('COM_IPROPERTY_PROPERTY_ID'))."',
            street: '".addslashes(JText::_('COM_IPROPERTY_STREET'))."',
            beds: '".addslashes(JText::_('COM_IPROPERTY_BEDS'))."',
            baths: '".addslashes(JText::_('COM_IPROPERTY_BATHS'))."',
            sqft: '".addslashes($munits)."',
            preview: '".addslashes(JText::_('COM_IPROPERTY_PREVIEW'))."',
            more: '".addslashes(JText::_('COM_IPROPERTY_MORE' ))."',
            inputText: '".addslashes(JText::_('COM_IPROPERTY_INPUT_TIP'))."',
            noRecords: '".addslashes(JText::_('COM_IPROPERTY_NO_RECORDS_TEXT'))."',
            previous: '".addslashes(JText::_('COM_IPROPERTY_PREVIOUS'))."',
            next: '".addslashes(JText::_('COM_IPROPERTY_NEXT'))."',
            of: '".addslashes(JText::_('COM_IPROPERTY_OF'))."',
            searchopt: '".addslashes(JText::_('COM_IPROPERTY_SEARCH_OPTIONS'))."',
            savesearch: '".addslashes(JText::_('COM_IPROPERTY_SAVESEARCH'))."',
            clearsearch: '".addslashes(JText::_('COM_IPROPERTY_CLEARSEARCH'))."'
        };

        var mapOptions = {
            zoom: ".$this->params->get('adv_default_zoom', $settings->adv_default_zoom).",
            maxZoom: ".$this->params->get('max_zoom', $settings->max_zoom).",
            mapTypeId: google.maps.MapTypeId.".$this->params->get('adv_maptype', $settings->adv_maptype).",
            lat: '".$this->params->get('adv_default_lat', $settings->adv_default_lat)."',
            lng: '".$this->params->get('adv_default_long', $settings->adv_default_long)."'
        }

        var searchOptions = {
        	property_type: '".JRequest::getString('property_type', '')."',
        	property_state: '".JRequest::getString('property_state', '')."',
        	property_city: '".JRequest::getString('property_city', '')."',
        	property_space: '".JRequest::getString('property_space', '')."'
		}

        var inputOptions = {
        }

        var sliderOptions = {
        }

        var propertyWidget1;
        
		window.addEvent((window.webkit) ? 'load' : 'domready', function(){
			
			jQuery.noConflict();
			
			propertyWidget1 = new PropertyWidget($('mapCanvas'),{
                ipbaseurl: '".JURI::root()."',
                Itemid: ".$itemid.",
                showPreview: '".$this->params->get('adv_show_preview', $settings->adv_show_preview)."',
                noLimit: ".$this->params->get('adv_nolimit', $settings->adv_nolimit).",
                currencyFormat: '".$this->params->get('nformat', $settings->nformat)."',
                currencySymbol: '".$this->params->get('currency', $settings->currency)."',
                currencyPos: '".$this->params->get('currency_pos', $settings->currency_pos)."',
                marker: '".$map_marker."',
                token: '".JFactory::getSession()->getFormToken()."',
                thumbnail: ".$this->params->get('adv_show_thumb', $settings->adv_show_thumb).",
                slideColor: '".$this->params->get('accent', $settings->accent)."',
                mapPreviewIcon: '".$map_preview_icon."',
                propPreviewIcon: '".$prop_preview_icon."',
                saveSearch: '".$settings->show_savesearch."',
                advLayout: '".$this->params->get('adv_layout', 'table')."',
                openCriteria: ".$this->params->get('adv_criteria', 0).",
                nestedCats: '".$this->params->get('adv_nestedcats', 0)."',
                catCols: '".$this->params->get('adv_catcols', 3)."',
                isMobile: '".ipropertyHTML::isMobileRequest()."',
                text: langOptions,
                map: mapOptions,
                search: searchOptions,
                inputs: inputOptions,
                sliders: sliderOptions,
                shapetools: ".$this->params->get('adv_show_shapetools', $settings->adv_show_shapetools)."
            });
		});";
        $document->addScriptDeclaration($mapscript);
        //////////////////
		
        $model          = $this->getModel();
        $types = $this->get('types');
        $avail_states = $this->get('availStates');
        $avail_cities = $this->get('availCities');
		$properties		= $this->get('properties');
		$pagination     = $this->get('Pagination');
        if($settings->cat_featured) $featured = $this->get('featured');
        
        // include gmap if we need it
        if($this->params->get('show_ip_gmap', 0) && $properties){
            ipropertyHTML::doCatmap($document, $this->params, $properties);
        }

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
        $lists['stype']     = ipropertyHTML::stype_select_list('stype','class="inputbox"', $stype, true);
        $lists['cat']       = ipropertyHTML::multicatSelectList('cat','class="inputbox"', $ptype);
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

        $thumb_width        = ( $settings->thumbwidth ) ? $settings->thumbwidth . 'px' : '200px';
		$thumb_height       = round((( $thumb_width ) / 1.5 ), 0) . 'px';
        $picfolder          = $this->ipbaseurl.$settings->imgpath;
        $enable_featured    = $settings->show_featured;
		
        $this->assignRef('property_type', $property_type);
        $this->assignRef('property_state', $property_state);
        $this->assignRef('property_city', $property_city);
        $this->assignRef('property_space', $property_space);
        $this->assignRef('space_slider_values', $space_slider_values);
        $this->assignRef('portfolio_avail_report', $portfolio_avail_report);
        $this->assignRef('companies_folder', $companies_folder);
        
        $this->assignRef('types', $types);
        $this->assignRef('avail_states', $avail_states);
        $this->assignRef('avail_cities', $avail_cities);
        
        $this->assignRef('properties', $properties);
		$this->assignRef('lists', $lists);
        $this->assignRef('featured', $featured);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('settings', $settings);
        $this->assignRef('thumb_width', $thumb_width);
        $this->assignRef('thumb_height', $thumb_height);
        $this->assignRef('enable_featured', $enable_featured);
        $this->assignRef('folder', $picfolder);
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

        $title = (is_object($menu) && $menu->query['view'] == 'allproperties') ? $menu->title : JText::_( 'COM_IPROPERTY_ALL_PROPERTIES' );
        $this->iptitle = (JRequest::getInt('ipquicksearch')) ? '' : $title; // we don't show the title if quicksearch is in the url
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
        if(is_object($menu) && $menu->query['view'] != 'allproperties') {
			$pathway->addItem($title);
		}
	}
}

?>
