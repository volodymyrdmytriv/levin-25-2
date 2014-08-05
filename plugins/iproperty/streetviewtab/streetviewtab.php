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

class plgIpropertyStreetViewTab extends JPlugin
{
	function plgIpropertyStreetViewTab(&$subject, $config)  
    {
		parent::__construct($subject, $config);
        $this->loadLanguage();
	}

	function onAfterRenderMap($property, $settings)
	{
        $app = JFactory::getApplication();
		if($app->getName() != 'site') return true;
        if(!$settings->googlemap_enable) return true;
        if(!$property->lat_pos || !$property->long_pos || !$property->show_map) return true;

		echo JHtml::_('tabs.panel', JText::_($this->params->get('tabtitle', 'PLG_IP_SV_STREETVIEW')), 'ipstreetview');
        ?>
            <div id="pano" style="width: <?php echo $settings->tab_width; ?>px; height: <?php echo $settings->tab_height; ?>px;"></div>
        <?php
		return true;
	}
}
