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

class plgIpropertyFblike extends JPlugin
{	
	function plgIpropertyFblike(&$subject, $config)  
    {
		parent::__construct($subject, $config);
        $this->loadLanguage();
	}

	function onAfterRenderProperty($property, $settings)
	{
        $app = JFactory::getApplication();
        $document = JFactory::getDocument();
        
		if($app->getName() != 'site') return true;

		$uri 	= JFactory::getURI();
		$thumb	= ipropertyHTML::getThumbnail($property->id, '', '', '', '', '', true, false, false);
		
		//setMetaData  (string $name, string $content, [bool $http_equiv  = false]) 
		$document->setMetaData('og:title', $property->street_address);
        $document->setMetaData('og:site_name', $app->getCfg('sitename'));
		$document->setMetaData('og:image', $thumb);

        echo '<div id="plg_ip_facebook">';
        //echo '<iframe src="http://www.facebook.com/plugins/like.php?href=' . $uri . '&amp;layout=standard&amp;show_faces=true&amp;width=450&amp;action=like&amp;colorscheme=light&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:80px;" allowTransparency="true"></iframe>';
        echo '<iframe id="ip_facebook" src="http://www.facebook.com/plugins/like.php?href='.urlencode($uri);
        echo '&amp;layout='.$this->params->get('layout');
        echo '&amp;show_faces='.($this->params->get('show_faces') == 'yes' ? 'true' : 'false');
        echo '&amp;width='.$this->params->get('width');
        echo '&amp;action='.$this->params->get('verb');
        echo '&amp;font='.urlencode($this->params->get('font'));
        echo '&amp;colorscheme='.$this->params->get('color_scheme').'"';
        echo ' scrolling="no"';
        echo ' frameborder="0"';
        echo ' allowTransparency="true"';
        echo ' style="border:none; overflow:hidden; width:'.$this->params->get('width').'px; height:'.$this->params->get('height').'px">';
        echo JText::_('Your browser does not support Iframes!');
        echo '</iframe>';
        echo '</div>';

        return true;
	}
}