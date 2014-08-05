<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

$companylink        = JRoute::_(ipropertyHelperRoute::getCompanyPropertyRoute($this->company->id.':'.$this->company->alias));
$companyagentslink  = JRoute::_(ipropertyHelperRoute::getCompanyAgentRoute($this->company->id.':'.$this->company->alias));
$companycontactlink = JRoute::_(ipropertyHelperRoute::getContactRoute('company', $this->company->id.':'.$this->company->alias));

// check URL for company website and add http if required
if ($this->company->website && substr($this->company->website, 0, 4) != 'http') $this->company->website = 'http://'.$this->company->website;

?>
<tr class="iprow<?php echo $this->k; ?>">
    <td valign="top" colspan="2" class="ip_company_detailsheader">
        <?php
            if($this->ipauth->canEditCompany($this->company->id)) echo '<div class="iplistaction">'.JHtml::_('icon.edit', $this->company, 'company', false, true).'</div>';
            // SHOW PHOTO IF ANY
            if($this->settings->co_show_image){
                if($this->company->icon):
                    // check for remote image
                    $icon = ipropertyHTML::getIconpath($this->company->icon, 'company');
                    echo '<div class="ip_company_photo">
                            <a href="' . $companylink . '"><img src="'.$icon . '" alt="' . $this->company->name . '" width="' . $this->company_photo_width . '" border="0" /></a>
                          </div>';
                else:
                    echo '<div class="ip_company_photo">
                            <a href="' . $companylink . '"><img src="'.$this->company_folder.'nopic.png" alt="'.JText::_( 'COM_IPROPERTY_NO_IMAGE' ).'" width="' . $this->company_photo_width . '" border="0" /></a>
                          </div>';
                endif;
            }

            // SHOW AGENT OVERVIEW DETAILS
            echo '<div class="ip_company_details">';
                echo '<a href="' . $companylink . '"><b>' . ipropertyHTML::getCompanyName($this->company->id) . '</b></a><br />';
                if($this->company->phone && $this->settings->co_show_phone) echo '<div class="ip_phone"><b>'.JText::_( 'COM_IPROPERTY_PHONE' ).':</b> <span class="ip_phone_container">' . $this->company->phone . '</span></div><br />';
                if($this->company->fax && $this->settings->co_show_fax) echo '<div class="ip_fax"><b>'.JText::_( 'COM_IPROPERTY_FAX' ).':</b> ' . $this->company->fax . '</div><br />';
                if($this->company->email && $this->settings->co_show_email) echo '<div class="ip_email"><b>'.JText::_( 'COM_IPROPERTY_EMAIL' ).':</b> '.JHTML::_('email.cloak', $this->company->email).'</div><br />';
                if($this->company->website && $this->settings->co_show_website) echo '<div class="ip_website"><b>'.JText::_( 'COM_IPROPERTY_WEBSITE' ).':</b> <a href="' . $this->company->website . '" target="_blank"><span class="ip_website_container">' . JText::_('COM_IPROPERTY_VISIT') . '</span></a></div><br />';
            echo '</div>';

            // SHOW ADDRESS IF AVAILABLE AND SETTINGS APPROVE
            echo '<div class="ip_company_address">';
                if($this->company->street && $this->settings->co_show_address) echo $this->company->street . '<br />';
                if($this->company->city && $this->settings->co_show_address) echo $this->company->city;
                if($this->company->locstate && $this->settings->co_show_address) echo ', '.ipropertyHTML::getStateName($this->company->locstate) . ' ';
                if($this->company->province && $this->settings->co_show_address) echo ', '.$this->company->province . ' ';
                if($this->company->postcode && $this->settings->co_show_address) echo $this->company->postcode . '<br />';
                if($this->company->country && $this->settings->co_show_address) echo ipropertyHTML::getCountryName($this->company->country) . '<br />';
                if($this->company->clicense && $this->settings->co_show_license) echo '<b>'.JText::_( 'COM_IPROPERTY_LICENSE' ).':</b> '.$this->company->clicense . '<br />';
                if($this->company->featured == 1) echo '<img src="'.$this->ipbaseurl.'/components/com_iproperty/assets/images/featured_icon.gif" alt="'.JText::_( 'COM_IPROPERTY_FEATURED' ).'" />';
                if(JRequest::getVar('view') != 'companyproperties')
                    echo '<div class="ip_proplink"><a href="' . $companylink . '">'.JText::_( 'COM_IPROPERTY_VIEW_PROPERTIES' ).'</a></div>';
                if(JRequest::getVar('view') != 'companyagents')
                    echo '<div class="ip_agentlink"><a href="' . $companyagentslink . '">'.JText::_( 'COM_IPROPERTY_VIEW_AGENTS' ).'</a></div>';
                if($this->company->email && $this->settings->co_show_contact && JRequest::getCmd('view') != 'contact') echo '<div class="ip_contact"><a href="' . $companycontactlink . '">'.JText::_( 'COM_IPROPERTY_CONTACT_COMPANY' ).'</a></div>';
            echo '</div>';
        ?>
    </td>
</tr>
