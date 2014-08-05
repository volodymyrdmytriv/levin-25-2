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

class IpropertyModelProperty extends JModel
{
	var $_type          = null;
	var $_data          = null;
	var $_id            = null;
    var $_ptype         = null;
	var $_stype         = null;
	var $_city          = null;
	var $_state         = null;
	var $_where         = null;
	var $_curstate      = null;
	var $_searchword    = null;
	var $_total         = null;
    var $_featured      = null;

	function __construct()
	{
		parent::__construct();

		$app  = JFactory::getApplication();
        $option     = JRequest::getCmd('option');
        
		$settings = ipropertyAdmin::config();
		$id       = JRequest::getInt('id');
		$this->setId($id);
	}

	function setId($id)
	{
		$this->_id	    = $id;
		$this->_data	= null;
	}
	
	function getSpacesAvailable()
	{
		$query_spaces = $this->_db->getQuery(true);
		$query_spaces->select('*')
			->from('#__iproperty_spaces')
			->where('prop_id=' . $this->_id);
		
		$query_tenants = $this->_db->getQuery(true);
		$query_tenants->select('*')
			->from('#__iproperty_tenants')
			->where('prop_id=' . $this->_id);
			//->where('available=1');
		
		$query_sfilled = $this->_db->getQuery(true);
		$query_sfilled->select('s.*, st.id as tenant_id')
			->from('('.$query_spaces.') AS s LEFT JOIN ('.$query_tenants.') AS st ON (s.id = st.space_id)');

		$query = $this->_db->getQuery(true);
		$query->select('filled_spaces.*')
			->from('('.$query_sfilled->__toString().') as filled_spaces')
			->where('filled_spaces.tenant_id IS NULL')
			->order('filled_spaces.space_id2 ASC');
		
		$this->_db->setQuery($query);
		$result = $this->_db->loadObjectList();
		
		for($i = 0; $i < count($result); $i++) {
			
			$result[$i]->formatted_space_sqft = number_format($result[$i]->space_sqft) . ' sq. ft.';
			
		}
		
		return $result;
	}
	
	function getTenants()
	{
		
		$query = $this->_db->getQuery(true);
		$query->select('t.*, s.space_id2')
			->from('#__iproperty_tenants AS t, #__iproperty_spaces AS s')
			->where('t.prop_id=' . $this->_id)
			//->where('t.available = 1')
			->where('s.prop_id=' . $this->_id)
			->where('t.space_id=s.id')
			->order('s.space_id2 ASC');
		
		$this->_db->setQuery($query);
		$result = $this->_db->loadObjectList();
		
		return $result;
	}
	
	function getDemographics()
	{
		
		$query = $this->_db->getQuery(true);
		$query->select('*')
			->from('#__iproperty_demographics')
			->where('prop_id=' . $this->_id)
			->where('stat_id=1')
			->where('miles1_value > 0 AND miles2_value > 0 AND miles3_value > 0');
		
		$this->_db->setQuery($query);
		$result = $this->_db->loadObjectList();
		
		// checking if miles are set ...
		if(count($result) == 0)
		{
			// returning empty array
			return $result;
		}
		
		$query = $this->_db->getQuery(true);
		$query->select('d.*, ds.stat_name, ds.stat_value_type')
			->from('#__iproperty_demographics as d, #__iproperty_demographics_stats as ds')
			->where('d.prop_id = '.$this->_id)
			->where('d.stat_id = ds.id')
			->where('d.miles1_value > 0 AND d.miles2_value > 0 AND d.miles3_value > 0')
			->group('d.stat_id')
			->order('ds.order ASC');
		
		$this->_db->setQuery($query);
		$result = $this->_db->loadObjectList();
		
		
		
		return $result;
	}
	
	function getAgents()
	{
		
		$result = ipropertyHTML::getAvailableAgents($this->_id);
		
		return $result;
	}
	
	function getData()
	{
	    $app  = JFactory::getApplication();
        $option     = JRequest::getCmd('option');
        
		$settings =  ipropertyAdmin::config();

		if (empty($this->_data))
		{
			// Get the WHERE and ORDER BY clauses for the query
			$where		= $this->_buildContentWhere();			
            $this->_property = new ipropertyHelperproperty($this->_db);
			$this->_property->setType('property');
			$this->_property->setWhere( $where );
			$this->_data = $this->_property->getProperty(0,1);
            if($this->_data) $this->hit();
		}
		return $this->_data;
	}

