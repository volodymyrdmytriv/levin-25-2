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

$pluginpath = JPATH_PLUGINS.DS.'iproperty'.DS.'tweetlisting';

require $pluginpath.DS.'assets'.DS.'twitteroauth.php';
require_once JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'helpers'.DS.'route.php';

class plgIpropertyTweetlisting extends JPlugin
{	
	function plgIpropertyTweetlisting(&$subject, $config)  
    {
		parent::__construct($subject, $config);
        $this->loadLanguage();
	}

	function onAfterSavePropertyEdit($prop_id, $isNew = false)
	{
        $app        = JFactory::getApplication();
        $document   = JFactory::getDocument();
        $db         = JFactory::getDBO();
        
        $tweetnew = $this->params->get('tweetnew', false);
        $tweetupd = $this->params->get('tweetupdate', false);
        
        // only tweet new or updated if params are true
        switch ($isNew){
            case 1:
                $message = JText::_('PLG_IP_TWEETLISTING_TWEET_NEW_TEXT');
                if (!$tweetnew) return false;
            break;
            default:
                $message = JText::_('PLG_IP_TWEETLISTING_TWEET_UPDATE_TEXT');
                if (!$tweetupd) return false;
            break; 
        }
        
        // twitter keys / info
        $ckey   = $this->params->get('consumer', false);
        $csec   = $this->params->get('csecret', false);
        $toke   = $this->params->get('token', false);
        $asec   = $this->params->get('asecret', false);
        $geo    = $this->params->get('geocode', false);
        
        // bitly keys-- from http://bitly.com/a/your_api_key
        $bitu   = $this->params->get('bitlyuser', false);
        $bitk   = $this->params->get('bitlykey', false);
        
        // set default lat/lon
        $lat    = '';
        $lon    = '';
        
        if( !$ckey || !$csec || !$toke || !$asec ) return false;
        
        // get the property
        $query = 'SELECT id, latitude, longitude, price, stype_freq, call_for_price FROM #__iproperty WHERE id = '.$db->quote( $prop_id );
        $db->setQuery($query);
        $property = $db->loadObject();
        
        if(!$property) return false;
        
        $link = JURI::root().ipropertyHelperRoute::getPropertyRoute($prop_id);
        if($bitu && $bitk) $link = $this->shortenUrl($link, $bitu, $bitk);

        $message .= '@ '.$link;  
        
        if($this->params->get('showprice', false)) {
            $price = ipropertyHTML::getFormattedPrice($property->price, $property->stype_freq, false, $property->call_for_price);
            $message .= ' - '.$price;
        }    
            
        // if we are geolocating this tweet set lat/lon
        if($geo && $property->latitude && $property->longitude){
            $lat = $property->latitude;
            $lon = $property->longitude;
        }
        
        /* Create a TwitterOauth object with consumer/user tokens. */
        $connection = new TwitterOAuth($ckey, $csec, $toke, $asec);

        $parameters = array();
        $parameters['status'] = $message;
        if($lat) $parameters['lat'] = $lat;
        if($lon) $parameters['long'] = $lon;
        
        $status = $connection->post('statuses/update', $parameters);
        
        return true;
	}
    
    function shortenURL($url, $user, $key)
    {
        $connectURL = 'https://api-ssl.bitly.com/v3/shorten?login='.$user.'&apiKey='.$key.'&uri='.urlencode($url).'&format=txt';
        return $this->curl_get_result($connectURL);
    }

    function curl_get_result($url) 
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }    
    
}