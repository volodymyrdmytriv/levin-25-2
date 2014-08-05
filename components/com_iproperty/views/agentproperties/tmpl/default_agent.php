<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

$agentlink          = JRoute::_(ipropertyHelperRoute::getAgentPropertyRoute($this->agent->id.':'.$this->agent->alias));
$companylink        = JRoute::_(ipropertyHelperRoute::getCompanyPropertyRoute($this->agent->companyid.':'.$this->agent->co_alias));
$agentcontactlink   = JRoute::_(ipropertyHelperRoute::getContactRoute('agent', $this->agent->id.':'.$this->agent->alias));

// check URL for agent website and add http if required
if ($this->agent->website && substr($this->agent->website, 0, 4) != 'http') $this->agent->website = 'http://'.$this->agent->website;

?>
<tr class="iprow<?php echo $this->k; ?>">
    <td valign="top" colspan="2" class="ip_agent_detailsheader">
        <?php
            if($this->ipauth->canEditAgent($this->agent->id)) echo '<div class="iplistaction">'.JHtml::_('icon.edit', $this->agent, 'agent', false, true).'</div>';
            if ($this->settings->agent_show_image){
                // SHOW PHOTO IF ANY
                if($this->agent->icon && ($this->agent->icon != 'nopic.png')):
                    $icon = ipropertyHTML::getIconpath($this->agent->icon, 'agent');
                    echo '<div class="ip_agent_photo">
                            <a href="' . $agentlink . '"><img src="'.$icon . '" alt="' . $this->agent->name . '" width="' . $this->agent_photo_width . '" border="0" /></a>
                          </div>';
                else:
                    echo '<div class="ip_agent_photo">
                            <a href="' . $agentlink . '"><img src="'.$this->agents_folder.'nopic.png" alt="'.JText::_( 'COM_IPROPERTY_NO_IMAGE' ).'" width="' . $this->agent_photo_width . '" border="0" /></a>
                          </div>';
                endif;
            }

            // SHOW AGENT OVERVIEW DETAILS
            echo '<div class="ip_agent_details">';
                echo '<a href="' . $agentlink . '"><b>' . ipropertyHTML::getAgentName($this->agent->id) . '</b></a><br />';
                echo '<a href="' . $companylink . '">' . ipropertyHTML::getCompanyName($this->agent->companyid) . '</a><br />';
                if($this->agent->phone && $this->settings->agent_show_phone) echo '<div class="ip_phone"><b>'.JText::_( 'COM_IPROPERTY_PHONE' ).':</b> <span class="ip_phone_container">' . $this->agent->phone . '</span></div><br />';
                if($this->agent->mobile && $this->settings->agent_show_mobile) echo '<div class="ip_cell"><b>'.JText::_( 'COM_IPROPERTY_MOBILE' ).':</b> <span class="ip_phone_container">' . $this->agent->mobile . '</span></div><br />';
                if($this->agent->fax && $this->settings->agent_show_fax) echo '<div class="ip_fax"><b>'.JText::_( 'COM_IPROPERTY_FAX' ).':</b> ' . $this->agent->fax . '</div><br />';
                if($this->agent->email && $this->settings->agent_show_email) echo '<div class="ip_email"><b>'.JText::_( 'COM_IPROPERTY_EMAIL' ).':</b> '.JHTML::_('email.cloak', $this->agent->email).'</div><br />';
                if($this->agent->msn && $this->settings->agent_show_social) echo '<div class="ip_msn"><b>'.JText::_( 'COM_IPROPERTY_MSN' ).':</b> ' . $this->agent->msn . '</div><br />';
                if($this->agent->skype && $this->settings->agent_show_social) echo '<div class="ip_skype"><b>'.JText::_( 'COM_IPROPERTY_SKYPE' ).':</b> ' . $this->agent->skype . '</div><br />';
                if($this->agent->gtalk && $this->settings->agent_show_social) echo '<div class="ip_gtalk"><b>'.JText::_( 'COM_IPROPERTY_GTALK' ).':</b> ' . $this->agent->gtalk . '</div><br />';
                if($this->agent->linkedin && $this->settings->agent_show_social) echo '<div class="ip_linkedin"><b>'.JText::_( 'COM_IPROPERTY_LINKEDIN' ).':</b> ' . $this->agent->linkedin . '</div><br />';
                if($this->agent->twitter && $this->settings->agent_show_social) echo '<div class="ip_twitter"><b>'.JText::_( 'COM_IPROPERTY_TWITTER' ).':</b> ' . $this->agent->twitter . '</div><br />';
                if($this->agent->facebook && $this->settings->agent_show_social) echo '<div class="ip_facebook"><b>'.JText::_( 'COM_IPROPERTY_FACEBOOK' ).':</b> ' . $this->agent->facebook . '</div><br />';
                if($this->agent->social1 && $this->settings->agent_show_social) echo '<div class="ip_social1"><b>'.JText::_( 'COM_IPROPERTY_SOCIAL1' ).':</b> ' . $this->agent->social1 . '</div><br />';
                if($this->agent->website && $this->settings->agent_show_website) echo '<div class="ip_website"><b>'.JText::_( 'COM_IPROPERTY_WEBSITE' ).':</b> <a href="' . $this->agent->website . '" target="_blank"><span class="ip_website_container">' . JText::_('COM_IPROPERTY_VISIT') . '</span></a></div><br />';
            echo '</div>';

            // SHOW ADDRESS IF AVAILABLE AND SETTINGS APPROVE
            echo '<div class="ip_agent_address">';
                if($this->agent->street && $this->settings->agent_show_address) echo $this->agent->street . '<br />';
                if($this->agent->city && $this->settings->agent_show_address) echo $this->agent->city;
                if($this->agent->locstate && $this->settings->agent_show_address) echo ', '.ipropertyHTML::getStateName($this->agent->locstate) . ' ';
                if($this->agent->province && $this->settings->agent_show_address) echo ', '.$this->agent->province . ' ';
                if($this->agent->postcode && $this->settings->agent_show_address) echo $this->agent->postcode . '<br />';
                if($this->agent->alicense && $this->settings->agent_show_license) echo '<b>'.JText::_( 'COM_IPROPERTY_LICENSE' ).':</b> '.$this->agent->alicense . '<br />';
                if($this->agent->featured == 1) echo '<img src="'.$this->ipbaseurl.'/components/com_iproperty/assets/images/featured_icon.gif" alt="'.JText::_( 'COM_IPROPERTY_FEATURED' ).'" />';
                if($this->agent->email && $this->settings->agent_show_contact && JRequest::getVar('view') != 'contact') echo '<div class="ip_contact"><a href="' . $agentcontactlink . '">'.JText::_( 'COM_IPROPERTY_CONTACT_AGENT' ).'</a></div>';
                if(JRequest::getVar('view') != 'agentproperties') echo '<div class="ip_proplink"><a href="' . $agentlink . '">'.JText::_( 'COM_IPROPERTY_VIEW_PROPERTIES' ).'</a></div>';
            echo '</div>';
            $this->dispatcher->trigger( 'onAfterRenderAgent', array( &$this->agent, &$this->settings ) );
            if($this->agent->bio && JRequest::getVar('view') != 'agents' && JRequest::getVar('view') != 'companyagents'):
                echo '<div class="ipclear"></div>';
                echo '<div class="ip_agentbio">'.JHTML::_('content.prepare', $this->agent->bio).'</div>';
            endif;
        ?>
    </td>
</tr>
