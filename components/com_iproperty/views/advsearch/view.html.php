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

class IpropertyViewAdvsearch extends JView
{
	function display($tpl = null)
	{

		
		$app            = JFactory::getApplication();
        $option         = JRequest::getCmd('option');
        $itemid         = (JRequest::getInt('recallSearch')) ? JRequest::getInt('recallSearch') : JRequest::getInt('Itemid', 99999);
        $this->params   = $app->getParams();
        
        
		JHTML::_('behavior.tooltip');
        JPluginHelper::importPlugin( 'iproperty' );
        $dispatcher = JDispatcher::getInstance();

		$this->ipbaseurl    = JURI::root(true);
        $document           = JFactory::getDocument();
		$settings           = ipropertyAdmin::config();
        $user               = JFactory::getUser();
        $this->ipauth       = new ipropertyHelperAuth();

        
        
        if(!$settings->googlemap_enable){
            $this->_displayNoAccess();
            return;
        }

        // this is the google v3 maps api, no key required
        $mapsurl = 'http://maps.google.com/maps/api/js?sensor=false';
        if ($this->params->get('adv_show_shapetools', $settings->adv_show_shapetools)) $mapsurl .= '&libraries=drawing';
        
        $document->addScript($mapsurl);
        $document->addScript($this->ipbaseurl.'/components/com_iproperty/assets/js/ipGmap.js');
        $document->addScript($this->ipbaseurl.'/components/com_iproperty/assets/js/Slider.js');
        $document->addScript($this->ipbaseurl.'/components/com_iproperty/assets/js/Slider.Extra.js');

        $model          = $this->getModel();
        $properties		= $this->get('data');
        $totalprops     = $this->get('total');

        //create toolbar
        $dispatcher->trigger( 'onBeforeRenderToolbar', array( &$settings ) );
        $extra = array();
        echo ipropertyHTML::buildToolbar('advsearch', $extra);      

        $this->assignRef('settings', $settings);
        $this->assignRef('dispatcher', $dispatcher);
        $this->assignRef('user', $user);

        $munits = (!$settings->measurement_units) ? JText::_( 'COM_IPROPERTY_SQFT2' ) : JText::_( 'COM_IPROPERTY_SQM2' );

        // check for template map and property preview icons
        $map_house_icon     = '/components/com_iproperty/assets/images/map/icon56.png';
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
			limit: ".$this->params->get('adv_perpage', $settings->adv_perpage)."
		}

        var inputOptions = {
            ".$this->_getInputs($settings)."
        }

        var sliderOptions = {
            ".$this->_getSliders($settings)."
        }

