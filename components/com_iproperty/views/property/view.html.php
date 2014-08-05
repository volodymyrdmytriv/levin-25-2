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

class IpropertyViewProperty extends JView
{
    function display($tpl = null)
    {
        $app  = JFactory::getApplication();
        $option     = JRequest::getCmd('option');

        //jimport('joomla.html.pane');
        JHTML::_('behavior.modal');
        JHTML::_('behavior.tooltip');
        JHtml::_('behavior.formvalidation');

        JPluginHelper::importPlugin( 'iproperty' );
        $dispatcher = JDispatcher::getInstance();

        if(JRequest::getBool('print') == 1) JRequest::setVar('tmpl', 'component');

        $this->ipbaseurl    = JURI::root(true);
        $this->ipauth       = new ipropertyHelperAuth();
        $document           = JFactory::getDocument();
        $settings           = ipropertyAdmin::config();
        $session            = JFactory::getSession();
        $user               = JFactory::getUser();

        // Check if login is required to view details - if so check user and display form if not logged in
        if($settings->require_login){
            if(!$user->get('id')){
                $this->_displayLogin('login');
                return;
            }
        }

        if(JRequest::getVar('usersave')) $tpl = 'usersave';
        if(JRequest::getVar('calculator')) $tpl = 'calculator';

        $model          = $this->getModel();
        $property       = $this->get('data');
        //$docs           = $this->get('docs');
        $images         = $model->getImages('property');
        $images_trade = $model->getImages('tradearea');
        $images_leasing = $model->getImages('leasingplan');
        $marketing_flyer_pdf = $model->getDocsByTitle('marketing_flyer_pdf');
        $leasing_plan_pdf = $model->getDocsByTitle('leasing_plan_pdf');
        $aerial_pdf = $model->getDocsByTitle('aerial_pdf');
        
        $demographics = $this->get('demographics');
        $spaces_available = $this->get('spacesAvailable');
        $tenants = $this->get('tenants');
        
        $amenities      = $this->get('amenities');
        $layout         = $this->getLayout();

        if(!empty($property)){
            $property       = $property[0];
        }else{
            $property       = '';
        }

        if(!$property){
            $this->_displayNoResult('noresult');
            return;
        }

        if($layout == 'gallery'){
            $this->_displayGallery($property, $images);
            return;
        }

        //check if gmaps enabled and property has lat and long values
        if( $settings->googlemap_enable == 1 && $property->lat_pos && $property->long_pos && $property->show_map ) {
            $this->gmap_OK = 1;
        }else{
            $this->gmap_OK = false;
        }

        //create toolbar
        $dispatcher->trigger( 'onBeforeRenderToolbar', array( &$settings ) );
        //$extra = array();
        //$extra['property'] = $property;
        //echo ipropertyHTML::buildToolbar('property', $extra);

        // trigger onBeforeRenderProperty plugins
        $dispatcher->trigger( 'onBeforeRenderProperty', array( &$property, &$settings ) );

        // trigger phocapdf plugin if exists - under development 2012 vk
        jimport('joomla.filesystem.file');
        if(JPluginHelper::isEnabled('phocapdf', 'iproperty') && JFile::exists(JPATH_ROOT.DS.'plugins'.DS.'phocapdf'.DS.'iproperty'.DS.'iproperty'.DS.'ipropertyhelper.php')){
           require_once(JPATH_ROOT.DS.'plugins'.DS.'phocapdf'.DS.'iproperty'.DS.'iproperty'.DS.'ipropertyhelper.php');
           PhocaPDFIpropertyHelper::renderPDFIcon();
        }

        $lists = array();
        $lists['copyme']    = ipropertyHTML::checkbox( 'copy_me', '', 1, JText::_( 'COM_IPROPERTY_COPY_ME_EMAIL' ), 1, $session->get('ip_sender_copy_me'));

        //contact preferences
        $prefs      = array();
        $prefs[]    = JHTML::_('select.option', JText::_( 'COM_IPROPERTY_PHONE' ), JText::_( 'COM_IPROPERTY_PHONE' ) );
        $prefs[]    = JHTML::_('select.option', JText::_( 'COM_IPROPERTY_EMAIL' ), JText::_( 'COM_IPROPERTY_EMAIL' ) );
        $prefs[]    = JHTML::_('select.option', JText::_( 'COM_IPROPERTY_EITHER' ), JText::_( 'COM_IPROPERTY_EITHER' ) );
        $lists['preference'] = JHTML::_('select.radiolist', $prefs, 'sender_preference', 'size="5" class="inputbox"', 'value', 'text', $session->get('ip_sender_preference'));

        //contact preferences
        $ctime      = array();
        $ctime[]    = JHTML::_('select.option', JText::_( 'COM_IPROPERTY_MORNING' ), JText::_( 'COM_IPROPERTY_MORNING' ) );
        $ctime[]    = JHTML::_('select.option', JText::_( 'COM_IPROPERTY_AFTERNOON' ), JText::_( 'COM_IPROPERTY_AFTERNOON' ) );
        $ctime[]    = JHTML::_('select.option', JText::_( 'COM_IPROPERTY_NIGHT' ), JText::_( 'COM_IPROPERTY_NIGHT' ) );
        $lists['contact_time'] = JHTML::_('select.radiolist', $ctime, 'sender_ctime', 'size="5" class="inputbox"', 'value', 'text', $session->get('ip_sender_ctime'));

        $tab_height             = ( $settings->tab_height ) ? $settings->tab_height : '275'; // was 220
        $tab_width              = ( $settings->tab_width ) ? $settings->tab_width : '450'; // was 350
        $picfolder              = $this->ipbaseurl.$settings->imgpath;
        $agentfolder            = $this->ipbaseurl.'/media/com_iproperty/agents/';
        $agent_photo_width      = ( $settings->agent_photo_width ) ? $settings->agent_photo_width : '90';
        $galleryheight          = ( $settings->gallery_height ) ? $settings->gallery_height : '400';
        $gallerywidth           = ( $settings->gallery_width ) ? $settings->gallery_width : '700';

        
		// 	check if jQuery is loaded before adding it
		if (!JFactory::getApplication()->get('jquery')) {
		  	JFactory::getApplication()->set('jquery', true);
			$document->addScript( "https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" );
		}
		
		// adding slideshow scripts
        $document->addStyleSheet(JURI::root(true).'/components/com_iproperty/assets/css/bjqs.css');
		$document->addScript(JURI::root(true).'/components/com_iproperty/assets/js/bjqs-1.3.js');
		
		// fullscreen popup slideshow scripts
		// Add fancyBox main JS and CSS files
		$document->addStyleSheet(JURI::root(true).'/components/com_iproperty/assets/jquery_fancybox/jquery.fancybox.css?v=2.1.5');
		$document->addScript(JURI::root(true).'/components/com_iproperty/assets/jquery_fancybox/jquery.fancybox.js?v=2.1.5');
		
		
		$jquery_js = '
			jQuery.noConflict();
			jQuery(document).ready(function($) {
				createSlideshow();
			});
		';
		
		$document->addScriptDeclaration( $jquery_js );

		$agents = $this->get('agents');

        $this->assignRef('p', $property);
        $this->assignRef('images', $images);
        $this->assignRef('images_trade', $images_trade);
        $this->assignRef('images_leasing', $images_leasing);
        $this->assignRef('marketing_flyer_pdf', $marketing_flyer_pdf);
        $this->assignRef('leasing_plan_pdf', $leasing_plan_pdf);
        $this->assignRef('aerial_pdf', $aerial_pdf);
        
        
        $this->assignRef('demographics', $demographics);
        $this->assignRef('spaces_available', $spaces_available);
        $this->assignRef('tenants', $tenants);
        $this->assignRef('amenities', $amenities);
        $this->assignRef('docs', $docs);
        $this->assignRef('agent', $agent);
        $this->assignRef('agents', $agents);
        $this->assignRef('settings', $settings);
        $this->assignRef('lists', $lists);
        $this->assignRef('additionals', $additionals);
        $this->assignRef('folder', $picfolder);
        $this->assignRef('agent_folder', $agentfolder);
        $this->assignRef('agent_photo_width', $agent_photo_width);
        $this->assignRef('galleryheight', $galleryheight);
        $this->assignRef('gallerywidth', $gallerywidth);
        $this->assignRef('gallery_link', $gallery_link);
        $this->assignRef('gallery_attributes', $gallery_attributes);
        $this->assignRef('gallery_attributes2', $gallery_attributes2);
        $this->assignRef('dispatcher', $dispatcher);
        $this->assignRef('return', $return);
        $this->assignRef('session', $session);
        $this->assignRef('user', $user);

        $this->extras_array = array( "beds"         => JText::_( 'COM_IPROPERTY_BEDS' ),
                                     "baths"        => JText::_( 'COM_IPROPERTY_BATHS' ),
                                     "sqft"         => (!$settings->measurement_units) ? JText::_( 'COM_IPROPERTY_SQFT' ) : JText::_( 'COM_IPROPERTY_SQM' ),
                                     "lotsize"      => JText::_( 'COM_IPROPERTY_LOT_SIZE' ),
                                     "lot_acres"    => JText::_( 'COM_IPROPERTY_LOT_ACRES' ),
                                     "yearbuilt"    => JText::_( 'COM_IPROPERTY_YEAR_BUILT' ),
                                     "heat"         => JText::_( 'COM_IPROPERTY_HEAT' ),
                                     "garage_type"  => JText::_( 'COM_IPROPERTY_GARAGE_TYPE' ),
                                     "roof"         => JText::_( 'COM_IPROPERTY_ROOF' ));

        if( $this->gmap_OK == 1 ){
            
        }

        /*
        $property_js = '
            function formValidate(f) {
               if (document.formvalidator.isValid(f)) {
                  return true;
               }
               else {
                  alert("' . JText::_( 'COM_IPROPERTY_ENTER_REQUIRED' ) . '");
               }
               return false;
            }

            window.addEvent("domready", function(){
                var saveSlide = ($("save-panel")) ? new Fx.Slide("save-panel").hide() : null;
                if(saveSlide){
                    $("saveslidein").addEvent("click", function(e){
                        $("save-panel").setStyle("display", "block");
                        if($("calculate-panel")) $("calculate-panel").setStyle("display", "block");
                        e = new Event(e);
                        (calcSlide) ? calcSlide.slideOut() : "";
                        (saveSlide.open) ? saveSlide.slideOut() : saveSlide.slideIn();
                        e.stop();
                    });
                }

                var calcSlide = ($("calculate-panel")) ? new Fx.Slide("calculate-panel").hide() : null;
                if(calcSlide){
                    $("calcslidein").addEvent("click", function(e){
                        $("calculate-panel").setStyle("display", "block");
                        if($("save-panel")) $("save-panel").setStyle("display", "block");
                        e = new Event(e);
                        (saveSlide) ? saveSlide.slideOut() : "";
                        (calcSlide.open) ? calcSlide.slideOut() : calcSlide.slideIn();
                        e.stop();
                    });
                }
            });';
        $document->addScriptDeclaration( $property_js );       
		*/
        
        $this->_prepareDocument($property);

        parent::display($tpl);
    }

