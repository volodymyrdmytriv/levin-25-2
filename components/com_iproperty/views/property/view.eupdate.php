<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license see LICENSE.php
 */

/*
 * TO USE THIS CLASS:
 * SET UP A CRON JOB USING YOUR WEB CONTROL PANEL OR A COMMAND-LINE CRONTAB INTERFACE.
 * CHECK WITH YOUR WEBHOST IF YOU DON'T KNOW HOW TO DO THIS!! IT VARIES BY HOST AND
 * WE CANNOT PROVIDE A 'ONE SIZE FITS ALL' ANSWER.
 * 
 * SET UP THE CRON JOB TO REQUEST THE PAGE "http://yoursite.com/index.php?option=com_iproperty&view=property&format=eupdate&secret=YOUR_JOOMLA_CONFIG_FILE_SECRET_MD5_HASHED&listing=true&search=true&limit=X"
 * 
 * IN THE ABOVE URL, SET listing=false IF YOU DO *NOT* WANT TO SEND UPDATES ON SAVED PROPERTIES 
 * IN THE ABOVE URL, SET search=false IF YOU DO *NOT* WANT TO SEND UPDATES ON SAVED SEARCHES
 * IN THE ABOVE URL, SET limit=X WHERE X = THE MAX LISTINGS YOU WANT TO SEND IN A SAVED SEARCH UPDATE-- RECOMMENDED IS ABOUT 25
 * IN THE ABOVE URL, SET secret = AN MD5 HASH OF YOUR JOOMLA CONFIGURATION.PHP $secret VARIABLE VALUE
 * TO GENERATE AN MD5 HASH TRY http://www.miraclesalad.com/webtools/md5.php 
 *
 * IF BOTH LISTINGS AND SEARCH ARE false, OR SECRET IS ABSENT OR INCORRECT, NOTHING WILL HAPPEN AND NO EMAILS WILL BE SENT!
 * 
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class IpropertyViewProperty extends JView 
{    
    private $searchstring;
    private $limit;
    private $last_sent;
    
    function display($tpl = null)
    {
        $document       = JFactory::getDocument();
        $settings       = ipropertyAdmin::config();
		$config 		= JFactory::getConfig();
		$db             = JFactory::getDbo();
		$key			= JRequest::getVar('secret', false);
        $listing		= JRequest::getBool('listing', false); // pass in if you want to run saved listing update
        $search			= JRequest::getBool('search', false); // pass in if you want to run saved search update
        $this->limit    = JRequest::getInt('limit', 25); // pass in the limit for saved search listings sent
        
		$secret			= md5($config->getValue( 'config.secret' ));

		$date       = JFactory::getDate();
        $nowDate    = $db->Quote($date->toSql());
		
		if ($key != $secret) JExit('COM_IPROPERTY_INVALID_EUPDATE_KEY');
        if (!$search && !$listing) JExit('NO SEARCH UPDATES SPECIFIED');

        // Saved properties updates
        if ($listing && $settings->show_propupdate)
        {
            $query = $db->getQuery(true);
            $query->select('s.id as sid, s.*, p.id as id')
                    ->from('#__iproperty_saved as s')
                    ->join('', '#__iproperty as p on p.id = s.prop_id')
                    ->where('p.modified >= s.last_sent')
                    ->where('s.active')
                    ->where('s.email_update')
                    ->where('s.type = 0');

            $db->setQuery($query);
            if(FALSE != ($result = $db->loadObjectList())){
                foreach($result as $r)
                {
                    $r->address = ipropertyHTML::getPropertyTitle($r->prop_id);
                    $this->sendPropUpdate($r);
                    
                    // SET LAST RUN TO NOW
                    $query = $db->getQuery(true);
                    $query->update('#__iproperty_saved')
                            ->set('last_sent = '.$nowDate)
                            ->where('id = '.(int)$r->sid);
                    
                    $db->setQuery($query);
                    $db->Query();
                }	
            }
        }
        
        // Search criteria updates
        if ($search && $settings->show_searchupdate)
        {
            $query = $db->getQuery(true);
            $query->select('*')
                    ->from('#__iproperty_saved')
                    ->where('active')
                    ->where('email_update')
                    ->where('type = 1');

            $db->setQuery($query);
            if(FALSE != ($result = $db->loadObjectList())){
                foreach($result as $r){
                    parse_str($r->search_string, $this->searchstring);
                    $this->last_sent = $r->last_sent;
                    $props = $this->getData();
                    $this->sendSearchUpdate($props, $r);
                    
                    // SET LAST RUN TO NOW
                    $query = $db->getQuery(true);
                    $query->update('#__iproperty_saved')
                            ->set('last_sent = '.$nowDate)
                            ->where('id = '.(int)$r->id);
                    
                    $db->setQuery($query);
                    $db->query();
                }	
            }
        }
        return true;
    }

    function _displayNoAccess($tpl = null)
    {
        JToolBarHelper::title( '<span class="ip_adminHeader">'.JText::_( 'NO ACCESS' ).'</span>', 'iproperty' );
        JToolBarHelper::back();
        parent::display($tpl);
    }

    private function sendPropUpdate($record)
    {
        if (!is_object($record)) return false;
		$user = JFactory::getUser($record->user_id);
		if($user->block) return false;
		$config = JFactory::getConfig();
		
		$url        = JURI::base().ipropertyHelperRoute::getPropertyRoute($record->prop_id);
        $manageurl  = JURI::base().IpropertyHelperRoute::getIpuserRoute();
		
		$mailer = JFactory::getMailer();
		
		$sender = array( 
			$config->getValue( 'config.mailfrom' ),
			$config->getValue( 'config.fromname' ) 
        );
        
        $secret     = $config->getValue( 'config.secret' );
        $hash       = md5($record->user_id . $record->sid . $secret);
        $unsublink  = JURI::base()."index.php?option=com_iproperty&task=ipuser.unsubscribeSaved&id=".$record->sid."&token=".$hash;
		 
		$mailer->setSender($sender);
		$mailer->addRecipient($user->email);
		
		$subject 	= sprintf(JText::_('COM_IPROPERTY_PROP_UPDATE_SUBJECT'), $config->getValue( 'config.sitename'));
		$body		= '<p>'.sprintf(JText::_('COM_IPROPERTY_PROP_UPDATE_EMAIL'), $record->address, $config->getValue('config.sitename'), $url).'</p>';
        $body      .= '<p><a href="'.$manageurl.'">'.JText::_('COM_IPROPERTY_MANAGE_SAVED').'</a><br />';
        $body      .= '<a href="'.$unsublink.'">'.JText::_('COM_IPROPERTY_UNSUBSCRIBE').'</a><br />';
        $body      .= '<a href="'.$unsublink.'&all=1">'.JText::_('COM_IPROPERTY_UNSUBSCRIBE_ALL').'</a></p>';
		
		$mailer->setSubject($subject);
		$mailer->setBody($body);
        $mailer->isHTML(true);
		
		$send = $mailer->Send();
    }

    private function sendSearchUpdate($props, $record)
    {
        $search_id  = $record->id;
        $user_id    = $record->user_id;
        $manageurl  = JURI::base().IpropertyHelperRoute::getIpuserRoute();
        
        if (!count($props)) return false;
		$user = JFactory::getUser($user_id);
		if($user->block) return false;
		$config = JFactory::getConfig();
		
		$mailer = JFactory::getMailer();
		
		$sender = array( 
			$config->getValue( 'config.mailfrom' ),
			$config->getValue( 'config.fromname' ) 
        );
        
        $secret     = $config->getValue( 'config.secret' );
        $hash       = md5($user_id . $search_id . $secret);
        $unsublink  = JURI::base()."index.php?option=com_iproperty&task=ipuser.unsubscribeSaved&id=".$search_id."&token=".$hash;
		 
		$mailer->setSender($sender);
		$mailer->addRecipient($user->email);
		
		$subject 	= sprintf(JText::_('COM_IPROPERTY_SEARCH_UPDATE_SUBJECT'), $config->getValue( 'config.sitename'));
		$body		= '<p>'.sprintf(JText::_('COM_IPROPERTY_SEARCH_UPDATE_EMAIL'), $record->notes, $config->getValue( 'config.sitename')).'</p>';
        
        $body .= '<ul>';
        foreach ($props as $p){
            $url 	= JURI::base().ipropertyHelperRoute::getPropertyRoute($p->id);
            $title  = IpropertyHtml::getPropertyTitle($p->id);
            $body  .= '<li><a href="'.$url.'">'.$title.'</a></li>';
        }
        $body .= '</ul>';

        $body       .= '<p><a href="'.$manageurl.'">'.JText::_('COM_IPROPERTY_MANAGE_SAVED').'</a><br />';
        $body       .= '<a href="'.$unsublink.'">'.JText::_('COM_IPROPERTY_UNSUBSCRIBE').'</a><br />';
        $body       .= '<a href="'.$unsublink.'&all=1">'.JText::_('COM_IPROPERTY_UNSUBSCRIBE_ALL').'</a></p>';
		
		$mailer->setSubject($subject);
		$mailer->setBody($body);
        $mailer->isHTML(true);
		
		$send = $mailer->Send();
    }
    
    private function getData()
	{
	    $app    = JFactory::getApplication();
        $option = JRequest::getCmd('option');
        $db     = JFactory::getDBO();
		
		if (is_null($this->_data))
		{	
			$where		= $this->buildContentWhere();  
            if (!$where) return false;
            
			$sort		= 'p.price';
			$order	    = 'DESC';
			
			$property = new IpropertyHelperProperty($db);
			$property->setType('properties');
			$property->setWhere( $where );
			$property->setOrderBy( $sort, $order );
            $data = $property->getProperty(0,$this->limit);
		}

		return $data;
	}
    
    private function buildContentWhere()
	{
        $app    = JFactory::getApplication();
        $option = JRequest::getCmd('option');
        
        $db     = JFactory::getDbo();
        
        $searchstring = $this->searchstring;

		if( isset($searchstring['search']) ){
			$searchwhere = array();
            $searchwhere[] = 'LOWER( p.mls_id ) LIKE '.$db->Quote( '%'.$db->getEscaped( $searchstring['search'], true ).'%', false );
			$searchwhere[] = 'LOWER( p.street ) LIKE '.$db->Quote( '%'.$db->getEscaped( $searchstring['search'], true ).'%', false );
            $searchwhere[] = 'LOWER( p.street2 ) LIKE '.$db->Quote( '%'.$db->getEscaped( $searchstring['search'], true ).'%', false );
			$searchwhere[] = 'LOWER( p.description ) LIKE '.$db->Quote( '%'.$db->getEscaped( $searchstring['search'], true ).'%', false );
            $searchwhere[] = 'LOWER( p.city ) LIKE '.$db->Quote( '%'.$db->getEscaped( $searchstring['search'], true ).'%', false );
            $searchwhere[] = 'LOWER( p.county ) LIKE '.$db->Quote( '%'.$db->getEscaped( $searchstring['search'], true ).'%', false );
            $searchwhere[] = 'LOWER( p.region ) LIKE '.$db->Quote( '%'.$db->getEscaped( $searchstring['search'], true ).'%', false );
            $searchwhere[] = 'LOWER( p.title ) LIKE '.$db->Quote( '%'.$db->getEscaped( $searchstring['search'], true ).'%', false );
		}

        $where = array();

        //search string
        if( $searchwhere ) $where[] = "(".implode( ' OR ', $searchwhere ).")";
        // property type checkboxes
        // note: v1.5.5 - modified to pull children as well as parents
        if(isset($searchstring['ptype'])) $where[] = '(pm.cat_id IN ('.$searchstring['ptype'].') OR pm.cat_id IN (SELECT id FROM #__iproperty_categories WHERE parent IN ('.$searchstring['ptype'].')))';
        // location search
        if(isset($searchstring['city'])) $where[] = 'LOWER(p.city) = '.JString::strtolower($db->Quote( $searchstring['city'] ));
        if(isset($searchstring['country'])) $where[] = 'p.country = '.(int) $searchstring['country'];
        if(isset($searchstring['county'])) $where[] = 'LOWER(p.county) = '.JString::strtolower($db->Quote( $searchstring['county'] ));
        if(isset($searchstring['region'])) $where[] = 'LOWER(p.region) = '.JString::strtolower($db->Quote( $searchstring['region'] ));
        if(isset($searchstring['locstate'])) $where[] = 'p.locstate = '.(int) $searchstring['locstate'];
        if(isset($searchstring['province'])) $where[] = 'LOWER(p.province) = '.JString::strtolower($db->Quote( $searchstring['province'] ));
        // sale type
        // note: v1.5.5 - removed check for sale or lease because of dynamic sale type list
        if( isset($searchstring['stype']) ) $where[] = 'p.stype = ' . (int)$searchstring['stype'];
        
        //price
        $price_low  = $searchstring['price_low'];
        $price_hi   = $searchstring['price_high'];
        
        if($price_low && $price_hi) {
			$where[] = '(p.price BETWEEN ' . (int)$price_low . ' AND ' . (int)$price_hi . ')';
		} elseif ($price_low && !$price_hi) {
			$where[] = 'p.price >= ' . (int)$price_low;
		} elseif ($price_hi && !$price_low) {
			$where[] = 'p.price <= ' . (int)$price_hi;
		}

        // square ft
        if(isset($searchstring['sqft_low']) && $searchstring['sqft_high']) $where[] = '(p.sqft BETWEEN ' . (int)$searchstring['sqft_low'] . ' AND ' . (int)$searchstring['sqft_high'] . ')';
		if(isset($searchstring['sqft_low']) && !$searchstring['sqft_high']) $where[] = 'p.sqft >= ' . (int)$searchstring['sqft_low'];
		if(isset($searchstring['sqft_high']) && !$searchstring['sqft_low']) $where[] = 'p.sqft <= ' . (int)$searchstring['sqft_high'];

        // beds
        if(isset($searchstring['beds_low']) && $searchstring['beds_high']) $where[] = '(p.beds BETWEEN ' . (int)$searchstring['beds_low'] . ' AND ' . (int)$searchstring['beds_high'] . ')';
		if(isset($searchstring['beds_low']) && !$searchstring['beds_high']) $where[] = 'p.beds >= ' . (int)$searchstring['beds_low'];
		if(isset($searchstring['beds_high']) && !$searchstring['beds_low']) $where[] = 'p.beds <= ' . (int)$searchstring['beds_high'];

        // baths
        if(isset($searchstring['baths_low']) && $searchstring['baths_high']) $where[] = '(p.baths BETWEEN ' . (int)$searchstring['baths_low'] . ' AND ' . (int)$searchstring['baths_high'] . ')';
		if(isset($searchstring['baths_low']) && !$searchstring['baths_high']) $where[] = 'p.baths >= ' . (int)$searchstring['baths_low'];
		if(isset($searchstring['baths_high']) && !$searchstring['baths_low']) $where[] = 'p.baths <= ' . (int)$searchstring['baths_high'];

        // waterfront, hoa, reo
        if(isset($searchstring['waterfront'])) $where[] = 'p.frontage = 1';
        if(isset($searchstring['hoa'])) $where[] = 'p.hoa = 1';
        if(isset($searchstring['reo'])) $where[] = 'p.reo = 1';
        
        // add in the date search so we get only new/modified listings
        $where[] = '(p.modified >= '.$db->Quote($this->last_sent).' OR p.created >= '.$db->Quote($this->last_sent).')';

        return $where;
	}
}
?>
