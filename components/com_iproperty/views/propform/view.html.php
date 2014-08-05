<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');
JHtml::_('behavior.framework', true);

class IpropertyViewPropForm extends JView
{
    protected $form;
    protected $item;
    protected $return_page;
    protected $state;
    protected $settings;
    protected $ipauth;
    protected $gmapOk;
    protected $dispatcher;
    protected $iptitle;

    public function display($tpl = null)
    {
        // Initialise variables.
        $app        = JFactory::getApplication();
        $document   = JFactory::getDocument();
        $user       = JFactory::getUser();
        
		// add autocompleter stuff
		$document->addStyleSheet(JURI::root(true)."/components/com_iproperty/assets/js/autocomplete/autocompleter.css");
		$document->addScript(JURI::root(true).'/components/com_iproperty/assets/js/autocomplete/Observer.js');
		$document->addScript(JURI::root(true).'/components/com_iproperty/assets/js/autocomplete/Autocompleter.js');
		$document->addScript(JURI::root(true).'/components/com_iproperty/assets/js/autocomplete/Autocompleter.Request.js');        
        
        // Make sure to include admin language file for form fields
        JFactory::getLanguage()->load('com_iproperty', JPATH_ADMINISTRATOR);

        // Get model data.
        $this->state        = $this->get('State');
        $this->item         = $this->get('Item');
        $this->form         = $this->get('Form');
        $this->return_page  = $this->get('ReturnPage');
        $this->settings     = ipropertyAdmin::config();
        $this->ipauth       = new ipropertyHelperAuth();

        // Import IP plugins for additional form tabs (IPresserve, IReport)
        JPluginHelper::importPlugin( 'iproperty' );
        $this->dispatcher = JDispatcher::getInstance();

        if (empty($this->item->id)) {
            $authorised = $this->ipauth->canAddProp();
        }
        else {
            $authorised = $this->ipauth->canEditProp($this->item->id);
        }

        if (!$authorised) {
            JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
            return false;
        }

        if (!empty($this->item)) {
            $this->form->bind($this->item);
        }

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseWarning(500, implode("\n", $errors));
            return false;
        }

        // Create a shortcut to the parameters.
        $params = &$this->state->params;

        //Escape strings for HTML output
        $this->pageclass_sfx = htmlspecialchars($params->get('pageclass_sfx'));

        $this->params   = $params;
        $this->user     = $user;

        // If editing an existing listing, display gallery js
        if($this->item->id):
            $app = JFactory::getApplication();
            $document->addScript( JURI::root(true).'/components/com_iproperty/assets/js/ipsortables.js');
            $document->addScript( JURI::root(true).'/components/com_iproperty/assets/js/ipdocs.js');

            $sortable_js = '
                var gallerySorter = null;
                var docsorter = null;
                window.addEvent("domready", function(){
                    var gallery_options = {
                        propid: "'.$this->item->id.'",
                        iptoken: "'.JUtility::getToken().'",
                        ipbaseurl: "'.rtrim(JURI::root(), '/').'",
                        iplimitstart: 0,
                        iplimit: 20,
                        debug: false,
                        language: {
                            save: "'.addslashes(JText::_('COM_IPROPERTY_SAVE')).'",
                            del: "'.addslashes(JText::_('COM_IPROPERTY_DELETE')).'",
                            iptitletext: "'.addslashes(JText::_('COM_IPROPERTY_TITLE')).'",
                            ipdesctext: "'.addslashes(JText::_('COM_IPROPERTY_DESCRIPTION')).'",
                            noresults: "'.addslashes(JText::_('COM_IPROPERTY_NO_RESULTS')).'",
                            updated: "'.addslashes(JText::_('COM_IPROPERTY_UPDATED')).'",
                            notupdated: "'.addslashes(JText::_('COM_IPROPERTY_NOT_UPDATED')).'",
                            previous: "'.addslashes(JText::_('COM_IPROPERTY_PREVIOUS')).'",
                            next: "'.addslashes(JText::_('COM_IPROPERTY_NEXT')).'",
                            of: "'.addslashes(JText::_('COM_IPROPERTY_OF')).'",
                            fname: "'.addslashes(JText::_('COM_IPROPERTY_FNAME')).'",
							overlimit: "'.addslashes(JText::_('COM_IPROPERTY_OVERIMGLIMIT')).'"
                        },
                        client: "'.$app->getName().'"
                    };
                    gallerySorter = new ipSortableGallery(gallery_options);
                    docSorter = new ipSortableDocuments(gallery_options);
                });';
            $document->addScriptDeclaration( $sortable_js );

            // PLUPLOAD STUFF HERE //
            $document->addStyleSheet( JURI::root(true)."/components/com_iproperty/assets/js/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css" );
            $document->addScript( "http://bp.yahooapis.com/2.4.21/browserplus-min.js" );
            
            // check if jQuery is loaded before adding it
            if (!JFactory::getApplication()->get('jquery')) {
                JFactory::getApplication()->set('jquery', true);
                $document->addScript( "https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js" );
            }
            $document->addScript( JURI::root(true)."/components/com_iproperty/assets/js/plupload/js/plupload.full.js" );
            $document->addScript( JURI::root(true)."/components/com_iproperty/assets/js/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js" );
            
