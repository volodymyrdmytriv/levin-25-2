<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Iproperty
 * @copyright (C) 2013 the Thinkery
 * @license see LICENSE.php
 */
 
defined('_JEXEC') or die('Restricted access');

class modIPMratesHelper 
{
	function MRatesCall(&$params)
    {
		$query_string = "";
		
		$Zparams = array(
			'zws-id' => $params->get('zillow_id'),
			'output' => 'json'
		);
		
		foreach ($Zparams as $key => $value) {
			$query_string .= "$key=" . urlencode($value) . "&";
		}
		
		$url = "http://www.zillow.com/webservice/GetRateSummary.htm?$query_string";
		
		$output = file_get_contents($url);
		$mrates = json_decode($output,true);
		$mrates = $mrates['response'];
		return $mrates;
	}	
}