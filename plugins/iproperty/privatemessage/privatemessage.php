<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2012 The Thinkery
 * @license GNU/GPL see LICENSE.php
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin');
require_once(JPATH_SITE.'/components/com_iproperty/helpers/route.php');
require_once(JPATH_SITE.'/components/com_iproperty/helpers/html.helper.php');

class plgIpropertyPrivatemessage extends JPlugin
{
    function plgIpropertyPrivatemessage(&$subject, $config)  
    {
        parent::__construct($subject, $config);
        $this->loadLanguage();
    }

    function onAfterPropertyRequest($prop_id = array(), $user_id, $post, $settings)
    {
        return $this->sendPrivateMessage($prop_id, $user_id, $post, $settings, 'request');
    }

    function onAfterSendFriend($prop_id = array(), $user_id, $post, $settings)
    {
        return $this->sendPrivateMessage($prop_id, $user_id, $post, $settings, 'friend');
    }

    function sendPrivateMessage($prop_id, $user_id, $post, $settings, $type)
    {
        $db     = JFactory::getDBO();
        $app    = JFactory::getApplication();
        if($app->getName() != 'site') return true;

        $proplink   = JRoute::_(ipropertyHelperRoute::getPropertyRoute($prop_id), false);

        $message  = JText::_('PLG_IP_PRIVATEMESSAGE_NAME').$post['sender_name']."\n";
        $message .= JText::_('PLG_IP_PRIVATEMESSAGE_EMAIL').$post['sender_email']."\n";

        switch ($type){
            case 'friend':
                $message    .= JText::_('PLG_IP_PRIVATEMESSAGE_REQUEST').$post['comments']."\n";
                $subject     = JText::_('PLG_IP_PRIVATEMESSAGE_FRIEND_SUBJECT');
                $message    .= JText::_('PLG_IP_PRIVATEMESSAGE_DPHONE').$post['sender_dphone']."\n";
                $message    .= JText::_('PLG_IP_PRIVATEMESSAGE_FRIEND_EMAIL').$post['recipient_email']."\n";
                break;
            case 'request':
                $message    .= JText::_('PLG_IP_PRIVATEMESSAGE_REQUEST').$post['special_requests']."\n";
                $subject     = JText::_('PLG_IP_PRIVATEMESSAGE_REQUEST_SUBJECT');
                $message    .= JText::_('PLG_IP_PRIVATEMESSAGE_DPHONE').$post['sender_dphone']."\n";
                $message    .= JText::_('PLG_IP_PRIVATEMESSAGE_EPHONE').$post['sender_ephone']."\n";
                $message    .= JText::_('PLG_IP_PRIVATEMESSAGE_PREF').$post['sender_preference']."\n";
                $message    .= JText::_('PLG_IP_PRIVATEMESSAGE_CTIME').$post['sender_ctime']."\n";
                break;
            default:
                $message   .= JText::_('PLG_IP_PRIVATEMESSAGE_REQUEST').$post['comments']."\n";
                $subject    = JText::_('PLG_IP_PRIVATEMESSAGE_FRIEND_SUBJECT');
                break;
        }

        $message .= JText::_('PLG_IP_PRIVATEMESSAGE_LINK').": ".$proplink."\n";

        // get the agents attached to the property
        $db = JFactory::getDbo();
        $query = "SELECT a.* FROM #__iproperty_agents AS a "
                ."LEFT JOIN #__iproperty_agentmid AS am ON a.id = am.agent_id "
                ."WHERE a.state AND a.user_id AND am.prop_id = ".(int) $prop_id;

        $db->setQuery($query);
        $result = $db->loadObjectList();

        if ($result) {
            // we've got agents for this property
            // loop through results
            foreach($result as $agent){
                $user = $agent->user_id;

                $data                   = new stdClass();
                $data->subject          = $subject;
                $data->message          = $message;
                $data->user_id_from     = $this->params->get('from', 64);
                $data->user_id_to       = $user;
                $data->date_time        = JFactory::getDate()->toMySQL();
                $data->state            = 0; // 0 for unread
                $db->insertObject('#__messages', $data);
            }
        }
        return false;
    }
}
