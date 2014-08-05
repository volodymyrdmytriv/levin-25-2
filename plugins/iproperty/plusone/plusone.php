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

class plgIpropertyPlusone extends JPlugin
{	
	function plgIpropertyPlusone(&$subject, $config)  
    {
		parent::__construct($subject, $config);
        $this->loadLanguage();
	}

	function onAfterRenderProperty($property, $settings)
	{
        $position = $this->params->get('position', 'after');
        if($position != 'after') return true;

        $app = JFactory::getApplication();
        $document = JFactory::getDocument();

		if($app->getName() != 'site') return true;
        $size = $this->params->get('size', '');
        if ($size) $size = 'size="'.$size.'"';

        $document->addScript("https://apis.google.com/js/plusone.js");

        echo '<div id="plg_ip_plusone">';
        echo '<g:plusone '.$size.'></g:plusone>';
        echo '</div>';

        return true;
	}

    function onBeforeRenderProperty($property, $settings)
	{
        $position = $this->params->get('position', 'before');
        if($position != 'before') return true;

        $app            = JFactory::getApplication();
        $document       = JFactory::getDocument();
        $topmargin      = $this->params->get('topmargin', 10);
        $rightmargin    = $this->params->get('rightmargin', 40);
        
		if($app->getName() != 'site') return true;
        $size = $this->params->get('size', '');
        if ($size) $size = 'size="'.$size.'"';

        $document->addScript("https://apis.google.com/js/plusone.js");

        echo '
            <div style="position: relative;">
                <div id="plg_ip_plusone" style="position: absolute; top: '.$topmargin.'px; right: '.$rightmargin.'px;">
                    <g:plusone '.$size.'></g:plusone>
                </div>
            </div>';

        return true;
	}
}