	function _buildContentWhere()
	{
		$where   = array();
        $where[] = 'p.id = ' . (int)$this->_id;
		$this->_where = $where;

		return $this->_where;
	}
	
    function getImages($title = 'property')
    {
        $query = $this->_db->getQuery(true);
        $query->select('*, title AS img_title, description AS img_description')
                ->from('#__iproperty_images')
                ->where('propid = '.(int)$this->_id)
                ->where('(type = ".jpg" OR type = ".jpeg" OR type = ".gif" OR type = ".png")')
                ->where('title = '.$this->_db->Quote($title))
                ->order('ordering ASC');
                
        $this->_db->setQuery($query);

  		$result = $this->_db->loadObjectList();
  		return $result;
  	}

    function getdocs()
	{
		$query = $this->_db->getQuery(true);
        $query->select('*')
                ->from('#__iproperty_images')
                ->where('propid = '.(int)$this->_id)
                ->where('(type != ".jpg" AND type != ".jpeg" AND type != ".gif" AND type != ".png")')
                ->order('type, ordering ASC');
        
        $this->_db->setQuery($query);

		$this->_docs = $this->_db->loadObjectList();
		return $this->_docs;
	}    
	
	function getDocsByTitle($title='title')
	{
		$query = $this->_db->getQuery(true);
        $query->select('*')
                ->from('#__iproperty_images')
                ->where('propid = '.(int)$this->_id)
                ->where('(type != ".jpg" AND type != ".jpeg" AND type != ".gif" AND type != ".png")')
                ->where('title = '.$this->_db->Quote($title))
                ->order('ordering DESC');
                
        $this->_db->setQuery($query, 0, 1);

  		$result = $this->_db->loadObjectList();
  		return $result;
	}

	function hit()
	{
		if ($this->_id)
		{
			$this->_db->setQuery(ipropertyHelperQuery::incrementPropertyHits($this->_id));
            $this->_db->Query();
			return true;
		}
		return false;
	}

