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

class plgIpropertyFavoriteTools extends JPlugin
{
	function plgIpropertyFavoriteTools(&$subject, $config)  
    {
		parent::__construct($subject, $config);
        $this->loadLanguage();
	}

	function onAfterRenderFavorites($user, $settings)
	{
        $app    = JFactory::getApplication();
        $doc    = JFactory::getDocument();

		if ($app->getName() != 'site') return true;
        if (!$user || !$user->get('email') || !$user->get('id')) return true; // return nothing if no user or email to reply to

        // get array of posted properties to inquire about
        $posted_saved = JRequest::getVar( 'sp', array(), 'post', 'array' );

        // if form submitted and valid token and properties to inquire about, send inquiry
        if(JRequest::getInt('ip_sendinquiry') && JRequest::checkToken() && count($posted_saved)){
            $this->sendInquiry($user, $settings, $posted_saved);
            return;
        }

        $inquiry_script = 'inquiries = document.getElementsByName("sp[]");
                            function checkInquiryLimit(j){
                                var total = 0;
                                for(var i = 0; i < inquiries.length; i++){
                                    if(inquiries[i].checked){
                                        total = total +1;
                                    }
                                    if(total > '.$this->params->get('max_requests', 5).'){
                                        alert("'.addslashes(sprintf(JText::_('PLG_IP_FT_LIMIT_REACHED'), $this->params->get('max_requests', 5))).'");
                                        inquiries[j].checked = false ;
                                        return false;
                                    }
                                }
                            }';
        $doc->addScriptDeclaration( $inquiry_script );

        $db = JFactory::getDbo();        
        $groups     = $user->getAuthorisedViewLevels();
        
        // Filter by start and end dates.
        $nullDate   = $db->Quote($db->getNullDate());
        $date       = JFactory::getDate();
        $nowDate    = $db->Quote($date->toSql());
        
        $query = $db->getQuery(true);
        $query->select('DISTINCT(prop_id)')
                ->from('#__iproperty_saved as s')
                ->leftJoin('#__iproperty as p on p.id = s.prop_id')
                ->where('s.user_id = '.(int)$user->get('id'))
                ->where('(p.publish_up = '.$nullDate.' OR p.publish_up <= '.$nowDate.')')
                ->where('(p.publish_down = '.$nullDate.' OR p.publish_down >= '.$nowDate.')')
                ->where('s.active = 1')
                ->where('p.state = 1')
                ->where('p.approved = 1');
        if(is_array($groups) && !empty($groups)){
            $query->where('p.access IN ('.implode(",", $groups).')');
        }
        $query->order('s.timestamp DESC');
        
        $db->setQuery($query);
        $saved_props = $db->loadResultArray();
        
        // Until we add new tabs to the the favorite tools, if there are no saved props, return now
        if(count($saved_props) < 1) return true;

        echo JHtml::_('tabs.start', 'favoriteTools', array('useCookie' => false));
        if($this->params->get('fi_enabled', 1) && count($saved_props)){ // check if favorite inquiries tab is enabled
            echo JHtml::_('tabs.panel', JText::_($this->params->get('fi_title', 'PLG_IP_FT_INQUIRY_TITLE')), 'favinquiry');

            $uri            = JFactory::getURI();
            $form_action    = str_replace('&', '&amp;', $uri->toString());
            $from_name      = ($this->params->get('use_realname', 1)) ? $user->get('name') : $user->get('username');
            $from_email     = $user->get('email');
            echo '
                <div class="ip_spacer"></div>
                <table class="ip_details_table_container" width="100%">
                    <tr>
                        <td valign="top">
                            <p>'.sprintf(JText::_('PLG_IP_FT_INQUIRY_OVERVIEW'), $this->params->get('max_requests', 5)).'</p>
                            <form name="ipInquiry" action="'.$form_action.'" method="post" id="ipInquiry">
                                <fieldset class="ip_plg_favoritetools">
                                    <legend>'.JText::_($this->params->get('fi_title', 'PLG_IP_FT_INQUIRY_TITLE')).'</legend>
                                    <table width="100%" cellpading="4" cellspacing="0" class="ip_plg_favoritetools_table">
                                        <tr>
                                            <td width="25%" valign="top" align="right" class="key"><label>'.JText::_('PLG_IP_FT_FROM').':</label></td>
                                            <td width="75%" valign="top" class="value">'.$from_name.'</td>
                                        </tr>
                                        <tr>
                                            <td class="key"><label>'.JText::_('PLG_IP_FT_REPLY_TO').':</label></td>
                                            <td class="value">'.$from_email.'</td>
                                        </tr>
                                        <tr>
                                            <td class="key"><label>'.JText::_('PLG_IP_FT_COMMENTS').':</label></td>
                                            <td class="value"><textarea name="comments" cols="40" rows="5">'.JText::_('PLG_IP_FT_DEFAULT_COMMENTS').'</textarea></td>
                                        </tr>
                                        <tr>
                                            <td class="key"><label>'.JText::_('PLG_IP_FT_PROPERTIES').':</label></td>
                                            <td class="value">';
                                                $i = 0;
                                                foreach($saved_props as $sp){
                                                    echo '<div><input type="checkbox" name="sp[]" value="'.$sp.'" onclick="checkInquiryLimit('.$i.')" /> '.ipropertyHTML::getPropertyTitle($sp).'</div>';
                                                    $i++;
                                                }
                                        echo '
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="key">&nbsp;</td>
                                            <td class="value"><input type="submit" value="'.JText::_('PLG_IP_FT_SUBMIT').'" /></td>
                                        </tr>
                                    </table>
                                </fieldset>
                                <input type="hidden" name="ip_sendinquiry" value="1" />
                                '.JHTML::_( 'form.token' ).'
                            </form>
                        </td>
                    </tr>
                </table>';
        } // end favorite inquiry if

        echo JHtml::_('tabs.end');
		return true;
	}

