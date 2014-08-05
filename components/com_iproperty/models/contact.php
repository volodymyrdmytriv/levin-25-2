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

class IpropertyModelContact extends JModel
{
	var $_id          = null;
    var $_contact     = null;
	
	function __construct()
	{
		parent::__construct();

        $id = JRequest::getInt('id');
		$this->setId($id);
	}
    
    function setId($id)
	{
		$this->_id	    = $id;
		$this->_contact	= null;
	}

    function contactInfo($type = null)
	{
        if(!$type || ($type != 'agent' && $type != 'company')) return false;

		if (empty($this->_contact))
		{
			switch($type){
                case "agent":
                    $this->_contact = ipropertyHelperQuery::buildAgent($this->_id);
                break;
                case "company":
                    $this->_contact = ipropertyHelperQuery::buildCompany($this->_id);
                break;
            }
		}
		return $this->_contact;
	}

    function sendContact($post)
    {
		//attempt to send message to recipients
		$app  = JFactory::getApplication();

		$dispatcher    = JDispatcher::getInstance();
        $db            = JFactory::getDBO();
        $user          = JFactory::getUser();
        $user_id       = $user->get('id');
        $settings      = ipropertyAdmin::config();

        $admin_from     = $app->getCfg('fromname');
        $admin_email    = $app->getCfg('mailfrom');
        $from_name      = $post['sender_name'];
		$from_email     = $post['sender_email'];
        $from_dphone    = ($post['sender_dphone']) ? $post['sender_dphone'] : '--N/A--';
        $from_ephone    = ($post['sender_ephone']) ? $post['sender_ephone'] : '--N/A--';
        $from_contact   = ($post['sender_preference']) ? $post['sender_preference'] : '--N/A--';
        $from_commt     = ($post['special_requests']) ? $post['special_requests'] : '--N/A--';
        $cc             = ($post['copy_me']) ? true : false;
		$mode           = 1;
		$subject        = $app->getCfg('sitename').' '.JText::_( 'COM_IPROPERTY_CONTACT_INQUIRY' );
		$date           = JHTML::_('date','now',JText::_('DATE_FORMAT_LC4'));
        $fulldate       = JHTML::_('date','now',JText::_('DATE_FORMAT_LC2'));

        if($post['ctype'] == 'company'){
            //get company email
            $co_id = $post['id'];
            $company = ipropertyHelperQuery::buildCompany($co_id);
            $contact_email = $company->email;
            //$contact_email = 'vincent@thethinkery.net';
        }elseif($post['ctype'] == 'agent'){
            //get agent email
            $agent_id = $post['id'];
            $agent = ipropertyHelperQuery::buildAgent($agent_id);
            $contact_email = $agent->email;
        }else{
            return false;
        }

        $body = $from_name." ".JText::_( 'COM_IPROPERTY_CONTACT_EMAIL' )." ".$app->getCfg('sitename')." ".JText::_( 'IPROPERTY_ON' )." ".$date."\r\n\r\n"
                .JText::_( 'COM_IPROPERTY_SENDER_NAME' ).": ".$from_name."\r\n"
                .JText::_( 'COM_IPROPERTY_SENDER_EMAIL' ).": ".$from_email."\r\n"
                .JText::_( 'COM_IPROPERTY_SENDER_DAY_PHONE' ).": ".$from_dphone."\r\n"
                .JText::_( 'COM_IPROPERTY_SENDER_EVENING_PHONE' ).": ".$from_ephone."\r\n"
                .JText::_( 'COM_IPROPERTY_SENDER_CONTACT_BY' ).": ".$from_contact."\r\n"
                .JText::_( 'COM_IPROPERTY_SENDER_COMMENTS' ) . ":\r\n"
				.$from_commt."\r\n\r\n"
				.JText::_( 'COM_IPROPERTY_GENERATED_BY_INTELLECTUAL_PROPERTY' )." ".$fulldate;

		$sento = '';
		$mail = JFactory::getMailer();
        $mail->addRecipient( $contact_email );
        $mail->addReplyTo(array($from_email, $from_name));
        $mail->setSender( array( $admin_email, $admin_from ));
        $mail->setSubject( $subject );
        $mail->setBody( $body );
        $sento = $mail->Send();

		if( $sento ){
			//send a confirmation email to admin
            //TODO: new setting in admin for copying admin on contact inquiries
            //TODO: plugin for onAfterSendContact
            /*
			if( $admin_email && $settings->notify_sendfriend == 1 ){
                $copySubject = JText::_( 'COM_IPROPERTY_COPY_OF' ).": ".$subject;

                $copyBody   = JText::_( 'COM_IPROPERTY_COPY_OF_MESSAGE' ).":\r\n";
                $copyBody   .= JText::_('COPY EMAIL 1') . " " . $app->getCfg('sitename') . "\r\n";
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
            $dispatcher->trigger( 'onAfterSendFriend', array( $propid, $user->id, $post, $settings ) );
             *
             */
            //if cc sender, send copy of email to sender email
			if( $cc ){
                $copySubject = JText::_( 'COM_IPROPERTY_COPY_OF' ).": ".$subject;

                $copyBody   = JText::_( 'COM_IPROPERTY_COPY_OF_MESSAGE' ).":\r\n";
                $copyBody   .= "-----------------------------------------------------------------\r\n\r\n";
                $copyBody   .= $body;

                $mail = JFactory::getMailer();
                $mail->addRecipient( $from_email );
                $mail->setSender( array( $admin_email, $admin_from ) );
                $mail->setSubject( $copySubject );
                $mail->setBody( $copyBody );
                $mail->Send();
            }
            return true;
		}else{
			return false;
		}
	}
}

?>