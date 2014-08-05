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

class plgIpropertyGoogleplaces extends JPlugin
{
    function plgIpropertyGoogleplaces(&$subject, $config)
    {
        parent::__construct($subject, $config);
        $this->loadLanguage();
    }

    function onBeforeRenderForms($property, $settings, $sidecol)
    {
		if ($this->params->get('before', false)) $this->doGPlaces($property, $settings, $sidecol);
    }
	
	function onAfterRenderForms($property, $settings, $sidecol)
    {
        if (!$this->params->get('before', false)) $this->doGPlaces($property, $settings, $sidecol);
    } 
    
    function doGPlaces($property, $settings, $sidecol)
    {
        $app = JFactory::getApplication();
        $document = JFactory::getDocument();
        if($app->getName() != 'site' || !$property->show_map) return true;
        $gplanguage = $this->params->get('gplanguage', '');

        // convert distance for radius
        $distance   = $this->params->get('radius', 1);
        if ($this->params->get('unit', 'mi') == 'mi'){
            $distance = $distance * 1609.3;
        } else {
            $distance = $distance * 1000;
        }

        $types      = $this->params->get('types', array());
        $t_string   = '[';

        foreach ($types as $t){
            $t_string .= '"' . $t . '",';
        }

        $t_string = rtrim($t_string, ',') . ']';

        $gp_lat     = $property->lat_pos;
        $gp_lon     = $property->long_pos;

        if (!$gp_lat || !$gp_lon) return true;

        $radius     = $this->params->get('unit', 'mi') == 'mi' ? 3958.75 : 6371;
        $radiustag  = $this->params->get('unit', 'mi') == 'mi' ? JText::_('PLG_IP_GP_MILE') : JText::_('PLG_IP_GP_KM');

        $gp_script  = "<script type='text/javascript'>
                        var service;
                        var gpBnds;
                        var gpTable;
                        window.addEvent('domready', function() {
                            gpTable         = new HtmlTable({ headers: ['".JText::_('PLG_IP_GP_NAME')."','".JText::_('PLG_IP_GP_LOCATION')."','".JText::_('PLG_IP_GP_TYPE')."','".JText::_('PLG_IP_GP_DISTANCE')."'], zebra: true, sortable: true });
                            var gpListing   = new google.maps.LatLng(".$gp_lat.",".$gp_lon.");

                            //var gpBnds      = map.getBounds();
                            google.maps.event.addListenerOnce(map, 'bounds_changed', function(){
                                gpBnds = this.getBounds();
                            });
                            var placeRq     = {
                                                //bounds: gpBnds
                                                location: gpListing,
                                                radius: '".$distance."',
                                                types: ".$t_string.",
                                                language: '".$gplanguage."'
                                            };
                            service         = new google.maps.places.PlacesService(map);
                            service.search(placeRq, callback);

                        function callback(results, status) {
                          if (status == google.maps.places.PlacesServiceStatus.OK) {
                            for (var i = 0; i < results.length; i++) {
                              var place = results[i];
                              //console.dir(place);
                              createPlace(place);
                            }
                          } else if(status == google.maps.places.PlacesServiceStatus.ZERO_RESULTS) {
                              $$('.ipgoogleplaces').setStyle('display', 'none');
                          }
                        }

                        // build the marker object and table rows
                        function createPlace(place){
                            var type        = place.types[0];
                            type            = type.replace('_', ' ');
                            type            = type.clean();
                            type            = type.capitalize();
                            var gpmarker    = new google.maps.MarkerImage(place.icon, null, null, null, new google.maps.Size(25, 25));
                            var marker      = new google.maps.Marker({
                              map: map,
                              position: place.geometry.location,
                              title: place.name,
                              icon: gpmarker
                            });
                            gpTable.push([place.name, place.vicinity, type, getDistance(place)+' ".$radiustag."'])
                        }

                        function getDistance(place){
                            if (typeof(Number.prototype.toRad) === \"undefined\") {
                              Number.prototype.toRad = function() {
                                return this * Math.PI / 180;
                              }
                            }

                            // start point
                            var lat1 = Number('".$gp_lat."');
                            var lon1 = Number('".$gp_lon."');
                            // end point
                            var lat2 = Number(place.geometry.location.lat());
                            var lon2 = Number(place.geometry.location.lng());

                            var R = ".$radius."; // switch depending on measurement units
                            var dLat = (lat2-lat1).toRad();
                            var dLon = (lon2-lon1).toRad();
                            var lat1 = lat1.toRad();
                            var lat2 = lat2.toRad();

                            var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                                    Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2);
                            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                            var d = R * c;

                            return Math.round(d*100)/100;
                        }

                        gpTable.inject($('ip-googleplaces'));

                        });
                    </script>";
        $document->addCustomTag($gp_script);

        echo JHtml::_('tabs.panel', JText::_($this->params->get('tabtitle', 'PLG_IP_GOOGLEPLACES')), 'ipgoogleplaces');
        echo '
            <div style="padding: 10px 0px !important;">
                <div id="ip-googleplaces" style="width: 100%"></div>
            </div>';

        return true;
    }
}