    protected function _prepareDocument($property)
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

        $title = ($property) ? $property->street_address : JText::_( 'COM_IPROPERTY_INTELLECTUAL_PROPERTY' );
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
        if ($property->metadesc != '') {
            $this->document->setDescription($property->metadesc);
        } else if (!$property->metadesc && $this->params->get('menu-meta_description')) {
            $this->document->setDescription($this->params->get('menu-meta_description'));
        }

        if ($property->metakey != '') {
            $this->document->setMetadata('keywords', $property->metakey);
        } else if (!$property->metakey && $this->params->get('menu-meta_keywords')) {
            $this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
        }
        if ($this->params->get('robots')) $this->document->setMetadata('robots', $this->params->get('robots'));

        // Breadcrumbs
        if(is_object($menu) && $menu->query['view'] != 'property') {
            $pathway->addItem($title);
        }
    }

    function _displayNoResult($tpl = null)
    {
        $app  = JFactory::getApplication();
        $option     = JRequest::getCmd('option');

        $document       = JFactory::getDocument();
        $settings       = ipropertyAdmin::config();

        $document->setTitle( JText::_( 'COM_IPROPERTY_PROPERTY_NOT_FOUND' ) );

        parent::display($tpl);
    }

    function _displayGallery($property = null, $images = null)
    {
        $app  = JFactory::getApplication();
        $option     = JRequest::getCmd('option');

        JRequest::setVar('tmpl', 'component');
        $this->ipbaseurl    = JURI::root(true);
        $document           = JFactory::getDocument();
        $settings           = ipropertyAdmin::config();

        $picfolder          = $this->ipbaseurl.$settings->imgpath;
        $galleryheight      = ( $settings->gallery_height ) ? $settings->gallery_height : '400';
        $gallerywidth       = ( $settings->gallery_width ) ? $settings->gallery_width : '700';
        
        //mobile gallery
        if(ipropertyHTML::isMobileRequest() && JPluginHelper::isEnabled('system', 'ipmobile')){
            $document->setMetaData( 'apple-mobile-web-app-capable', 'yes' );
            $document->addStylesheet($this->ipbaseurl.'/components/com_iproperty/assets/galleries/photoswipe/photoswipe.css');
            $document->addScript($this->ipbaseurl.'/components/com_iproperty/assets/galleries/photoswipe/lib/klass.min.js');
            $document->addScript($this->ipbaseurl.'/components/com_iproperty/assets/galleries/photoswipe/code.photoswipe-3.0.5.min.js');            
        }else{

            $styles = '
                    #viewer_img{height: '. $galleryheight . 'px;width: ' . $gallerywidth . 'px;overflow:hidden; border: solid 1px '. $settings->accent.';}
                    .gallery_info, div#box5_buttons{width: ' . $gallerywidth . 'px; border-color: '.$settings->accent.';}
                    .mask2{height: '. $galleryheight . 'px;width: ' . $gallerywidth . 'px;}
                    #box5{width: ' . $gallerywidth . 'px;}
                    #box5 span{width: ' . $gallerywidth . 'px;}';

            $document->addStyleDeclaration($styles);

            switch($settings->gallerytype)
            {
                case 1:
                    $document->addScript($this->ipbaseurl.'/components/com_iproperty/assets/galleries/viewer/gallery.js');
                    $gallery_js ='
                        window.addEvent(\'domready\',function(){
                            pic = new Array();' . "\n\t";
                            $x=1;
                            foreach($images as $i) {
                                $path = ($i->remote == 1) ? $i->path : $picfolder;
                                $gallery_js .= 'pic['.$x.'] = new IPImage("'.$path.'","'.addslashes($i->img_title).'","'.addslashes($i->img_description).'","'.addslashes($i->fname).'","'.$i->type.'");' . "\n\t";
                                $x++;
                            }
                            $gallery_js .= 'gl = new IPGallery(1,'. count($images) .');' . "\n\t";
                            $gallery_js .= 'gl.showPic(1);' . "\n";

                    $gallery_js .= '
                            });';

                    $document->addScriptDeclaration( $gallery_js );
                break;
                case 2: //NoobSlideshow

                    $document->addScript($this->ipbaseurl.'/components/com_iproperty/assets/galleries/noobslide/_class.noobSlide.js');
                    $img_array = array();
                    for( $i = 0; $i < (count( $images )); $i++ ){
                    $img_array[] = $i;
                    }
                    $noobScript = '
                    window.addEvent(\'domready\',function(){
                        //SAMPLE 5 (mode: vertical, using "onWalk" )
                        var info5 = $(\'info5\').setOpacity(0.5);
                        var imageItems = [';
                            $imgcnt = 0;
                            foreach($images as $i){
                                $imgtitle = ($i->title) ? addslashes($i->title) : addslashes(preg_replace('/\s+/', ' ', trim($property->street_address)));
                                $imgdesc  = ($i->description) ? addslashes($i->description) : addslashes($property->city.' '.ipropertyHTML::getStateName($property->locstate).$property->province);
                                $noobScript .= '{title:\''.$imgtitle.'\', desc:\''.$imgdesc.'\'}';
                                $imgcnt++;
                                if($imgcnt < count($images)){
                                    $noobScript .= ",\n\t";
                                }
                            }
                    $noobScript .= '];
                        var hs5 = new noobSlide({
                            box: $(\'box5\'),
                            size: ' . $gallerywidth . ',
                            items: imageItems,
                            autoPlay: true,
                            interval: 6000,
                            fxOptions: {
                                duration: 800,
                                transition: Fx.Transitions.Expo.easeInOut,
                                wait: false
                            },
                            addButtons: {
                                previous: $(\'prev5\'),
                                play: $(\'play5\'),
                                stop: $(\'stop5\'),
                                next: $(\'next5\')
                            },
                            onWalk: function(currentItem){
                                $(\'imgtitle\').empty();
                                $(\'imgdesc\').empty();
                                $(\'imgtitle\').innerHTML = currentItem.title;
                                $(\'imgdesc\').innerHTML = currentItem.desc;
                            }
                        });
                    });';
                    $document->addScriptDeclaration( $noobScript );
                break;
                case 3:
                    //another gallery
                break;
            }
        }

        $this->assignRef('images', $images);
        $this->assignRef('folder', $picfolder);
        $this->assignRef('gallerywidth', $gallerywidth);
        $this->assignRef('p', $property);
        $this->assignRef('settings', $settings);

        parent::display();
    }

    function _displayLogin($tpl = null)
    {
        $document               = JFactory::getDocument();
        $settings               = ipropertyAdmin::config();
        $usersConfig            = JComponentHelper::getParams( 'com_users' );
        $return                 = base64_encode(JRoute::_(ipropertyHelperRoute::getPropertyRoute(JRequest::getInt('id')), false));

        $document->setTitle( JText::_( 'COM_IPROPERTY_PLEASE_LOG_IN' ) );

        $this->assignRef('return', $return);
        $this->assignRef('allowreg', $usersConfig->get( 'allowUserRegistration' ));
        $this->assignRef('settings', $settings);

        parent::display($tpl);
    }
}

?>