		window.addEvent((window.webkit) ? 'load' : 'domready', function(){
			var pw = new PropertyWidget($('mapCanvas'),{
                ipbaseurl: '".JURI::root()."',
                Itemid: ".$itemid.",
                showPreview: '".$this->params->get('adv_show_preview', $settings->adv_show_preview)."',
                noLimit: ".$this->params->get('adv_nolimit', $settings->adv_nolimit).",
                currencyFormat: '".$this->params->get('nformat', $settings->nformat)."',
                currencySymbol: '".$this->params->get('currency', $settings->currency)."',
                currencyPos: '".$this->params->get('currency_pos', $settings->currency_pos)."',
                marker: '".$map_house_icon."',
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

        $this->_prepareDocument();
     
        parent::display($tpl);
    }

    protected function _prepareDocument() 
    {
		$app            =& JFactory::getApplication();
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

		$title = JText::_( 'COM_IPROPERTY_ADVANCED_SEARCH' );
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
        if ($this->params->get('menu-meta_description', '')) $this->document->setDescription($this->params->get('menu-meta_description', ''));
        if ($this->params->get('menu-meta_keywords', '')) $this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords', ''));
        if ($this->params->get('robots')) $this->document->setMetadata('robots', $this->params->get('robots'));

		// Breadcrumbs
        if(is_object($menu) && $menu->query['view'] != 'advsearch') {
			$pathway->addItem($title);
		}
	}

    function _displayNoAccess($tpl = 'noaccess')
    {
        $app  =& JFactory::getApplication();
        $option     = JRequest::getCmd('option');

        $this->ipbaseurl    = JURI::root(true);
        $document           = JFactory::getDocument();
		$settings           = ipropertyAdmin::config();
        $pathway            = $app->getPathway();

        // Get the menu item object
        $menus =& JSite::getMenu();
        $menu  = $menus->getActive();

        $document->setTitle( JText::_( 'COM_IPROPERTY_ADVANCED_SEARCH' ));
        //set breadcrumbs
        if(is_object($menu) && $menu->query['view'] != 'advsearch') {
            $pathway->addItem(JText::_( 'COM_IPROPERTY_ADVANCED_SEARCH' ), '');
        }

        $this->assignRef('settings', $settings);

        parent::display($tpl);
    }

    protected function _getInputs($settings)
    {
        $input_script = '';
        
        $lists = array();
        $lists['cities']    = ipropertyHTML::city_select_list('', '', '', true);

        //Sale types
        if($this->params->get('adv_show_stype', $settings->adv_show_stype)){
            $lists['stypes']    = ipropertyHTML::stype_select_list('', '', '', true, true);

            $stypes = array();
            foreach($lists['stypes'] as $st){
                if($st->value) $stypes[] = "'".addslashes($st->text)."': ".(int)$st->value;
            }
            
            /* v2.0.1 predefined menu params - if set, predefine filter and disable */
            if($this->params->get('default_stype')){
                $stype_default  = (int)$this->params->get('default_stype');
                $stype_disabled = 'true';
            }else{
                $stype_default  = 'false';
                $stype_disabled = 'false';
            }
            
            $input_script .=
            "'stype': {
                title: '".addslashes(JText::_('COM_IPROPERTY_SALE_TYPE'))."',
                tag: 'select',
                parameter: 'stype',
                value: {".implode(',', $stypes)."},
                disabled: ".$stype_disabled.",
                group: 'stype',
                selected: ".$stype_default."
            },";
        }

        //Cities
        $cities = array();
        foreach($lists['cities'] as $ci){
            if($ci->value) $cities[] = "'".addslashes($ci->text)."': '".addslashes($ci->value)."'";
        }
        
        /* v2.0.1 predefined menu params - if set, predefine filter and disable */
        if($this->params->get('default_city')){
            $city_default  = "'".addslashes($this->params->get('default_city'))."'";
            $city_disabled = 'true';
        }else{
            $city_default  = 'false';
            $city_disabled = 'false';
        }
        
        $input_script .=
        "'city': {
            title: '".addslashes(JText::_('COM_IPROPERTY_CITY'))."',
            tag: 'select',
            parameter: 'city',
            value: {".implode(',', $cities)."},
            disabled: ".$city_disabled.",
            group: 'location',
            selected: ".$city_default."
        },";

        //Regions
        if($this->params->get('adv_show_region', $settings->adv_show_region)){
            $lists['regions']   = ipropertyHTML::region_select_list('', '', '', true);
            
            $regions = array();
            foreach($lists['regions'] as $r){
                if($r->value) $regions[] = "'".addslashes($r->text)."': '".addslashes($r->value)."'";
            }
            
            /* v2.0.1 predefined menu params - if set, predefine filter and disable */
            if($this->params->get('default_region')){
                $region_default  = "'".addslashes($this->params->get('default_region'))."'";
                $region_disabled = 'true';
            }else{
                $region_default  = 'false';
                $region_disabled = 'false';
            }
            
            $input_script .=
            "'region': {
                title: '".addslashes(JText::_('COM_IPROPERTY_REGION'))."',
                tag: 'select',
                parameter: 'region',
                value: {".implode(',', $regions)."},
                disabled: ".$region_disabled.",
                group: 'location',
                selected: ".$region_default."
            },";
        }

        //Counties
        if($this->params->get('adv_show_county', $settings->adv_show_county)){
            $lists['counties']  = ipropertyHTML::county_select_list('', '', '', true);
            
            $counties = array();
            foreach($lists['counties'] as $c){
                if($c->value) $counties[] = "'".addslashes($c->text)."': '".addslashes($c->value)."'";
            }
            
            /* v2.0.1 predefined menu params - if set, predefine filter and disable */
            if($this->params->get('default_county')){
                $county_default  = "'".addslashes($this->params->get('default_county'))."'";
                $county_disabled = 'true';
            }else{
                $county_default  = 'false';
                $county_disabled = 'false';
            }
            
            $input_script .=
            "'county': {
                title: '".addslashes(JText::_('COM_IPROPERTY_COUNTY'))."',
                tag: 'select',
                parameter: 'county',
                value: {".implode(',', $counties)."},
                disabled: ".$county_disabled.",
                group: 'location',
                selected: ".$county_default."
            },";
        }

