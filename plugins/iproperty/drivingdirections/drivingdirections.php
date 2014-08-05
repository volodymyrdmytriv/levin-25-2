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

class plgIpropertyDrivingDirections extends JPlugin
{
	function plgIpropertyDrivingDirections(&$subject, $config)  
    {
		parent::__construct($subject, $config);
        $this->loadLanguage();
	}

	function onAfterRenderMap($property, $settings)
	{
        $app = JFactory::getApplication();
        $document = JFactory::getDocument();
        
		if($app->getName() != 'site') return true;
        if((!$property->lat_pos || !$property->long_pos) || $property->hide_address || !$property->show_map) return true;

        $unit = $this->params->get('unit');

        $svscript = '
        <script type="text/javascript">
            //<![CDATA[
			window.addEvent(\'domready\', function() {
				var dirtoggler = 0;
                var directionDisplay;
                var directionsService = new google.maps.DirectionsService();

                $$(\'.ipdirections\').addEvent(\'click\', function(e){
                    if (!dirtoggler){
                        //console.log("doing directions");
                        var directionsDisplay = new google.maps.DirectionsRenderer();
                        directionsDisplay.setPanel($("ip_directions_display"));

                        var end   = \''.$property->lat_pos.', '.$property->long_pos.'\';
                        getDirections = function(){
                            var start = $(\'origin\').value;
                            var request = {
                                origin:start,
                                destination:end,
                                travelMode: google.maps.DirectionsTravelMode.DRIVING
                            };
                            directionsService.route(request, function(response, status) {
                              if (status == google.maps.DirectionsStatus.OK) {
                                directionsDisplay.setDirections(response);
                              }
                            });
                        };
                        dirtoggler = 1;
                    }

                });
            });
            //]]>
        </script>';

        $document->addCustomTag( $svscript );

        echo JHtml::_('tabs.panel', JText::_($this->params->get('tabtitle', 'PLG_IP_DD_DIRECTIONS')), 'ipdirections');
            echo '
                <div style="width: '.$settings->tab_width.'px; height: '.$settings->tab_height.'px; overflow: auto;">
                    <div id="ip_directions_wrapper" align="center" style="padding: 8px;">
                        '.JText::_('PLG_IP_DD_DRIVING_INSTRUCTIONS').'<br />
                        <form id="ip_directionsform" name="ip_directions" action="javascript:getDirections();" style="margin: 0px;">
                            <input id="origin" type="text" class="inputbox" size="40" maxlength="60" name="origin" value="" />
                            <input type="submit" value="'.JText::_('PLG_IP_DD_GO').'" />
                        </form>
                    </div>
                    <div id="ip_directions_display" style="padding: 8px;"></div>
                </div>';
		return true;
	}
}
