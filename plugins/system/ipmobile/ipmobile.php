<?php
/**
 * @version 2.0 2012-08-13
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 * adapted from sh404sef
 * shmobile plugin by Yannick Gaultier
 * anything-digital.com
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin');
require_once(JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'helpers'.DS.'html.helper.php');
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_iproperty'.DS.'classes'.DS.'admin.class.php');

class  plgSystemIpmobile extends JPlugin 
{
    public function onAfterDispatch() 
    {
        $app = &JFactory::getApplication();
        if ($app->isAdmin()) return;

        // check for mobile user
        if (ipropertyHTML::isMobileRequest()) $this->_mobilizeIP();
    }

    protected function _mobilizeIP() 
    {
        if(JRequest::getCmd('option') != 'com_iproperty') return;

        $document   = JFactory::getDocument();
        $settings   = ipropertyAdmin::config();
        JHTML::_('behavior.mootools');
        
        $accent_color       = $this->params->get('ipmobile_accent', $settings->accent);
        $secondary_accent   = $this->params->get('ipmobile_secondary_accent', $settings->secondary_accent);
        $img_width          = $this->params->get('ipmobile_imgwidth', '150');
        $map_height         = $this->params->get('ipmobile_mapheight', '150');
        $toggle_text        = addslashes(JText::_($this->params->get('ipmobile_toggle_text', 'Toggle Search Criteria')));
        $website_text       = addslashes(JText::_($this->params->get('ipmobile_website_text', 'View Website')));
        
        // Add custom css and scripts for mobile devices
        $document->addStyleSheet(JURI::root(true).'/plugins/system/ipmobile/css/ipmobile.css');
        $document->addScript(JURI::root(true).'/plugins/system/ipmobile/js/custom-drag.js');        
        $document->addScript(JURI::root(true).'/plugins/system/ipmobile/js/custom-slide.js');        
        if(JRequest::getCmd('view') == 'advsearch'){
            $document->addScript(JURI::root(true).'/plugins/system/ipmobile/js/custom-gmap.js');
        }
        
        if(JPluginHelper::isEnabled('iproperty', 'ipcaptcha')){
            $useCaptcha = true;
            $plugin = JPluginHelper::getPlugin('iproperty', 'ipcaptcha');
            $captcha_params = new JParameter($plugin->params);
        }
        
        $mscript = '
            window.addEvent((window.webkit) ? "load" : "domready", function(){                        
                // convert tables, rows and cells to divs
                document.getElements("table, tr, td, .ip_form_table, .ip_form_table tr, .ip_form_table td, .ipamen_table, .ipamen_table tr, .ipamen_table td, .ip_details_table_container, .ip_details_table_container tr, .ip_details_table_container td").each(function(el) {
                    if(el){
                        new Element("div", {
                            style: "display: block; text-align: left;",
                            class: el.get("class"),
                            id: el.get("id"),
                            html: el.get("html")
                        }).replaces(el);
                    }
                });

                // convert phone container divs to click-to-call links
                $$(".ip_phone_container").each(function(el) {
                    new Element("a", {
                        href: "tel:"+el.get("html"),
                        class: el.get("class"),
                        html: el.get("html"),
                        styles: {color: "'.$accent_color.'"}
                    }).replaces(el);
                });

                // convert website links html to "view website" instead of web address - some are too long and break the layout
                $$(".ip_website_container").each(function(el) {
                    new Element("span", {
                        class: el.get("class"),
                        html: "'.$website_text.'",
                        styles: {color: "'.$accent_color.'"}
                    }).replaces(el);
                });  

                // simplify header bar - onlys show results number instead of full title
                $$(".property_header").set("html", $$(".property_header_results").get("html"));

                if($("ip_quicksearch_form")){
                    var formSlide = new Fx.Slide("ip_quicksearch_form").hide();
                    var newContainer = new Element("div", {
                        html: "'.$toggle_text.'",
                        "class": "advsearch_toggle"
                    }).addEvent("click", function(e){
                        e = new Event(e);
                        if(!this.hasClass("pressed")){
                            this.addClass("pressed");
                        }
                        formSlide.toggle();
                        e.stop();
                    }).inject($("main_ipfilter_container"), "before").adopt(formSlide);
                }
                ';
        
            /* Property details specific code - don't want to throw errors since these divs don't exist in other views */
            if(JRequest::getVar('view') == 'property' && JRequest::getVar('layout') != 'gallery'){
                $mscript .= '// Strip out first instance of side column agent display
                            var sideCols = new Array();
                            document.getElements(".summary_sidecol").each(function(el) {
                                sideCols = [new Element("div", {
                                    style: "",
                                    class: "new_summary",
                                    id: el.get("id"),
                                    html: el.get("html")
                                })];
                            });

                            // Add the first instance of the side column agent display to the detailsPane div                            
                            $$(".ip_imagetab_thumb").addEvent("click", function(){
                                window.location = "'.JRoute::_('index.php?option=com_iproperty&view=property&id='.JRequest::getInt('id').'&layout=gallery').'";
                            });
                            sideCols[0].inject($("detailsPane"), "before");';

                if($useCaptcha){ //if using captcha we need to change the click event from tabs to input fields
                    switch($captcha_params->get('captcha_type')){
                        case '1': // original captcha
                            $mscript .= '$$(".rform_trigger").addEvent("click", function(e){
                                            e = new Event(e);
                                            showIpcaptcha("req");
                                            e.stop();
                                        });
                                        $$(".sform_trigger").addEvent("click", function(e){
                                            e = new Event(e);
                                            showIpcaptcha("stf");
                                            e.stop();
                                        });
                                        $$(".iform_trigger").addEvent("click", function(e){
                                            e = new Event(e);
                                            showIpcaptcha("info");
                                            e.stop();
                                        });';                   
                        break;
                        case '2': // reCaptcha
                            $mscript .= '$$(".rform_trigger").addEvent("click", function(e){
                                            e = new Event(e);
                                            showRecaptcha("recaptcha_div_req");
                                            e.stop();
                                        });
                                        $$(".sform_trigger").addEvent("click", function(e){
                                            e = new Event(e);
                                            showRecaptcha("recaptcha_div_stf");
                                            e.stop();
                                        });
                                        $$(".iform_trigger").addEvent("click", function(e){
                                            e = new Event(e);
                                            showRecaptcha("recaptcha_div_info");
                                            e.stop();
                                        });';
                        break;
                    }
                }
            }       
        
        $mscript .= '
            })';
        
        // Add script declaration to head
        $document->addScriptDeclaration($mscript);
        
        // Add custom styles depending on plugin params        
        $mstyle = '
            .ptable a, #prop_table a{color: '.$accent_color.' !important;}     
            .property_overview_title, .ip_sidecol_address, .iprow0{background: '.$secondary_accent.' !important;}
            #map_canvas, #property_map, #loading_div{height: '.$map_height.'px !important;}
            .property_thumb_holder, .ip_overview_thumb, .bubble_image img, .ip_gallery img{width: '.$img_width.'px !important;}
            .prop_overview_price{width: '.($img_width - 10).'px;}
            .ip_beds,.ip_baths,.ip_sqft,.ip_lotsize,.ip_lot_acres,.ip_yearbuilt,.ip_heat,
            .ip_garage_type,.ip_roof{background-color: '.$secondary_accent.' !important; border-top: solid 1px '.$accent_color.' !important; border-bottom: solid 1px '.$accent_color.' !important;}
            .ip_agent_details, .ip_company_details{background-color: '.$secondary_accent.' !important;}
            #ip_catmap{display: none !important;}
            .advsearch_toggle{background: '.$accent_color.' !important; color: '.$secondary_accent.' !important; padding: 10px; font-weight: bold; -webkit-border-radius: 6px;}            
            .adv_thumbnail{width: '.$img_width.'px;}
            .ip_mapright div{background: '.$secondary_accent.' !important; border-color: '.$accent_color.' !important;}
            .prop_overview_img, .prop_overview_desc, .ip_mapright, .ip_mapleft{width: 100% !important; display: block; float: left;}';
        
        // Add style declaration to head
        $document->addStyleDeclaration($mstyle);
    }
}