	function sendTofriend($post)
    {
		//attempt to send message to recipients
		$app  = JFactory::getApplication();

		JPluginHelper::importPlugin( 'iproperty' );
        $dispatcher    = JDispatcher::getInstance();
        $db            = JFactory::getDBO();
        $user          = JFactory::getUser();
        $user_id       = $user->get('id');
        $settings      = ipropertyAdmin::config();
        $property_path = @$_SERVER['HTTP_REFERER'];
        if (empty($property_path) || !JURI::isInternal($property_path)) {
            $property_path = JURI::base();
        }

        $admin_from    = $app->getCfg('fromname');
        $admin_email   = $app->getCfg('mailfrom');


		//set main email configuration
        $orig_recipients = str_replace(' ','',$post['recipient_email']);
		$recipients      = explode(',', $post['recipient_email']);
		$from_name       = ($post['sender_name']) ? $post['sender_name'] : '--N/A--';
		$from_email      = ($post['sender_email']) ? $post['sender_email'] : '--N/A--';
        $prop_id         = $post['id'];
        $comments        = ($post['comments']) ? $post['comments'] : '--N/A--';
		$mode            = 1;
		$subject         = $from_name . ' ' . JText::_( 'COM_IPROPERTY_HAS_SENT_INVITATION' ) . '!';
		$date            = JHTML::_('date','now',JText::_('DATE_FORMAT_LC4'));
        $fulldate        = JHTML::_('date','now',JText::_('DATE_FORMAT_LC2'));

		$body = JText::_( 'COM_IPROPERTY_YOUR_FRIEND' ) . ", " . $from_name . " (" . $from_email . ") " . JText::_( 'COM_IPROPERTY_PROPERTY_INVITE' ). " "
			. $app->getCfg('sitename') . " " . JText::_( 'COM_IPROPERTY_ON' ) . " " . $date . ".\r\n\r\n"
            . JText::_( 'COM_IPROPERTY_SENDER_NAME' ) . ": " . $from_name . "\r\n"
            . JText::_( 'COM_IPROPERTY_SENDER_EMAIL' ) . ": " . $from_email . "\r\n\r\n"
            
			. JText::_( 'COM_IPROPERTY_FRIEND_COMMENTS' ) . ":\r\n"
            . $comments . "\r\n\r\n"
            . JText::_( 'COM_IPROPERTY_FOLLOW_LINK' ) . ":\r\n"
            . $property_path . "\r\n\r\n"
            . JText::_( 'COM_IPROPERTY_GENERATED_BY_INTELLECTUAL_PROPERTY' ) . " " . $fulldate;

		$sento = '';
		$mail = JFactory::getMailer();
        $mail->addRecipient( $recipients );
        $mail->addReplyTo(array($from_email, $from_name));
        $mail->setSender( array( $admin_email, $admin_from ));
        $mail->setSubject( $subject );
        $mail->setBody( $body );
        $sento = $mail->Send();

		if( $sento ){
			//send a confirmation email to admin
			if( $admin_email && $settings->notify_sendfriend == 1 ){
                $copySubject = JText::_( 'COM_IPROPERTY_COPY_OF' ).": ".$subject;

                $copyBody   = JText::_( 'COM_IPROPERTY_COPY_OF_MESSAGE' ).":\r\n";
                $copyBody   .= JText::_('COM_IPROPERTY_COPY_EMAIL_1') . " " . $app->getCfg('sitename') . "\r\n";
                $copyBody   .= JText::_( 'COM_IPROPERTY_SENT_TO_FOLLOWING' ) . ": " . $post['recipient_email'] . "\r\n";
                $copyBody   .= "-----------------------------------------------------------------\r\n\r\n";
                $copyBody   .= $body;                

                $mail = JFactory::getMailer();
                $mail->addRecipient( $admin_email );
                $mail->setSender( array( $admin_email, $admin_from ) );
                $mail->setSubject( $copySubject );
                $mail->setBody( $copyBody );
                $mail->Send();
            }
            $dispatcher->trigger( 'onAfterSendFriend', array( $prop_id, $user->id, $post, $settings ) );
			return true;
		}else{
			return false;
		}
	}