    function sendInquiry($user, $settings, $props = array())
    {
        $app = JFactory::getApplication();
        if ($app->getName() != 'site') return true;
        if (!$user || !$user->get('email') || !$user->get('id') || empty($props)) return true; // return nothing if no user or email to reply to

        jimport( 'joomla.mail.helper' );
        $post = JRequest::get('post');
        JRequest::checkToken() or die( 'Invalid Token!' );
        JPlugin::loadLanguage('plg_ip_favoritetools', JPATH_ADMINISTRATOR);

        $link = @$_SERVER['HTTP_REFERER'];
        if (empty($link) || !JURI::isInternal($link)) $link = JURI::base();

        if (!JMailHelper::isEmailAddress( $user->get('email'))){
            $msg = JText::_('PLG_IP_FT_NO_EMAIL');
            $type = 'notice';
        } else {
            $db             = JFactory::getDBO();
            $dispatcher     = JDispatcher::getInstance();
            $error          = array();
            $success        = array();

            //set main email configuration
            $admin_from     = $app->getCfg('fromname');
            $admin_email    = $app->getCfg('mailfrom');
            $from_name      = ($this->params->get('use_realname', 1)) ? $user->get('name') : $user->get('username');
            $from_email     = $user->get('email');
            $from_comments  = ($post['comments']) ? $post['comments'] : JText::_('PLG_IP_FT_DEFAULT_COMMENTS');
            $subject        = sprintf(JText::_('PLG_IP_FT_EMAIL_SUBJECT'), $app->getCfg('fromname'), $from_name);
            $date            = JHTML::_('date','now',JText::_('DATE_FORMAT_LC4'));
            $fulldate        = JHTML::_('date','now',JText::_('DATE_FORMAT_LC2'));        

            if($settings->form_recipient == 0){ // send single email to admin with all listings
                // set email body with all listings and send
                $body = '<p>'.sprintf(JText::_('PLG_IP_FT_EMAIL_BODY'), $from_name.' ('.$from_email.')', $app->getCfg('sitename'), $date).'</p>';
                $body .= '<p>'.JText::_('PLG_IP_FT_FROM').': '.$from_name.'<br />'. JText::_('PLG_IP_FT_REPLY_TO').': '.$from_email.'</p>';
                $body .= '<p>'.JText::_('PLG_IP_FT_COMMENTS').':<br />'. $from_comments.'</p>';
                $body .= '<p>'.JText::_('PLG_IP_FT_REQUESTED_PROPERTIES').':<br />';
                    foreach($props as $p){
                        $available_cats = ipropertyHTML::getAvailableCats($p);
                        $cat_id         = $available_cats[0];
                        $property       = ipropertyHTML::getPropertyTitle($p);
                        $property_link  = JURI::base().ipropertyHelperRoute::getPropertyRoute($p, $cat_id, true);

                        $body .= '<a href="'.$property_link.'" target="_blank">'.$property.'</a><br />';
                    }
                $body .= '</p><p>'.sprintf(JText::_('PLG_IP_FT_IPROPERTY_GEN'), $fulldate).'</p>';
                
                $sento = '';
                $mail = JFactory::getMailer();
                $mail->addRecipient( $admin_email );
                $mail->addReplyTo(array($from_email, $from_name));
                $mail->setSender( array( $admin_email, $admin_from ));
                $mail->setSubject( $subject );
                $mail->setBody( $body );
                $mail->IsHTML( true );
                $sento = $mail->Send();

                if($sento){
                    $dispatcher->trigger( 'onAfterPropertyRequest', array( $props, $user->id, $post, $settings ) );
                    $msg = JText::_('PLG_IP_FT_REQUEST_SENT');
                }else{
                    $msg = JText::_('PLG_IP_FT_REQUEST_NOT_SENT');
                    $type = 'notice';
                }
            }else{
                $bcc = $settings->form_copyadmin;
                foreach($props as $p){
                    // check who admin wants to send the requests to
                    $body = '';
                    $recipients = array();
                    switch($settings->form_recipient){
                        case '1': // send to agent(s)
                            $agents        = ipropertyHTML::getAvailableAgents($p);
                            foreach($agents as $a){
                                $recipients[] = $a->email;
                            }
                        break;
                        case '2': // send to company
                            $db->setQuery('SELECT listing_office FROM #__iproperty WHERE id = '.(int)$p.' LIMIT 1');
                            $co_id = $db->loadResult();
                            $company_email = ipropertyHTML::getCompanyEmail($co_id);
                            $recipients[] = $company_email;
                        break;
                        case '3': // send to agent(s) and company
                            $db->setQuery('SELECT listing_office FROM #__iproperty WHERE id = '.(int)$p.' LIMIT 1');
                            $co_id = $db->loadResult();
                            $agents        = ipropertyHTML::getAvailableAgents($propid);
                            $company_email = ipropertyHTML::getCompanyEmail($co_id);
                            foreach($agents as $a){
                                $recipients[] = $a->email;
                            }
                            $recipients[] = $company_email;
                        break;
                    }
                    
                    $available_cats = ipropertyHTML::getAvailableCats($p);
                    $cat_id         = $available_cats[0];
                    $property       = ipropertyHTML::getPropertyTitle($p);
                    $property_link  = JURI::base().ipropertyHelperRoute::getPropertyRoute($p, $cat_id, true);

                    $body = '<p>'.sprintf(JText::_('PLG_IP_FT_EMAIL_BODY'), $from_name.' ('.$from_email.')', $app->getCfg('sitename'), $date).'</p>';
                    $body .= '<p>'.JText::_('PLG_IP_FT_FROM').': '.$from_name.'<br />'. JText::_('PLG_IP_FT_REPLY_TO').': '.$from_email.'</p>';
                    $body .= '<p>'.JText::_('PLG_IP_FT_COMMENTS').':<br />'. $from_comments.'</p>';
                    $body .= '<p>'.JText::_('PLG_IP_FT_REQUESTED_PROPERTIES').':<br />';
                    $body .= '<a href="'.$property_link.'" target="_blank">'.$property.'</a><br />';
                    $body .= '</p><p>'.sprintf(JText::_('PLG_IP_FT_IPROPERTY_GEN'), $fulldate).'</p>';

                    $sento = '';
                    $mail = JFactory::getMailer();
                    $mail->addRecipient( $recipients );
                    $mail->addReplyTo(array($from_email, $from_name));
                    $mail->setSender( array( $admin_email, $admin_from ));
                    $mail->setSubject( $subject );
                    $mail->setBody( $body );
                    $mail->isHTML( true );
                    $sento = $mail->Send();

                    if( $sento ){ // email sent - trigger after request plugin and add proeperty to success array
                        $dispatcher->trigger( 'onAfterPropertyRequest', array( $p, $user->id, $post, $settings ) );
                        $success[] = '<a href="'.$property_link.'" target="_blank">'.$property.'</a>';
                    }else{
                        $error[] = $property;
                    }
                }

                if(!empty($success)){
                    //send copy to admin email with all listings in one email
                    if($bcc){
                        $body = '<p>'.sprintf(JText::_('PLG_IP_FT_EMAIL_BODY'), $from_name.' ('.$from_email.')', $app->getCfg('sitename'), $date).'</p>';
                        $body .= '<p>'.JText::_('PLG_IP_FT_FROM').': '.$from_name.'<br />'. JText::_('PLG_IP_FT_REPLY_TO').': '.$from_email.'</p>';
                        $body .= '<p>'.JText::_('PLG_IP_FT_COMMENTS').':<br />'. $from_comments.'</p>';
                        $body .= '<p>'.JText::_('PLG_IP_FT_REQUESTED_PROPERTIES').':<br />';
                        foreach($success as $s){
                            $body .= $s.'<br />';
                        }
                        $body .= '</p><p>'.sprintf(JText::_('PLG_IP_FT_IPROPERTY_GEN'), $fulldate).'</p>';

                        $copySubject 	= JText::_('PLG_IP_FT_COPY').": ".$subject;
                        $copyBody 		= '<p>'.sprintf(JText::_('PLG_IP_FT_COPYBODY'), implode(',',$recipients)).'</p>'.$body;

                        $mail = JFactory::getMailer();
                        $mail->addRecipient( $admin_email );
                        $mail->setSender( array( $admin_email, $admin_from ) );
                        $mail->setSubject( $copySubject );
                        $mail->setBody( $copyBody );
                        $mail->IsHTML( true );
                        $mail->Send();
                    }
                    $msg = sprintf(JText::_('PLG_IP_FT_REQUEST_SENT_ARRAY'), implode(', ', $success));
                }
                if(!empty($error)) JError::raisNotice(100, sprintf(JText::_('PLG_IP_FT_REQUEST_ERROR_ARRAY'), implode(', ', $error)));
            }
        }

        $cache = JFactory::getCache('iproperty');
		$cache->clean();

        $app->redirect($link, $msg, $type);
        return;
    }
}
