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
JHtml::_('behavior.framework', true);

class IpropertyViewProperty extends JView 
{
    protected $form;
	protected $item;
	protected $state;
    protected $settings;
    protected $ipauth;
    protected $gmapOk;
    protected $dispatcher;

	public function display($tpl = null)
	{       
        // Initialiase variables.
		$this->form		= $this->get('Form');
		$this->item		= $this->get('Item');
		$this->state	= $this->get('State');
        $this->settings = ipropertyAdmin::config(); 
        $this->ipauth   = new ipropertyHelperAuth();
        $this->gmapOk   = false; //false until proven true below
        
        // Import IP plugins for additional form tabs (IPresserve, IReport)
        JPluginHelper::importPlugin( 'iproperty' );
        $this->dispatcher = JDispatcher::getInstance();
        
        $document = JFactory::getDocument();
		
        // add jquery stuff
		// check if jQuery is loaded before adding it
        if (!JFactory::getApplication()->get('jquery')) {
           	JFactory::getApplication()->set('jquery', true);
           	//$document->addScript( "https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js" );
           	$document->addScript( "https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" );
           	
        }
        
        // add jquery ui staff
        $document->addStyleSheet(JURI::root(true)."/jQueryAssets/jquery-ui-1.10.4/themes/flick/jquery-ui.css");
		$document->addScript(JURI::root(true)."/jQueryAssets/jquery-ui-1.10.4/jquery-ui.js");
		//$document->addScript(JURI::root(true)."/jsAssets/json/json.js");
		
        
		// add autocompleter stuff
		$document->addStyleSheet(JURI::root(true)."/components/com_iproperty/assets/js/autocomplete/autocompleter.css");
		//$document->addScript(JURI::root(true).'/components/com_iproperty/assets/js/autocomplete/Observer.js');
		//$document->addScript(JURI::root(true).'/components/com_iproperty/assets/js/autocomplete/Autocompleter.js');
		//$document->addScript(JURI::root(true).'/components/com_iproperty/assets/js/autocomplete/Autocompleter.Request.js');
        
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

        // if no agent id and user is not admin - no access
        if (!$this->ipauth->getAdmin() && !$this->ipauth->getUagentId()){
            $this->setLayout('noaccess');
            $this->_displayNoAccess($tpl);
            return;
        }       
        
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
                            save: "'.JText::_('COM_IPROPERTY_SAVE').'",
                            del: "'.JText::_('COM_IPROPERTY_DELETE').'",
                            iptitletext: "'.JText::_('COM_IPROPERTY_TITLE').'",
                            ipdesctext: "'.JText::_('COM_IPROPERTY_DESCRIPTION').'",
                            noresults: "'.JText::_('COM_IPROPERTY_NO_RESULTS').'",
                            updated: "'.JText::_('COM_IPROPERTY_UPDATED').'",  
                            notupdated: "'.JText::_('COM_IPROPERTY_NOT_UPDATED').'",
                            previous: "'.JText::_('COM_IPROPERTY_PREVIOUS').'",
                            next: "'.JText::_('COM_IPROPERTY_NEXT').'",
                            of: "'.JText::_('COM_IPROPERTY_OF').'",
                            fname: "'.JText::_('COM_IPROPERTY_FNAME').'",
							overlimit: "'.JText::_('COM_IPROPERTY_OVERIMGLIMIT').'"
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
            
            // check if jQuery is loaded before adding it(on top)
            
            
            $document->addScript( JURI::root(true)."/components/com_iproperty/assets/js/plupload/js/plupload.full.js" );
            $document->addScript( JURI::root(true)."/components/com_iproperty/assets/js/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js" );
            
            // include language file for uploader if it exists
            $curr_lang = JFactory::getLanguage();
            if(JFile::exists(JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'assets'.DS.'js'.DS.'plupload'.DS.'js'.DS.'i18n'.DS.$curr_lang->get('tag').'.js')){
                $document->addScript( JURI::root(true)."/components/com_iproperty/assets/js/plupload/js/i18n/".$curr_lang->get('tag').".js" );
            }

            $gallery_script= "      
             
                var ipbaseurl		= '".rtrim(JURI::root(), '/')."';
                var pluploadpath	= '".JURI::root()."components/com_iproperty/assets/js';
                var ipmaximagesize  = '".$this->settings->maximgsize."';
                var ipfilemaxupload = 0;
           		
                jQuery.noConflict();
                jQuery(document).ready(function($) {
                    
                	uploadForm('property');
                    
                });
                
                function uploadForm(image_type)
                {
                	if(image_type === undefined)
                	{
                		image_type = 'property';
                	}
                	
                	jQuery('#ipUploader').empty();
                	jQuery('#ipUploader').pluploadQueue({
                        // General settings
                        runtimes : 'gears,flash,silverlight,browserplus,html5',
                        url : ipbaseurl+'/administrator/index.php?option=com_iproperty&task=ajax.ajaxUpload&format=raw&propid=".$this->item->id."&".JUtility::getToken()."=1' + '&image_type=' + image_type,
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
                                        alert('".JText::_('COM_IPROPERTY_OVERIMGLIMIT')."');
                                    } else {
                                        console.log(response[0].message);
                                    }
                                }
                            }
                        }
                    });  
                    
                }
                
                "."\n";
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
        
        //  files for appendgrid ajax table editor
		$document->addStyleSheet(JURI::root(true)."/jQueryAssets/jquery.appendGrid-1.3.2/jquery.appendGrid-1.3.2.css");
		$document->addScript(JURI::root(true)."/jQueryAssets/jquery.appendGrid-1.3.2/jquery.appendGrid-1.3.2.js");
		
		$document->addScript(JURI::root(true)."/jsAssets/simpleAjaxUploader-1.10.1/SimpleAjaxUploader.min.js");
        
		$this->addToolbar();
		$this->assignRef('propid', $this->item->id);
		parent::display($tpl);
	}

    protected function addToolbar()
	{		 
        JRequest::setVar('hidemainmenu', true);

		$isNew		= ($this->item->id == 0);

		JToolBarHelper::title($isNew ? '<span class="ip_adminHeader">'.JText::_('COM_IPROPERTY_ADD_PROPERTY').'</span>' : '<span class="ip_adminHeader">'.JText::_('COM_IPROPERTY_EDIT_PROPERTY').'</span> <span class="ip_adminSubheader">['.$this->item->street.']</span>', 'iproperty');

		// If not checked out, can save the item.
        JToolBarHelper::apply('property.apply', 'JTOOLBAR_APPLY');
        JToolBarHelper::save('property.save', 'JTOOLBAR_SAVE');
        JToolBarHelper::divider();
        // Only show these options to admin
        if ($this->ipauth->getAdmin()){
            JToolBarHelper::custom('property.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);

            // If an existing item, can save to a copy.
            if (!$isNew) {
                JToolBarHelper::custom('property.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
            }
            JToolBarHelper::divider();
        }        

		if (empty($this->item->id))  {
			JToolBarHelper::cancel('property.cancel','JTOOLBAR_CANCEL');
		}
		else {
			JToolBarHelper::cancel('property.cancel', 'JTOOLBAR_CLOSE');
		}
	}

    public function _displayNoAccess($tpl = null)
    {
        JToolBarHelper::title( '<span class="ip_adminHeader">'.JText::_( 'COM_IPROPERTY_NO_ACCESS' ).'</span>', 'iproperty' );
        JToolBarHelper::back();
        parent::display($tpl);
    }
}
?>