	function sendRequest($post)
    {
		$app  = JFactory::getApplication();

		JPluginHelper::importPlugin( 'iproperty' );
        $dispatcher    = JDispatcher::getInstance();
        $user          = JFactory::getUser();
        $settings      = ipropertyAdmin::config();
        $admin_from    = $app->getCfg('fromname');
        $admin_email   = $app->getCfg('mailfrom');
        $property_path = @$_SERVER['HTTP_REFERER'];
        if (empty($property_path) || !JURI::isInternal($property_path)) {
            $property_path = JURI::base();
        }

		//set main email configuration
        $propid        = $post['id'];
		$from_name     = $post['sender_name'];
		$from_email    = $post['sender_email'];
        $from_dphone   = ($post['sender_dphone']) ? $post['sender_dphone'] : '--';
        $from_ephone   = ($post['sender_ephone']) ? $post['sender_ephone'] : '--';
        $from_contact  = ($post['sender_preference']) ? $post['sender_preference'] : '--';
        $from_ctime    = ($post['sender_ctime']) ? $post['sender_ctime'] : '--';
        $from_commt    = ($post['special_requests']) ? $post['special_requests'] : '--';

        $agents        = ipropertyHTML::getAvailableAgents($propid);
        $company_email = ipropertyHTML::getCompanyEmail($post['c_id']);
        $property      = ipropertyHTML::getPropertyTitle($propid);

        $cc             = ($post['copy_me']) ? $post['sender_email'] : '';
        $bcc            = $settings->form_copyadmin;
		$subject        = $app->getCfg('fromname').' '.JText::_( 'COM_IPROPERTY_SHOW_REQUEST' ).' ['.$from_name.']';
		$date           = JHTML::_('date','now',JText::_('DATE_FORMAT_LC4'));
        $fulldate       = JHTML::_('date','now',JText::_('DATE_FORMAT_LC2'));

        //check who admin wants to send the requests to
        $recipients = array();
        switch($settings->form_recipient){
            case '0': //send to admin only
                $recipients[] = $admin_email;
            break;
            case '1': //send to agent
                foreach($agents as $a){
                    $recipients[] = $a->email;
                }
            break;
            case '2': //send to company
                $recipients[] = $company_email;
            break;
            case '3': //send to agent and company
                foreach($agents as $a){
                    $recipients[] = $a->email;
                }
                $recipients[] = $company_email;
            break;
            default:
                $recipients[] = $admin_email;
            break;
        }       
        
		$body = $from_name . " (" . $from_email . ") " . JText::_( 'COM_IPROPERTY_HAS_REQUESTED' ) . " " . $property . " " . JText::_( 'COM_IPROPERTY_PROPERTY_FOUND_AT' ) . " "
                . $app->getCfg('sitename') . " " . JText::_( 'COM_IPROPERTY_ON' ) . " " . $date . ".\r\n\r\n"
                . JText::_( 'COM_IPROPERTY_SENDER_NAME' ) . ": " . $from_name . "\r\n"
                . JText::_( 'COM_IPROPERTY_SENDER_EMAIL' ) . ": " . $from_email . "\r\n"
                . JText::_( 'COM_IPROPERTY_SENDER_DAY_PHONE' ) . ": " . $from_dphone . "\r\n"
                . JText::_( 'COM_IPROPERTY_SENDER_EVENING_PHONE' ) . ": " . $from_ephone . "\r\n"
                . JText::_( 'COM_IPROPERTY_SENDER_CONTACT_BY' ) . ": " . $from_contact . "\r\n"
                . JText::_( 'COM_IPROPERTY_SENDER_CONTACT_TIME' ) . ": " . $from_ctime . "\r\n\r\n"
                
                . JText::_( 'COM_IPROPERTY_SENDER_COMMENTS' ) . ":\r\n"
				. $from_commt . "\r\n\r\n"
				. JText::_( 'COM_IPROPERTY_FOLLOW_LINK' ) . ":\r\n"
                . $property_path . "\r\n\r\n"
                . JText::_( 'COM_IPROPERTY_GENERATED_BY_INTELLECTUAL_PROPERTY' ) . " " . $fulldate;

        $sento = '';
        $mail = JFactory::getMailer();
        $mail->addRecipient( $recipients );
        $mail->addReplyTo(array($from_email, $from_name));
        $mail->setSender( array( $admin_email, $admin_from ));
        $mail->setSubject( $subject );
        $mail->setBody( $body );
        $sento = $mail->Send();

		if( $sento ){
            
            $copySubject 	= JText::_( 'COM_IPROPERTY_COPY_OF' ).": ".$subject;
            //send copy to sender if requested
            if($cc){
                $copyBody 		= JText::_( 'COM_IPROPERTY_COPY_OF_MESSAGE' ).":";
                $copyBody 		.= "\r\n\r\n".$body;
                $recipients[]   = $cc;

                $mail = JFactory::getMailer();
                $mail->addRecipient( $cc );
                $mail->setSender( array( $admin_email, $admin_from ) );
                $mail->setSubject( $copySubject );
                $mail->setBody( $copyBody );
                $mail->Send();
            }
            //send copy to admin email
            if($bcc){                
                $copyBody 		= JText::_( 'COM_IPROPERTY_COPY_OF_MESSAGE' )." -- ".JText::_( 'COM_IPROPERTY_OTHER_RECIPIENTS' ).": ".implode(',',$recipients);
                $copyBody 		.= "\r\n\r\n".$body;

                $mail = JFactory::getMailer();
                $mail->addRecipient( $admin_email );
                $mail->setSender( array( $admin_email, $admin_from ) );
                $mail->setSubject( $copySubject );
                $mail->setBody( $copyBody );
                $mail->Send();
            }
			//uncomment the following lines to see where this email is going
            //$final_send = 'send to: '.implode(',', $recipients).'<br />cc: '. $cc . '<br />bcc: '.$bcc;
            //return $final_send;
            //Trigger plugins to perform actions after a request is made
            $dispatcher->trigger( 'onAfterPropertyRequest', array( $propid, $user->id, $post, $settings ) );
            return true;
		}else{
			return false;
		}
	}

    function getAmenities()
    {
        return ipropertyHTML::getPropertyAmens($this->_id);
    }
}//end class

?>