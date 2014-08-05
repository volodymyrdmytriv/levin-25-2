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

class plgIpropertyFindmyschooluk extends JPlugin
{
    function plgIpropertyFindmyschooluk(&$subject, $config)
    {
        parent::__construct($subject, $config);
        $this->loadLanguage();
    }

    function onBeforeRenderForms($property, $settings, $sidecol)
    {
		if ($this->params->get('before', false)) $this->doFindmySchool($property, $settings, $sidecol);
    }
	
	function onAfterRenderForms($property, $settings, $sidecol)
    {
        if (!$this->params->get('before', false)) $this->doFindmySchool($property, $settings, $sidecol);
    } 
    
    function doFindmySchool($property, $settings, $sidecol)
    {
        $app = JFactory::getApplication();
        $document = JFactory::getDocument();
        if($app->getName() != 'site') return true;

        if(!$property->postcode) return true;

        $values = array();

        $values['zip']          = $property->postcode;
        $values['key']          = $this->params->get('apikey', false);
        $values['radius']       = $this->params->get('radius', 1.5);
        $values['type']         = $this->params->get('type', 0);
        $min                    = $this->params->get('minimum', 2);
        $max                    = $this->params->get('maximum', 5);
        $debug                  = $this->params->get('debug', 0);

        $i = 1;
        $result = $this->getSchoolData($values);
        if(($result->result != 'OK') && $debug == 0) return true;

        // set the min / max values
        $schools = $result->establishments->establishment;
        $count = count($result->establishments->establishment);

        if ($count < $min && $debug == 0) return true; // return if we have < min results

        $ed_panel = '<div class="ip_spacer"></div>';
        $ed_panel .= '<div>';

        $ed_panel .= '<table class="ptable ip_education" width="100%">';
            $ed_panel .= '<tr>';
                $ed_panel .= '<th width="25%">Name</th>';
                $ed_panel .= '<th width="25%">Grade Level</th>';
                $ed_panel .= '<th width="25%">Distance from Listing</th>';
                $ed_panel .= '<th width="25%">Last Inspected</th>';
            $ed_panel .= '</tr>';
            // loop through returned schools

            if($result->result != 'OK') {
                $ed_panel .= '<tr><td colspan="4" align="center"><b>Findmyschool.co.uk Error:</b> '.$result->result.'</td></tr>';
                $no_results = true;
            } elseif( $count < 1 ){
                $ed_panel .= '<tr><td colspan="4" align="center"><b>No results were found.</b></td></tr>';
                $no_results = true;
            } else {
                $k = 0;
                foreach ($schools as $school) {
                    $ed_panel .= '<tr class="iprow'.$k.'">';
                        $ed_panel .= '<td><a href="'.$school->establishment_url.'" target="_blank">'.$school->establishment_name.'</a></td>';
                        $ed_panel .= '<td>'.$school->establishment_type.'</td>';
                        $ed_panel .= '<td align="center">'.round($school->establishment_distance_from_target, 2).' km</td>';
                        $ed_panel .= '<td align="center">'.$school->establishment_last_inspected.'</td>';
                    $ed_panel .= '</tr>';

                    if ($i >= $max) break;
                    $i++;
                    $k = 1 - $k;
                    $no_results = false;
                }
            }
            $ed_panel .= '<tr><td colspan="4" align="center">School information provided by: <a href="http://www.findmyschool.co.uk/" target="_blank">www.findmyschool.co.uk</a></td></tr>';
            $ed_panel .= '</table>';
        $ed_panel .= '</div>';

        echo JHtml::_('tabs.panel', JText::_($this->params->get('tabtitle', 'PLG_IP_FMS_SCHOOLS')), 'ipfindmyschool');
        echo $ed_panel;

        return true;
    }

    function getSchoolData($values)
    {
        $key     = $values['key'];
        $radius  = $values['radius'];
        $type    = $values['type'];
        $zip     = $values['zip'];

        $query_string = "";
        $query_string .= "key=" . urlencode($key);
        $query_string .= "&range=" . $radius;
        $query_string .= "&postcode=" . urlencode($zip);
        $query_string .= $type ? "&type=" . $type : '';

        try {
            $result = new SimpleXMLElement($this->curlContents($query_string));
        } catch(Exception $e) {
            return false;
        }

        return $result;
    }

    function curlContents($u)
    {
        $url = "http://www.findmyschool.co.uk/api/search.aspx?" . $u;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
        curl_setopt($ch, CURLOPT_URL, $url);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
} // end class

?>