        //State
        if($this->params->get('adv_show_locstate', $settings->adv_show_locstate)){
            $lists['states']    = ipropertyHTML::state_select_list('', '', '', true, true);

            $states = array();
            foreach($lists['states'] as $s){
                if($s->value) $states[] = "'".addslashes($s->text)."': ".(int)$s->value;
            }
            
            /* v2.0.1 predefined menu params - if set, predefine filter and disable */
            if($this->params->get('default_locstate')){
                $state_default  = (int)$this->params->get('default_locstate');
                $state_disabled = 'true';
            }else{
                $state_default  = 'false';
                $state_disabled = 'false';
            }
            
            $input_script .=
            "'locstate': {
                title: '".addslashes(JText::_('COM_IPROPERTY_STATE'))."',
                tag: 'select',
                parameter: 'locstate',
                value: {".implode(',', $states)."},
                disabled: ".$state_disabled.",
                group: 'location',
                selected: ".$state_default."
            },";
        }

        //Provinces
        if($this->params->get('adv_show_province', $settings->adv_show_province)){
            $lists['provinces'] = ipropertyHTML::province_select_list('', '', '', true);
            
            $provinces = array();
            foreach($lists['provinces'] as $pr){
                if($pr->value) $provinces[] = "'".addslashes($pr->text)."': '".addslashes($pr->value)."'";
            }
            
            /* v2.0.1 predefined menu params - if set, predefine filter and disable */
            if($this->params->get('default_province')){
                $province_default  = "'".addslashes($this->params->get('default_province'))."'";
                $province_disabled = 'true';
            }else{
                $province_default  = 'false';
                $province_disabled = 'false';
            }
            
            $input_script .=
            "'province': {
                title: '".addslashes(JText::_('COM_IPROPERTY_PROVINCE'))."',
                tag: 'select',
                parameter: 'province',
                value: {".implode(',', $provinces)."},
                disabled: ".$province_disabled.",
                group: 'location',
                selected: ".$province_default."
            },";
        }        

        //Country
        if($this->params->get('adv_show_country', $settings->adv_show_country)){
            $lists['countries'] = ipropertyHTML::country_select_list('', '', '', true, true);
            
            $countries = array();
            foreach($lists['countries'] as $c){
                if($c->value) $countries[] = "'".addslashes($c->text)."': ".(int)$c->value;
            }
            
            /* v2.0.1 predefined menu params - if set, predefine filter and disable */
            if($this->params->get('default_country')){
                $country_default  = (int)$this->params->get('default_country');
                $country_disabled = 'true';
            }else{
                $country_default  = 'false';
                $country_disabled = 'false';
            }
            
            $input_script .=
            "'country': {
                title: '".addslashes(JText::_('COM_IPROPERTY_COUNTRY'))."',
                tag: 'select',
                parameter: 'country',
                value: {".implode(',', $countries)."},
                disabled: ".$country_disabled.",
                group: 'location',
                selected: ".$country_default."
            },";
        }     

        //REO
        if($this->params->get('adv_show_reo', $settings->adv_show_reo)){
            $reo_checked = ($this->params->get('default_reo')) ? 'true' : 'false';
            $input_script .=
            "'reo': {
                title: '".addslashes(JText::_('COM_IPROPERTY_REO'))."',
                tag: 'input',
                type: 'checkbox',
                parameter: 'reo',
                disabled: ".$reo_checked.",
                group: 'stype',
                checked: ".$reo_checked."
            },";
        }

        //HOA
        if($this->params->get('adv_show_hoa', $settings->adv_show_hoa)){
            $hoa_checked = ($this->params->get('default_hoa')) ? 'true' : 'false';
            $input_script .=
            "'hoa': {
                title: '".addslashes(JText::_('COM_IPROPERTY_HOA'))."',
                tag: 'input',
                type: 'checkbox',
                parameter: 'hoa',
                disabled: ".$hoa_checked.",
                group: 'stype',
                checked: ".$hoa_checked."
            },";
        }

        //Waterfront
        if($this->params->get('adv_show_wf', $settings->adv_show_wf)){
            $wf_checked = ($this->params->get('default_waterfront')) ? 'true' : 'false';
            $input_script .=
            "'waterfront': {
                title: '".addslashes(JText::_('COM_IPROPERTY_WATER_FRONT'))."',
                tag: 'input',
                type: 'checkbox',
                parameter: 'waterfront',
                disabled: ".$wf_checked.",
                group: 'stype',
                checked: ".$wf_checked."
            },";
        }

        //Property types (check boxes)
        $cats = ipropertyHTML::getCategories('', 'parent, ordering ASC');        
        foreach($cats as $cat){
            $parent = (int) $cat->parent;
            $cat_default = ($this->params->get('default_cat') && $this->params->get('default_cat') == $cat->value) ? 'true' : 'false';
            $input_script .=
            "'cat".$cat->value."': {
                title: '".addslashes($cat->text)."',
				tag: 'input',
				type: 'checkbox',
				group: 'ptypes',
				parameter: 'ptype',
                disabled: ".$cat_default.",
				custom: true,
				value: ".$cat->value.",
                selected: ".$cat_default.",
                parent: ".$parent."
			},";
        }
        
        //New IP2.0.1 - add sort and order options
        //under development
        /*if($this->params->get('adv_show_sort')){
            $lists['sort'] = ipropertyHTML::buildSortList('', '', true, false, true);
            
            $sorts = array();
            foreach($lists['sort'] as $key => $value){
                if($key) $sorts[] = "'".addslashes($value)."': '".addslashes($key)."'";
            }
            $input_script .=
            "'filter_order': {
                title: '".addslashes(JText::_('COM_IPROPERTY_SORTBY'))."',
                tag: 'select',
                parameter: 'filter_order',
                value: {".implode(',', $sorts)."},
                group: 'location',
                selected: false
            },";
        }*/
      
        return substr($input_script, 0, -1);
    }

    protected function _getSliders($settings)
    {
        $slider_script = '';
        $lists = array();

        $max_price  = $this->params->get('adv_price_high', $settings->adv_price_high);
        $min_price  = $this->params->get('adv_price_low', $settings->adv_price_low);
        $max_beds   = $this->params->get('adv_beds_high', $settings->adv_beds_high);
        $min_beds   = $this->params->get('adv_beds_low', $settings->adv_beds_low);
        $max_baths  = $this->params->get('adv_baths_high', $settings->adv_baths_high);
        $min_baths  = $this->params->get('adv_baths_low', $settings->adv_baths_low);
        $max_sqft   = $this->params->get('adv_sqft_high', $settings->adv_sqft_high);
        $min_sqft   = $this->params->get('adv_sqft_low', $settings->adv_sqft_low);
        $no_limit   = $this->params->get('adv_nolimit', $settings->adv_nolimit);
        $currency   = $this->params->get('currency', $settings->currency);
        $currency_pos = $this->params->get('currency_pos', $settings->currency_pos);
        $currency_format = $this->params->get('currency_format', $settings->nformat);

        $sqft_header = ($settings->measurement_units) ? JText::_('COM_IPROPERTY_SQMDD') : JText::_('COM_IPROPERTY_SQFTDD');

        $sliders = array();
        if($this->params->get('show_price_sliders', 1)){
            $sliders[] =
            "'price': {
                title: '".addslashes(JText::_('COM_IPROPERTY_PRICE'))."',
                steps: 300,
                range: [".$min_price.", ".$max_price."],
                noLimit: ".$no_limit.",
                labelUnit: '".$currency."',
                labelPos: '".$currency_pos."',
                labelFormat: '".$currency_format."',
                start: {
                    parameter: 'price_low',
                    initialStep: ".$min_price.",
                    offset: 2
                },
                end: {
                    parameter: 'price_high',
                    initialStep: ".$max_price."
                }
            }";
        }
        
        if($this->params->get('show_beds_sliders', 1)){
            $sliders[] = 
            "'beds': {
                title: '".addslashes(JText::_('COM_IPROPERTY_BEDS'))."',
                steps: ".($max_beds - $min_beds).",
                snap: true,
                range: [".$min_beds.", ".$max_beds."],
                noLimit: ".$no_limit.",
                start: {
                    parameter: 'beds_low',
                    initialStep: ".$min_beds.",
                    offset: 2
                },
                end: {
                    parameter: 'beds_high',
                    initialStep: ".$max_beds."
                }
            }";
        }
        
        if($this->params->get('show_baths_sliders', 1)){
            $sliders[] = 
            "'baths': {
                title: '".addslashes(JText::_('COM_IPROPERTY_BATHS'))."',
                steps: ".($max_baths - $min_baths).",
                snap: true,
                range: [".$min_baths.", ".$max_baths."],
                noLimit: ".$no_limit.",
                start: {
                    parameter: 'baths_low',
                    initialStep: ".$min_baths.",
                    offset: 2
                },
                end: {
                    parameter: 'baths_high',
                    initialStep: ".$max_baths."
                }
            }";
        }
        
        if($this->params->get('show_sqft_sliders', 1)){        
            $sliders[] = 
            "'sqft': {
                title: '".addslashes($sqft_header)."',
                steps: ".($max_sqft - $min_sqft).",
                range: [".$min_sqft.", ".$max_sqft."],
                noLimit: ".$no_limit.",
                start: {
                    parameter: 'sqft_low',
                    initialStep: ".$min_sqft.",
                    offset: 2
                },
                end: {
                    parameter: 'sqft_high',
                    initialStep: ".$max_sqft."
                }
            }";
        }
        
        
        if(count($sliders)){
            $x = 0;
            foreach($sliders as $s){
                $slider_script .= $s;
                $x++;
                if($x < count($sliders)) $slider_script .= ",\n";
            }
        }
        return $slider_script;
    }
}

?>