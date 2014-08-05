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

class IpropertyControllerIPuser extends JController
{
	protected $text_prefix = 'COM_IPROPERTY';

	public function unsubscribeUpdate()
    {
        $post   = JRequest::get('post');
        $id     = $post['editid'];
        JRequest::checkToken() or die( 'Invalid Token!' );
        #TODO: replace with base64encode
        $link = @$_SERVER['HTTP_REFERER'];
        if (empty($link) || !JURI::isInternal($link)) {
            $link = JURI::base();
        }

        $model = $this->getModel('ipuser');
        //delete property from favorites
        if($model->updateEmailSubscribe($id)){
            $msg = JText::_( 'COM_IPROPERTY_SUBSCRIPTION_UPDATED' );
            $type = 'message';
        }else{
            $msg = JText::_( 'COM_IPROPERTY_SUBSCRIPTION_NOT_UPDATED' ).$model->getError();
            $type = 'notice';
        }

        $this->setRedirect($link, $msg, $type);
    }   
    
    public function saveProperty()
    {
        $post           = JRequest::get('post');
        $id             = $post['id'];
        $notes          = $post['notes'];
        $email_update   = $post['email_update'] ? 1 : 0;
        JRequest::checkToken() or die( 'Invalid Token!' );
        #TODO: replace with base64encode
        $link = @$_SERVER['HTTP_REFERER'];
        if (empty($link) || !JURI::isInternal($link)) {
            $link = JURI::base();
        }

        $model  = $this->getModel('ipuser');
        //save property from favorites
        if($model->saveProperty($id, $notes, $email_update)){
            $msg = JText::_( 'COM_IPROPERTY_PROPERTY_HAS_BEEN_SAVED' );
            $type = 'message';
        }else{
            $msg = JText::_( 'COM_IPROPERTY_PROPERTY_HAS_NOT_BEEN_SAVED' );
            $type = 'notice';
        }
        $this->setRedirect($link, $msg, $type);
    }    
    
    public function saveSearch()
    {
        $post           = JRequest::get('post');
        $string         = $post['ipsearchstring'];
        $notes          = $post['notes'];
        $email_update   = $post['email_update'] ? 1 : 0;
        JRequest::checkToken() or die( 'Invalid Token!' );
        #TODO: replace with base64encode
        $link = @$_SERVER['HTTP_REFERER'];
        if (empty($link) || !JURI::isInternal($link)) {
            $link = JURI::base();
        }

        $model  = $this->getModel('ipuser');
        
        if($model->saveSearch($string, $notes, $email_update)){
            $msg = JText::_( 'COM_IPROPERTY_SEARCH_HAS_BEEN_SAVED' );
            $type = 'message';
        }else{
            $msg = JText::_( 'COM_IPROPERTY_SEARCH_HAS_NOT_BEEN_SAVED' );
            $type = 'notice';
        }
        $this->setRedirect($link, $msg, $type);
    }
    
    /*// remote actions - from email link //*/
    // Unsubscribe email link to unsubscribe from email updates    
    public function unsubscribeSaved()
    {
        $vars   = JRequest::get( 'GET' );
        $id     = $vars['id']; // id of object to change
        $all    = isset ($vars['all']) ? 1 : 0; // boolean, 1 for unsubscribe from all
        $token  = $vars['token']; // type of object to change
        
        if (!$id || !$token) {
            $this->setRedirect(JRoute::_(ipropertyHelperRoute::getHomeRoute(), false), JText::_('COM_IPROPERTY_INVALID_ID_OR_TOKEN_PASSED'));
            return false;
        }
        
        $model  = $this->getModel('ipuser');
        if($model->emailUnsubscribe($id, $token, $all)){
            $this->setRedirect(JRoute::_(ipropertyHelperRoute::getHomeRoute(), false), JText::_('COM_IPROPERTY_UNSUBSCRIBE_SUCCESS'));
        }else{
            $this->setRedirect(JRoute::_(ipropertyHelperRoute::getHomeRoute(), false), JText::_('COM_IPROPERTY_UNSUBSCRIBE_FAILED').': '.$model->getError(), 'notice'); 
        }            
    }
    
    // Approval link for automatic approval from email
    public function approveListing()
    {
        $vars   = JRequest::get( 'GET' );
        $id     = $vars['id']; // id of object to change
        $token  = $vars['token']; // type of object to change
        
        if (!$id || !$token) {
            $this->setRedirect(JRoute::_(ipropertyHelperRoute::getHomeRoute(), false), JText::_('COM_IPROPERTY_INVALID_ID_OR_TOKEN_PASSED'));
            return false;
        }
        
        $model  = $this->getModel('ipuser');
        if($model->approveListing($id, $token)){
            $this->setRedirect(JRoute::_(ipropertyHelperRoute::getPropertyRoute($id), false), JText::_('COM_IPROPERTY_APPROVAL_SUCCESSFUL'));
        }else{
            $this->setRedirect(JRoute::_(ipropertyHelperRoute::getHomeRoute(), false), JText::_('COM_IPROPERTY_APPROVAL_FAILED').': '.$model->getError(), 'notice'); 
        }
    }
}
