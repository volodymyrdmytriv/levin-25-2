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

class plgIpropertyEducationForm extends JPlugin
{
	function plgIpropertyEducationForm(&$subject, $config)  
    {
		parent::__construct($subject, $config);
        $this->loadLanguage();
    }

    function onBeforeRenderForms($property, $settings, $sidecol)
    {
		if ($this->params->get('before', false)) $this->doEducationForm($property, $settings, $sidecol);
    }
	
	function onAfterRenderForms($property, $settings, $sidecol)
    {
        if (!$this->params->get('before', false)) $this->doEducationForm($property, $settings, $sidecol);
    }    
    
	function doEducationForm($property, $settings, $sidecol)
	{
        $app = JFactory::getApplication();
        $document = JFactory::getDocument();
        if($app->getName() != 'site') return true;
        if(!$property->zip && ( !$property->lat_pos || !$property->long_pos )) return true;

        $values = array();

        $values['zip']			= $property->zip;
        $values['latitude']		= $property->lat_pos;
        $values['longitude']    = $property->long_pos;
        $values['key']			= 'dad04b84073a265e5244ba6db8892348';
        $values['radius']		= $this->params->get('radius', 1.5);
        $values['min']			= $this->params->get('minimum', 3);
        $values['city']         = $property->city;
        $values['state']        = ipropertyHTML::getStateCode($property->locstate);
        $max				    = $this->params->get('maximum', 5);
        $debug				    = $this->params->get('debug', 0);

        $i = 1;
        $result = $this->getSchoolData($values);
        if($result[0]['methodResponse']['faultString'] && $debug == 0) return true;

        $ed_panel = '<div class="ip_spacer"></div>';
        $ed_panel .= '<div>';

        $ed_panel .= '<table class="ptable ip_education" width="100%">';
            $ed_panel .= '<tr>';
                $ed_panel .= '<th width="25%">School Name</th>';
                $ed_panel .= '<th width="25%">Grade Level</th>';
                $ed_panel .= '<th width="25%">Distance from Listing</th>';
                $ed_panel .= '<th width="25%">Enrollment</th>';
            $ed_panel .= '</tr>';
            // loop through returned schools
            if($result[0]['methodResponse']['faultString']) {
                $ed_panel .= '<tr><td colspan="4" align="center"><b>Education.com Error:</b> '.$result[0]['methodResponse']['faultString'].'</td></tr>';
                $no_results = true;
            } elseif( count($result[0]['methodResponse']) < 1 ){
                $ed_panel .= '<tr><td colspan="4" align="center"><b>No results were found.</b></td></tr>';
                $no_results = true;
            } else {
                $k = 0;
                foreach ($result[0]['methodResponse'] as $school) {
                    $ed_panel .= '<tr class="iprow'.$k.'">';
                        $ed_panel .= '<td><a href="'.$school['school']['url'].'" target="_blank">'.$school['school']['schoolname'].'</a></td>';
                        $ed_panel .= '<td>'.$school['school']['gradelevel'].'</td>';
                        $ed_panel .= '<td align="center">'.round($school['school']['distance'], 2).' miles</td>';
                        $ed_panel .= '<td align="center">'.$school['school']['enrollment'].'</td>';
                    $ed_panel .= '</tr>';

                    if ($i >= $max) break;
                    $i++;
                    $k = 1 - $k;
                    $no_results = false;
                }

            }
            $ed_panel .= '<tr><td colspan="4" align="center">Schools provided by: <a href="http://www.education.com/schoolfinder/" target="_blank"><img src ="'.$result[1]['methodResponse']['logosrc'].'" alt="" /></a><br />';
            if(!$no_results) $ed_panel .= '<a href="' . $result[1]['methodResponse']['lsc'] . '" target="_blank">See more information on ' . $property->city . ' schools from Education.com</a><br />';
            $ed_panel .= $result[1]['methodResponse']['disclaimer'].'</td></tr>';
            $ed_panel .= '</table>';
		$ed_panel .= '</div>';
		
		echo JHtml::_('tabs.panel', JText::_($this->params->get('tabtitle', 'PLG_IP_ED_SCHOOLS')), 'ipeducation');
		echo $ed_panel;
		
		return true;	
	}	

	function getSchoolData($values) 
    {
		$key	 = $values['key'];
		$radius	 = $values['radius'];
		$min	 = $values['min'];
		$lat	 = $values['latitude'];
		$lon	 = $values['longitude'];
		$zip	 = $values['zip'];
        $city    = urlencode($values['city']);
        $state   = $values['state'];

		$query_string = "";
		$query_string .= "key=" . $key;
		$query_string .= "&v=3";
		$query_string .= "&f=system.multiCall";
		$query_string .= "&resf=php";

		// do the school search
		$query_string .= "&methods[0][f]=schoolSearch";
		$query_string .= "&methods[0][sn]=sf";
		$query_string .= "&methods[0][key]=" . $key;
		if($lat != 0 && $lon != 0) {
			$query_string .= "&methods[0][latitude]=" . $lat;
			$query_string .= "&methods[0][longitude]=" . $lon;
			$query_string .= "&methods[0][distance]=" . $radius;
		} elseif (($lat = 0 && $lon = 0) && $zip != 0) {
			$query_string .= "&methods[0][zip]=" . $zip;
		}
		$query_string .= "&methods[0][minResult]=" . $min;
		$query_string .= "&methods[0][fid]=F1";

		// do the branding search
		$query_string .= "&methods[1][f]=gbd";
                $query_string .= "&methods[1][city]=" . $city;
                if($state) $query_string .= "&methods[1][state]=" . $state;
        $query_string .= "&methods[1][sn]=sf";
		$query_string .= "&methods[1][key]=" . $key;
		$query_string .= "&methods[1][fid]=F2";

		$result = $this->curlContents($query_string);

		$schoolinfo = unserialize($result);

		return $schoolinfo;
	}
	
    function curlContents($u)
    {
    	$url = "http://api.education.com/service/service.php?" . $u;

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

