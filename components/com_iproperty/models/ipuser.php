<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.model');

class IpropertyModelIPuser extends JModel
{
	var $_id            = null;
	var $_properties    = null;
    var $_searches      = null;
	
	function __construct()
	{
		parent::__construct();
	}

	function getProperties()
	{
        $user       = JFactory::getUser();
        $user_id    = $user->id;
        $settings   = ipropertyAdmin::config();
        
		// Lets load the content if it doesn't already exist
		if( empty($this->_properties)){
			$this->_properties = $this->_db->setQuery(ipropertyHelperQuery::getSavedProperties($user_id));
            $this->_properties = $this->_db->loadObjectList();
		}
        
        foreach($this->_properties as $p){
            $p->street_address  = ipropertyHTML::getStreetAddress($settings, $p->title, $p->street_num, $p->street, $p->street2, $p->apt, $p->hide_address);
            $p->proplink        = JRoute::_(ipropertyHelperRoute::getPropertyRoute($p->prop_id.':'.$p->alias));
            $p->formattedprice  = ipropertyHTML::getFormattedPrice($p->price, $p->stype_freq, false, $p->call_for_price);
            $p->thumb           = ipropertyHTML::getThumbnail($p->prop_id, '', $p->street_address, 150, 'class="ip_overview_thumb"');
        }

		return $this->_properties;
	}
    
	function getSearches()
	{
        $user    = JFactory::getUser();
        $user_id = $user->id;
		// Lets load the content if it doesn't already exist
		if( empty($this->_searches)){
			$this->_searches = $this->_db->setQuery(ipropertyHelperQuery::getSavedSearches($user_id));
            $this->_searches = $this->_db->loadObjectList();
		}

		return $this->_searches;
	}    

    function saveProperty($propid, $notes = '', $email_update = 1)
    {
        $user    = JFactory::getUser();
        $user_id = $user->id;
        JPluginHelper::importPlugin( 'iproperty' );
        $dispatcher    = JDispatcher::getInstance();
        $query = $this->_db->setQuery(ipropertyHelperQuery::saveProperty($propid, $user_id, $notes, $email_update));
        if( $this->_db->Query() ){
            if( $settings->notify_saveprop == 1 ){
                ipropertyHTML::notifyAdmin($propid );
            }
            $dispatcher->trigger( 'onAfterSaveFavorite', array( $propid, $user_id, $notes, $email_update ) );
            return true;
        }else{
            return false;
        }
    }

    function deleteSaved($id)
    {
        $user = JFactory::getUser();
        $user_id = $user->id;

        $query = $this->_db->setQuery(ipropertyHelperQuery::deleteSavedProperty($id, $user_id));
        if( $this->_db->Query() ){
            return true;
        }else{
            return false;
        }
    }
    
    function saveSearch($searchstring, $notes = '', $email_update = 1)
    {
        $user    = JFactory::getUser();
        $user_id = $user->id;
        
        if(!$notes) $notes = JText::_('COM_IPROPERTY_SEARCH').'_'.rand();
        
        $query = $this->_db->setQuery(ipropertyHelperQuery::saveSearch($searchstring, $user_id, $notes, $email_update));
        if( $this->_db->Query() ){
            return true;
        }else{
            return false;
        }
    }    
    
