<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin');

class plgIpropertyAddthis extends JPlugin
{
	function plgIpropertyAddthis(&$subject, $config)  
    {
		parent::__construct($subject, $config);
        $this->loadLanguage();
	}

	function onBeforeRenderProperty($property, $settings)
	{
        $app = JFactory::getApplication();
        $doc = JFactory::getDocument();
        if($app->getName() != 'site') return true;

        if(!$username = $this->params->get('username')) return true;

        // create javascript for Addhis request
        $doc->addScript( "http://s7.addthis.com/js/250/addthis_widget.js#username=".$username );

        echo '<div class="ip_addthis_container" style="padding-top: 10px; width: 50%;">
                <div class="addthis_toolbox addthis_default_style ">
                    <a href="http://www.addthis.com/bookmark.php?v=250&amp;username='.$username.'" class="addthis_button_compact">Share</a>
                    <span class="addthis_separator">|</span>
                    <a class="addthis_button_preferred_1"></a>
                    <a class="addthis_button_preferred_2"></a>
                    <a class="addthis_button_preferred_3"></a>
                    <a class="addthis_button_preferred_4"></a>
                </div>
             </div>';
        return true;
	}
}