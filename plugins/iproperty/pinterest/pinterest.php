<?php
/**
 * @version 2.0 2012-04-16
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin');

class plgIpropertyPinterest extends JPlugin
{
	function plgIpropertyPinterest(&$subject, $config)  
    {
		parent::__construct($subject, $config);
        $this->loadLanguage();
	}

	function onBeforeRenderProperty($property, $settings)
	{
        $app = JFactory::getApplication();
        $doc = JFactory::getDocument();
        if($app->getName() != 'site') return true;
        
        $description    = urlencode($property->short_description);
        $proplink       = urlencode(JURI::root().$property->proplink);
        $defaultimg     = $this->params->get('defaultimg', false);
        $topmargin      = $this->params->get('topmargin', 50);
        $rightmargin    = $this->params->get('rightmargin', 10);
        
        // get thumb path
        $imgxml         = simplexml_load_string($property->thumb);
        $pin_image      = $imgxml['src'];
        // check that it's not a 'nopic'
        if(strpos($pin_image, 'nopic') && $defaultimg){
            // use a default image
            $pin_image = $defaultimg;
        } 
        
        // make sure we have good path for image
        if(strpos($pin_image, 'http://')){
            // add JURI::root
            $pin_image = JURI::root().$pin_image;
        } 
        
        $pin_image = urlencode($pin_image);
        
        $pinpath = "http://pinterest.com/pin/create/button/?url=".$proplink."&media=".$pin_image."&description=".$description;

        // create javascript for pinterest request
        $doc->addScript( "//assets.pinterest.com/js/pinit.js" );

        echo '
            <div style="position: relative;">
                <div class="ip_pinterest_container" style="position: absolute; top: '.$topmargin.'px; right: '.$rightmargin.'px; width: 43px; height: 21px;">
                    <a href="'.$pinpath.'" class="pin-it-button" count-layout="horizontal" target="_blank">
                        <img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" alt="Pin It" />
                    </a>
                </div>
            </div>';
        return true;
	}
}