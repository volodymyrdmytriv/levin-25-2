<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

class IpropertyControllerProperty extends JController
{
	protected $text_prefix = 'COM_IPROPERTY';

	public function sendTofriend()
    {

        jimport( 'joomla.mail.helper' );
        $post = JRequest::get('post');
        JRequest::checkToken() or die( 'Invalid Token!' );
        //set session variables for ip form data
        $session = JFactory::getSession();
        $session->set('ip_sender_name', $post['sender_name']);
        $session->set('ip_sender_email', $post['sender_email']);
        $session->set('ip_sender_recipient_email', $post['recipient_email']);
        $session->set('ip_sender_comments', $post['comments']);

        #TODO: replace with base64encode
        $link = @$_SERVER['HTTP_REFERER'];
        if (empty($link) || !JURI::isInternal($link)) {
            $link = JURI::base();
        }

        if( !JMailHelper::isEmailAddress( $post['sender_email'] )){
            $msg = JText::_( 'COM_IPROPERTY_MSG_NOT_SENT_EMAIL_INVALID' );
            $type = 'notice';
        }else{
            $model = $this->getModel('property');

            // New captcha plugin validation
            $captcha_validate = true;
            if(JPluginHelper::isEnabled('iproperty', 'ipcaptcha')){
                JPluginHelper::importPlugin( 'iproperty' );
                $dispatcher = JDispatcher::getInstance();
                $captcha_validate = $dispatcher->trigger( 'onValidateIpCaptcha', array( 'stf' ));
                $captcha_validate = $captcha_validate[0];
            }

            if($captcha_validate){
                if($model->sendTofriend($post)){
                    $msg = JText::_( 'COM_IPROPERTY_SEND_TO_FRIEND_CONFIRM' ) . ': <br />' . $post['recipient_email'];
                    $type = 'message';
                    $session->clear('ip_sender_recipient_email');
                    $session->clear('ip_sender_comments');
                }else{
                    $msg = JText::_( 'COM_IPROPERTY_SEND_TO_FRIEND_FAIL' );
                    $type = 'notice';
                }
            }else{
                $msg = JText::_( 'COM_IPROPERTY_MSG_NOT_SENT_CAPTCHA_INVALID' );
                $type = 'notice';
            }
        }
        $this->setRedirect($link, $msg, $type);
    }

    public function sendRequest()
    {

        jimport( 'joomla.mail.helper' );
        $post = JRequest::get('post');
        JRequest::checkToken() or die( 'Invalid Token!' );
        //set session variables for ip form data
        $session = JFactory::getSession();
        $session->set('ip_sender_name', $post['sender_name']);
        $session->set('ip_sender_email', $post['sender_email']);
        $session->set('ip_sender_dphone', $post['sender_dphone']);
        $session->set('ip_sender_ephone', $post['sender_ephone']);
        $session->set('ip_sender_preference', $post['sender_preference']);
        $session->set('ip_sender_ctime', $post['sender_ctime']);
        $session->set('ip_sender_special_requests', $post['special_requests']);
        $session->set('ip_sender_copy_me', $post['copy_me']);

        #TODO: replace with base64encode
        $link = @$_SERVER['HTTP_REFERER'];
        if (empty($link) || !JURI::isInternal($link)) {
            $link = JURI::base();
        }

        if( !JMailHelper::isEmailAddress( $post['sender_email'] )){
            $msg = JText::_( 'COM_IPROPERTY_MSG_NOT_SENT_EMAIL_INVALID' );
            $type = 'notice';
        }else{
            $model = $this->getModel('property');

            // New captcha plugin validation
            $captcha_validate = true;
            if(JPluginHelper::isEnabled('iproperty', 'ipcaptcha')){
                JPluginHelper::importPlugin( 'iproperty' );
                $dispatcher = JDispatcher::getInstance();
                $captcha_validate = $dispatcher->trigger( 'onValidateIpCaptcha', array( 'req' ));
                $captcha_validate = $captcha_validate[0];
            }

            // Check if captcha was validated if enabled - else continue with form processing
            if($captcha_validate){
                if($model->sendRequest($post)){
                    $msg = JText::_( 'COM_IPROPERTY_SEND_REQUEST_SHOWING_CONFIRM' );
                    $type = 'message';
                    $session->clear('ip_sender_special_requests');
                }else{
                    $msg = JText::_( 'COM_IPROPERTY_SEND_REQUEST_SHOWING_FAIL' );
                    $type = 'notice';
                }
            }else{
                $msg = JText::_( 'COM_IPROPERTY_MSG_NOT_SENT_CAPTCHA_INVALID' );
                $type = 'notice';
            }
        }
        $this->setRedirect($link, $msg, $type);
    }
}