            // include language file for uploader if it exists
            $curr_lang = JFactory::getLanguage();
            if(JFile::exists(JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'assets'.DS.'js'.DS.'plupload'.DS.'js'.DS.'i18n'.DS.$curr_lang->get('tag').'.js')){
                $document->addScript( JURI::root(true)."/components/com_iproperty/assets/js/plupload/js/i18n/".$curr_lang->get('tag').".js" );
            }

            $gallery_script= "
                var ipbaseurl       = '".rtrim(JURI::root(), '/')."';
                var pluploadpath    = '".JURI::root()."components/com_iproperty/assets/js';
                var ipthumbwidth    = '".$this->settings->thumbwidth."';
                var ipmaximagesize  = '".$this->settings->maximgsize."';

                jQuery.noConflict();
                jQuery(document).ready(function($) {
                    $('#ipUploader').pluploadQueue({
                        // General settings
                        runtimes : 'gears,flash,silverlight,browserplus,html5',
                        url : ipbaseurl+'/index.php?option=com_iproperty&task=ajax.ajaxUpload&format=raw&propid=".$this->item->id."&".JUtility::getToken()."=1&sessionid=".session_id()."',
                        max_file_size : ipmaximagesize+'kb',
                        unique_names : true,
                        multipart: true,
                        urlstream_upload: true,
                        multiple_queues: true,

                        // Specify what files to browse for
                        filters : [
                            {title : \"Files\", extensions : \"jpg,gif,png,pdf,doc,txt\"}
                        ],

                        // Flash settings
                        flash_swf_url : pluploadpath+'/plupload/js/plupload.flash.swf',

                        // Silverlight settings
                        silverlight_xap_url : pluploadpath+'/plupload/js/plupload.silverlight.xap',

                        init : {
                            Error: function(up, args) {
                                // Called when a error has occured
                                //console.dir(args);
                            },
                            FileUploaded: function(up, file, res) {
                                var response = jQuery.parseJSON(res['response']);
                                if(response[0].status == 1){                    
                                    window.gallerySorter.getImages(1);
                                    window.docSorter.getImages(1);
                                } else {
                                    if(response[0].message == 'overlimit'){
                                        alert('".addslashes(JText::_('COM_IPROPERTY_OVERIMGLIMIT'))."');
                                    } else {
                                        console.log(response[0].message);
                                    }
                                }
                            }
                        }
                    });
                });"."\n";
            $document->addScriptDeclaration( $gallery_script );
        endif;

        // If gmaps setting is enabled, display map js
        if($this->settings->googlemap_enable):
            $this->gmapOK = true;

            $lat        = ($this->item->latitude) ? $this->item->latitude : $this->settings->adv_default_lat;
            $lon        = ($this->item->longitude) ? $this->item->longitude : $this->settings->adv_default_long;
            $start_zoom = ($this->item->latitude) ? '13' : $this->settings->adv_default_zoom;

            //add css and js to document
            $document->addScript( "http://maps.google.com/maps/api/js?sensor=false" );

            $gscript = "
                var map         = null;
                var marker      = null;
                var start_lat   = '".$lat."';
                var start_lon   = '".$lon."';
                var start_zoom  = ".(int)$start_zoom.";
                toggler         = 0;

                function init() {
                    //var zoom    = 13;
                    var coord   = new google.maps.LatLng(start_lat, start_lon);

                    var mapoptions = {
                        zoom: start_zoom,
                        center: coord,
                        mapTypeControl: true,
                        navigationControl: true,
                        streetViewControl: false,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    }

                    // create the map
                    var map = new google.maps.Map(document.getElementById('map'),mapoptions);

                    var marker  = new google.maps.Marker({
                        position: coord,
                        draggable: true,
                        visible: true,
                        clickable: false,
                        map: map
                    });

                    toggler = 1;

                    google.maps.event.addListener(marker, 'dragend', function(event) {
                        latlng  = marker.getPosition();
                        lat     = latlng.lat();
                        lon     = latlng.lng();
                        document.getElementById('jform_latitude').value   = lat;
                        document.getElementById('jform_longitude').value  = lon;
                    });

                    document.id('prop_tabs').getElement('dt.location_panel').addEvent('click', function(e){
                        setTimeout( function() {
                            google.maps.event.trigger(map, 'resize');
                            map.setCenter(coord);
                        }, 10);
                    });

                    map.setZoom( map.getZoom() );
                }
                google.maps.event.addDomListener(window, 'load', init);";

            $document->addScriptDeclaration($gscript);
        endif;

        $this->_prepareDocument();
        parent::display($tpl);
    }

    protected function _prepareDocument()
    {
        $app        = JFactory::getApplication();
        $menus      = $app->getMenu();
        $pathway    = $app->getPathway();
        $title      = null;

        $menu = $menus->getActive();
        if ($menu) {
            $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
        } else {
            $this->params->def('page_heading', JText::_( 'COM_IPROPERTY_FORM_EDIT_PROPERTY' ));
        }

        $title = ($this->item->id) ? JText::_('JACTION_EDIT').': '.$this->item->street_address : JText::_( 'COM_IPROPERTY_FORM_ADD_PROPERTY' );
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

        $pathway = $app->getPathWay();
        $pathway->addItem($title, '');

        if ($this->params->get('menu-meta_description'))
        {
            $this->document->setDescription($this->params->get('menu-meta_description'));
        }

        if ($this->params->get('menu-meta_keywords'))
        {
            $this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
        }

        if ($this->params->get('robots'))
        {
            $this->document->setMetadata('robots', $this->params->get('robots'));
        }
    }
}