    function updateEmailSubscribe($id)
    {	
        $user       = JFactory::getUser();
        $user_id    = $user->id;
        
        $query = $this->_db->getQuery(true);
        $query->update('#__iproperty_saved')
                ->set('email_update = !email_update')
                ->where('id = '.(int)$id)
                ->where('user_id = '.$user_id);
        
        $this->_db->setQuery($query);
        if( $this->_db->Query() ){
            return true;
        }else{
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
    }
    
    // this is for a generic unsubscribe link to be included in the update emails
    function emailUnsubscribe($id, $token, $all=false)
    {	
        $query = $this->_db->getQuery(true);
        $query->select('*')
                ->from('#__iproperty_saved')
                ->where('id = '.(int) $id);
        
        $this->_db->setQuery($query);
        if( FALSE !== ($result = $this->_db->loadObject()) ){
            // check the token and set email_update to false
            $config     = JFactory::getConfig();
            $secret     = $config->getValue( 'config.secret' );
            $hash       = md5($result->user_id . $result->id . $secret);
            if ($hash == $token){
                $query = $this->_db->getQuery(true);
                if($all){                    
                    $query->update('#__iproperty_saved')
                            ->set('email_update = 0')
                            ->where('user_id = '.(int)$result->user_id);
                } else {
                    $query->update('#__iproperty_saved')
                            ->set('email_update = 0')
                            ->where('id = '.(int)$result->id);
                }
                $this->_db->setQuery($query);
                if( $this->_db->Query() ){
                    return true;
                }else{
                    $this->setError($this->_db->getErrorMsg());
                    return false;
                }
            } else {
                $this->setError(JText::_('COM_IPROPERTY_INVALID_ID_OR_TOKEN_PASSED'));
                return false;
            }
        }else{
            $this->setError(JText::_('COM_IPROPERTY_RECORD_NOT_FOUND'));
            return false;
        }    
    }  
    
    function approveListing($id, $token)
    {	
        $query = $this->_db->getQuery(true);
        $query->select('*')
                ->from('#__iproperty')
                ->where('id = '.(int) $id);
        
        $this->_db->setQuery($query);
        if( $result = $this->_db->loadObject() ){
            // check the token and set email_update to false
            $config     = JFactory::getConfig();
            $secret     = $config->getValue( 'config.secret' );
            $hash       = md5($result->id.$secret);
            if ($hash == $token){
                $query = $this->_db->getQuery(true);
                $query->update('#__iproperty')
                            ->set('approved = 1')
                            ->where('id = '.(int)$result->id);
                $this->_db->setQuery($query);
                if( $this->_db->Query() ){
                    $this->_notifyApproval($id);
                    return true;
                }else{
                    $this->setError($this->_db->getErrorMsg());
                    return false;
                }
            } else {
                $this->setError(JText::_('COM_IPROPERTY_INVALID_ID_OR_TOKEN_PASSED'));
                return false;
            }
        }else{
            $this->setError(JText::_('COM_IPROPERTY_PROPERTY_NOT_FOUND'));
            return false;
        }    
    }
    
    protected function _notifyApproval($propid)
    {
        //send notification of approval to agents
        $app  = JFactory::getApplication();

        $settings      = ipropertyAdmin::config();
        $admin_from    = $app->getCfg('fromname');
        $admin_email   = $app->getCfg('mailfrom');
        $property_path = JURI::base().ipropertyHelperRoute::getPropertyRoute($propid);

        $agents        = ipropertyHTML::getAvailableAgents($propid);
        $property      = ipropertyHTML::getPropertyTitle($propid);

		$subject        = sprintf(JText::_( 'COM_IPROPERTY_APPROVAL_SUBJECT' ), $property);
		$date           = JHTML::_('date','now',JText::_('DATE_FORMAT_LC4'));
        $fulldate       = JHTML::_('date','now',JText::_('DATE_FORMAT_LC2'));

        //check who admin wants to send the requests to
        $recipients = array();
        foreach($agents as $a){
            $recipients[] = $a->email;
        }     
        
		$body = sprintf(JText::_('COM_IPROPERTY_APPROVAL_BODY'), $property, $admin_from)."\n\n";
        $body .= JText::_( 'COM_IPROPERTY_FOLLOW_LINK' ) . ":\n"
                . $property_path . "\n\n"
                . JText::_( 'COM_IPROPERTY_GENERATED_BY_INTELLECTUAL_PROPERTY' ) . " " . $fulldate;

        $sento = '';
        $mail = JFactory::getMailer();
        $mail->addRecipient( $recipients );
        $mail->addReplyTo(array($admin_email, $admin_from));
        $mail->setSender( array( $admin_email, $admin_from ));
        $mail->setSubject( $subject );
        $mail->setBody( $body );
        $sento = $mail->Send();

		if( $sento ){
            return true;
		}else{
			return false;
		}
    }
}

?>