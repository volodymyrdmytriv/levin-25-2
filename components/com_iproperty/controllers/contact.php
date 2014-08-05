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

class IpropertyControllerContact extends JController
{
	protected $text_prefix = 'COM_IPROPERTY';

	public function contactForm()
    {
        jimport( 'joomla.mail.helper' );
        $post = JRequest::get('post');
        JRequest::checkToken() or die( 'Invalid Token!' );
        #TODO: replace with base64encode
        $link = @$_SERVER['HTTP_REFERER'];
        if (empty($link) || !JURI::isInternal($link)) {
            $link = JURI::base();
        }

        if( !JMailHelper::isEmailAddress( $post['sender_email'] )){
            $msg = JText::_( 'COM_IPROPERTY_MSG_NOT_SENT_EMAIL_INVALID' );
            $type = 'notice';
        }else{
            $model = $this->getModel('contact');

            // New captcha plugin validation
            $captcha_validate = true;
            if(JPluginHelper::isEnabled('iproperty', 'ipcaptcha')){
                JPluginHelper::importPlugin( 'iproperty' );
                $dispatcher = JDispatcher::getInstance();
                $captcha_validate = $dispatcher->trigger( 'onValidateIpCaptcha', array( 'contact' ));
                $captcha_validate = $captcha_validate[0];
            }

            // Check if captcha was validated if enabled - else continue with form processing
            if($captcha_validate){
                if($model->sendContact($post)){
                    $msg = JText::_( 'COM_IPROPERTY_CONTACT_CONFIRM' );
                    $type = 'message';
                }else{
                    $msg = JText::_( 'COM_IPROPERTY_CONTACT_FAIL' );
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
