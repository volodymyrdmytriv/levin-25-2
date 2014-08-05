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

class plgIpropertyAgentqr extends JPlugin
{	
	function plgIpropertyAgentqr(&$subject, $config)  
    {
		parent::__construct($subject, $config);
        $this->loadLanguage();
	}

	function onAfterRenderAgent($a, $settings)
	{
        $app = JFactory::getApplication();
        $document = JFactory::getDocument();
        
        $format = $this->params->get('format', 0);
        $size   = $this->params->get('size', 250);
        
        // create the agent address object
        $address = $a->street ? $a->street : '';
        $address .= $a->street2 ? ' '.$a->street2 : '';
        $address .= $a->locstate ? ', '.ipropertyHTML::getStateName($a->locstate) : '';
        $address .= $a->province ? ', '.$a->province : '';
        $address .= $a->postcode ? ', '.$a->postcode : '';
        $address .= $a->country ? ' '.ipropertyHTML::getCountryName($a->country) : '';     

        // get image if exists
        $picture = $a->icon != 'nopic.png' ? JURI::root().'media/com_iproperty/agents/'.$a->icon : '';
        
        if($format){ // create mecard
            $data = 'MECARD:N:'.$a->lname.','.$a->fname.';TEL:'.$a->phone.';EMAIL:'.$a->email.';NOTE:'.$a->companyname.';ADR:'.$address.';URL:'.$a->website; 
        } else { // create vcard
            $data='BEGIN:VCARD;VERSION:4.0;N:'.$a->lname.';'.$a->fname.';;;FN:'.$a->agentname.';ORG:'.$a->companyname.';PHOTO:'.$picture.';TEL;TYPE="work,voice";VALUE=uri:tel:+1-'.$a->phone.';TEL;TYPE="mobile,voice";VALUE=uri:tel:+1-'.$a->mobile.';ADR;TYPE=work;LABEL="'.$address.'";EMAIL:'.$a->email.';END:VCARD';
        }
        
        $data = urlencode($data);
        $image = '<div class="ip_qrcode" style="float: right;"><img src="https://chart.googleapis.com/chart?chld=L|1&chs='.$size.'x'.$size.'&cht=qr&chl='.$data.'" /></div>';
        echo $image;
	}
}