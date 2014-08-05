<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<script type="text/javascript">
    //<![CDATA[    
    window.addEvent((window.webkit) ? 'load' : 'domready', function(){
        displayStypes = function() {
            var checkurl = '<?php echo JURI::base('true'); ?>/index.php?option=com_iproperty&task=ajax.displayStypes';      

            req = new Request({
                method: 'get',
                url: checkurl,
                data: { '<?php echo JUtility::getToken(); ?>':'1',
                        'format': 'raw'},
                onRequest: function() {
                    $( 'ajax-stypes-container' ).empty().addClass( 'loading_div' );
                },
                onSuccess: function(response) {
                    if(response){
                        $('ajax-stypes-container').removeClass('loading_div').set('html', response);                   
                    }else{
                        alert('There was a problem with the save request');
                    }                    
                }
            }).send();
        }
        displayStypes();
    });
    
    function saveStypes(){
        stype_rows = $$('tr.stype_row');
        var payload = new Array();

        for(var i = 0; i < stype_rows.length; i++) {
            stypes = $$('tr.stype_row input.s'+i);
            stype = new Array();
            var n = 0;
            $each(stypes, function(e){
                if(e.type == 'checkbox'){
                    if(e.checked){
                        stype[n] = 1;
                    }else{
                        stype[n] = 0;
                    }
                }else{
                    stype[n] = e.value;                    
                }
                n++;
            });
            payload[i] = stype;
        }

        payload = JSON.encode(payload);
        
        $('ipmessage').set('tween', {duration: 4500});
        var checkurl = '<?php echo JURI::base('true'); ?>/index.php?option=com_iproperty&task=ajax.saveStypes';
        
        req = new Request({
            method: 'post',
            url: checkurl,
            data: { 'stypes': payload,
                    '<?php echo JUtility::getToken(); ?>':'1',
                    'format': 'raw'},
            onRequest: function() {
                $('ipmessage').set('html', '');
            },
            onSuccess: function(response) {
                if(response){
                    $('ipmessage').set('html', response);                    
                }else{
                    alert('There was a problem with the save request');
                }
                displayStypes();
            }
        }).send();
    }
    
    deleteStype = function(stypeid){
        $('ipmessage').set('tween', {duration: 4500});
        var checkurl = '<?php echo JURI::base('true'); ?>/index.php?option=com_iproperty&task=ajax.deleteStype';
        
        req = new Request({
            method: 'post',
            url: checkurl,
            data: { 'id': stypeid,
                    '<?php echo JUtility::getToken(); ?>':'1',
                    'format': 'raw'},
            onRequest: function() {
                $('ipmessage').set('html', '');
            },
            onSuccess: function(response) {
                if(response){
                    $('ipmessage').set('html', response);                    
                }else{
                    alert('There was a problem with the delete request');
                }
                displayStypes();
            }
        }).send();
    }
    //]]>
</script>

<table cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>
        <td valign="top" width="20%" class="ip_cpanel_toolbar">
            <?php ipropertyAdmin::buildAdminToolbar(); ?>
        </td>
        <td valign="top" width="80%" class="ip_cpanel_display">            
            <form action="<?php echo JRoute::_('index.php?option=com_iproperty&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm">
                <?php
                    echo JHtml::_('tabs.start', 'ipsettings', array('useCookie' => false));
                    echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_GENERAL_SETTINGS' ), 'general_panel');
                ?>
                <div class="ip_spacer"></div>
                <table width="100%">
                    <tr>
                        <td>                            
                            <div class="width-60 fltlft">
                                <fieldset class="adminform">
                                    <legend><?php echo JText::_('COM_IPROPERTY_OFFLINE_SETTINGS'); ?></legend>
                                    <div class="fltlft">                
                                        <ul class="adminformlist">
                                            <li><?php echo $this->form->getLabel('offline'); ?>
                                            <?php echo $this->form->getInput('offline'); ?></li>
                                            <li><?php echo $this->form->getLabel('offmessage'); ?>
                                            <?php echo $this->form->getInput('offmessage'); ?></li>
                                        </ul>
                                    </div>
                                </fieldset>
                                <fieldset class="adminform">
                                    <legend><?php echo JText::_('COM_IPROPERTY_GLOBAL_IP_SETTINGS'); ?></legend>
                                    <div class="fltlft">                
                                        <ul class="adminformlist">
                                            <li><?php echo $this->form->getLabel('showtitle'); ?>
                                            <?php echo $this->form->getInput('showtitle'); ?></li>
                                            <li><?php echo $this->form->getLabel('street_num_pos'); ?>
                                            <?php echo $this->form->getInput('street_num_pos'); ?></li>
                                            <li><?php echo $this->form->getLabel('measurement_units'); ?>
                                            <?php echo $this->form->getInput('measurement_units'); ?></li>
                                            <li><?php echo $this->form->getLabel('baths_fraction'); ?>
                                            <?php echo $this->form->getInput('baths_fraction'); ?></li>
                                            <li><?php echo $this->form->getLabel('new_days'); ?>
                                            <?php echo $this->form->getInput('new_days'); ?></li>
                                            <li><?php echo $this->form->getLabel('updated_days'); ?>
                                            <?php echo $this->form->getInput('updated_days'); ?></li>
                                            <li><?php echo $this->form->getLabel('rss'); ?>
                                            <?php echo $this->form->getInput('rss'); ?></li>
                                            <li><?php echo $this->form->getLabel('banner_display'); ?>
                                            <?php echo $this->form->getInput('banner_display'); ?></li>
                                            <li><?php echo $this->form->getLabel('accent'); ?>
                                            <?php echo $this->form->getInput('accent'); ?></li>
                                            <li><?php echo $this->form->getLabel('secondary_accent'); ?>
                                            <?php echo $this->form->getInput('secondary_accent'); ?></li>
                                            <li><?php echo $this->form->getLabel('force_accents'); ?>
                                            <?php echo $this->form->getInput('force_accents'); ?></li>
                                            <li><?php echo $this->form->getLabel('require_login'); ?>
                                            <?php echo $this->form->getInput('require_login'); ?></li>                                            
                                            <li><?php echo $this->form->getLabel('footer'); ?>
                                            <?php echo $this->form->getInput('footer'); ?></li>
                                        </ul>
                                    </div>
                                </fieldset>
                                <fieldset class="adminform">
                                    <legend><?php echo JText::_('ACL'); ?></legend>
                                    <div class="fltlft">                
                                        <ul class="adminformlist">
                                            <li><?php echo $this->form->getLabel('edit_rights'); ?>
                                            <?php echo $this->form->getInput('edit_rights'); ?></li>
                                            <li><?php echo $this->form->getLabel('auto_publish'); ?>
                                            <?php echo $this->form->getInput('auto_publish'); ?></li>
                                            <li><?php echo $this->form->getLabel('approval_level'); ?>
                                            <?php echo $this->form->getInput('approval_level'); ?></li>
                                            <li><?php echo $this->form->getLabel('notify_newprop'); ?>
                                            <?php echo $this->form->getInput('notify_newprop'); ?></li>
                                            <li><?php echo $this->form->getLabel('moderate_listings'); ?>
                                            <?php echo $this->form->getInput('moderate_listings'); ?></li>
                                            <li><?php echo $this->form->getLabel('auto_agent'); ?>
                                            <?php echo $this->form->getInput('auto_agent'); ?></li>                                            
                                        </ul>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="width-40 fltrt">
                                <fieldset class="adminform">
                                    <legend><?php echo JText::_('COM_IPROPERTY_CURRENCY_SETTINGS'); ?></legend>
                                    <div class="fltlft">                
                                        <ul class="adminformlist">
                                            <li><?php echo $this->form->getLabel('default_currency'); ?>
                                            <?php echo $this->form->getInput('default_currency'); ?></li>
                                            <li><?php echo $this->form->getLabel('currency'); ?>
                                            <?php echo $this->form->getInput('currency'); ?></li>
                                            <li><?php echo $this->form->getLabel('currency_digits'); ?>
                                            <?php echo $this->form->getInput('currency_digits'); ?></li>
                                            <li><?php echo $this->form->getLabel('nformat'); ?>
                                            <?php echo $this->form->getInput('nformat'); ?></li>
                                            <li><?php echo $this->form->getLabel('currency_pos'); ?>
                                            <?php echo $this->form->getInput('currency_pos'); ?></li>
                                        </ul>
                                    </div>
                                </fieldset>
                                <fieldset class="adminform">
                                    <legend><?php echo JText::_('COM_IPROPERTY_DEFAULTS'); ?></legend>
                                    <div class="fltlft">                
                                        <ul class="adminformlist">
                                            <li><?php echo $this->form->getLabel('default_company'); ?>
                                            <?php echo $this->form->getInput('default_company'); ?></li>
                                            <li><?php echo $this->form->getLabel('default_agent'); ?>
                                            <?php echo $this->form->getInput('default_agent'); ?></li>
                                            <li><?php echo $this->form->getLabel('default_category'); ?>
                                            <?php echo $this->form->getInput('default_category'); ?></li>
                                            <li><?php echo $this->form->getLabel('default_state'); ?>
                                            <?php echo $this->form->getInput('default_state'); ?></li>
                                            <li><?php echo $this->form->getLabel('default_country'); ?>
                                            <?php echo $this->form->getInput('default_country'); ?></li>
                                            <li><?php echo $this->form->getLabel('default_a_sort'); ?>
                                            <?php echo $this->form->getInput('default_a_sort'); ?></li>
                                            <li><?php echo $this->form->getLabel('default_a_order'); ?>
                                            <?php echo $this->form->getInput('default_a_order'); ?></li>
                                            <li><?php echo $this->form->getLabel('default_c_sort'); ?>
                                            <?php echo $this->form->getInput('default_c_sort'); ?></li>
                                            <li><?php echo $this->form->getLabel('default_c_order'); ?>
                                            <?php echo $this->form->getInput('default_c_order'); ?></li>
                                            <li><?php echo $this->form->getLabel('default_p_sort'); ?>
                                            <?php echo $this->form->getInput('default_p_sort'); ?></li>
                                            <li><?php echo $this->form->getLabel('default_p_order'); ?>
                                            <?php echo $this->form->getInput('default_p_order'); ?></li>
                                        </ul>
                                    </div>
                                </fieldset>
                            </div>
                        </td>
                    </tr>
                </table>

                <?php echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_CATEGORIES' ), 'cat_panel'); ?>                
                
                <div class="ip_spacer"></div>
                <table width="100%">
                    <tr>
                        <td>                            
                            <div class="width-60 fltlft">
                                <fieldset class="adminform">
                                    <legend><?php echo JText::_('COM_IPROPERTY_CATEGORY_SETTINGS'); ?></legend>
                                    <div class="fltlft">                
                                        <ul class="adminformlist">
                                            <li><?php echo $this->form->getLabel('cat_photo_width'); ?>
                                            <?php echo $this->form->getInput('cat_photo_width'); ?></li>
                                            <li><?php echo $this->form->getLabel('iplayout'); ?>
                                            <?php echo $this->form->getInput('iplayout'); ?></li>
                                            <li><?php echo $this->form->getLabel('show_scats'); ?>
                                            <?php echo $this->form->getInput('show_scats'); ?></li>
                                            <li><?php echo $this->form->getLabel('cat_recursive'); ?>
                                            <?php echo $this->form->getInput('cat_recursive'); ?></li>
                                            <li><?php echo $this->form->getLabel('cat_entries'); ?>
                                            <?php echo $this->form->getInput('cat_entries'); ?></li>
                                            <li><?php echo $this->form->getLabel('cat_featured'); ?>
                                            <?php echo $this->form->getInput('cat_featured'); ?></li>
                                            <li><?php echo $this->form->getLabel('cat_featured_pos'); ?>
                                            <?php echo $this->form->getInput('cat_featured_pos'); ?></li>
                                        </ul>
                                    </div>
                                </fieldset>
                            </div>
                        </td>
                    </tr>
                </table>
                
                <?php echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_PROPERTIES' ), 'prop_panel'); ?>
                
                <div class="ip_spacer"></div>
                <table width="100%">
                    <tr>
                        <td>                            
                            <div class="width-60 fltlft">
                                <fieldset class="adminform">
                                    <legend><?php echo JText::_('COM_IPROPERTY_PROPERTY_SETTINGS'); ?></legend>
                                    <div class="fltlft">                
                                        <ul class="adminformlist">
                                            <li><?php echo $this->form->getLabel('perpage'); ?>
                                            <?php echo $this->form->getInput('perpage'); ?></li>
                                            <li><?php echo $this->form->getLabel('show_featured'); ?>
                                            <?php echo $this->form->getInput('show_featured'); ?></li>
                                            <li><?php echo $this->form->getLabel('num_featured'); ?>
                                            <?php echo $this->form->getInput('num_featured'); ?></li>
                                            <li><?php echo $this->form->getLabel('featured_pos'); ?>
                                            <?php echo $this->form->getInput('featured_pos'); ?></li>
                                            <li><?php echo $this->form->getLabel('featured_accent'); ?>
                                            <?php echo $this->form->getInput('featured_accent'); ?></li>
                                            <li><?php echo $this->form->getLabel('tab_width'); ?>
                                            <?php echo $this->form->getInput('tab_width'); ?></li>
                                            <li><?php echo $this->form->getLabel('tab_height'); ?>
                                            <?php echo $this->form->getInput('tab_height'); ?></li>
                                            <li><?php echo $this->form->getLabel('overview_char'); ?>
                                            <?php echo $this->form->getInput('overview_char'); ?></li>
                                            <li><?php echo $this->form->getLabel('form_recipient'); ?>
                                            <?php echo $this->form->getInput('form_recipient'); ?></li>
                                            <li><?php echo $this->form->getLabel('form_copyadmin'); ?>
                                            <?php echo $this->form->getInput('form_copyadmin'); ?></li>
                                            <li><?php echo $this->form->getLabel('form_storeforms'); ?>
                                            <?php echo $this->form->getInput('form_storeforms'); ?></li>
                                        </ul>
                                    </div>
                                </fieldset>
                                <fieldset class="adminform">
                                    <legend><?php echo JText::_('COM_IPROPERTY_TOOLBAR_SETTINGS'); ?></legend>
                                    <div class="fltlft">                
                                        <ul class="adminformlist">
                                            <li><?php echo $this->form->getLabel('show_sendtofriend'); ?>
                                            <?php echo $this->form->getInput('show_sendtofriend'); ?></li>
                                            <li><?php echo $this->form->getLabel('notify_sendfriend'); ?>
                                            <?php echo $this->form->getInput('notify_sendfriend'); ?></li>
                                            <li><?php echo $this->form->getLabel('show_print'); ?>
                                            <?php echo $this->form->getInput('show_print'); ?></li>
                                            <li><?php echo $this->form->getLabel('show_saveproperty'); ?>
                                            <?php echo $this->form->getInput('show_saveproperty'); ?></li>
                                            <li><?php echo $this->form->getLabel('show_propupdate'); ?>
                                            <?php echo $this->form->getInput('show_propupdate'); ?></li>
                                            <li><?php echo $this->form->getLabel('notify_saveprop'); ?>
                                            <?php echo $this->form->getInput('notify_saveprop'); ?></li>
                                            <li><?php echo $this->form->getLabel('show_mtgcalc'); ?>
                                            <?php echo $this->form->getInput('show_mtgcalc'); ?></li>
                                        </ul>
                                    </div>
                                </fieldset>
                            </div>
                        </td>
                    </tr>
                </table>
                
                <?php echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_AGENTS' ), 'agent_panel'); ?>
                
                <div class="ip_spacer"></div>
                <table width="100%">
                    <tr>
                        <td>                            
                            <div class="width-60 fltlft">
                                <fieldset class="adminform">
                                    <legend><?php echo JText::_('COM_IPROPERTY_AGENT_SETTINGS'); ?></legend>
                                    <div class="fltlft">                
                                        <ul class="adminformlist">
                                            <li><?php echo $this->form->getLabel('show_agent'); ?>
                                            <?php echo $this->form->getInput('show_agent'); ?></li>
                                            <li><?php echo $this->form->getLabel('agent_photo_width'); ?>
                                            <?php echo $this->form->getInput('agent_photo_width'); ?></li>
                                            <li><?php echo $this->form->getLabel('agent_show_image'); ?>
                                            <?php echo $this->form->getInput('agent_show_image'); ?></li>                                            
                                            <li><?php echo $this->form->getLabel('agent_show_address'); ?>
                                            <?php echo $this->form->getInput('agent_show_address'); ?></li>
                                            <li><?php echo $this->form->getLabel('agent_show_contact'); ?>
                                            <?php echo $this->form->getInput('agent_show_contact'); ?></li>
                                            <li><?php echo $this->form->getLabel('agent_show_email'); ?>
                                            <?php echo $this->form->getInput('agent_show_email'); ?></li>
                                            <li><?php echo $this->form->getLabel('agent_show_phone'); ?>
                                            <?php echo $this->form->getInput('agent_show_phone'); ?></li>
                                            <li><?php echo $this->form->getLabel('agent_show_mobile'); ?>
                                            <?php echo $this->form->getInput('agent_show_mobile'); ?></li>
                                            <li><?php echo $this->form->getLabel('agent_show_fax'); ?>
                                            <?php echo $this->form->getInput('agent_show_fax'); ?></li>
                                            <li><?php echo $this->form->getLabel('agent_show_website'); ?>
                                            <?php echo $this->form->getInput('agent_show_website'); ?></li>
                                            <li><?php echo $this->form->getLabel('agent_show_social'); ?>
                                            <?php echo $this->form->getInput('agent_show_social'); ?></li>
                                            <li><?php echo $this->form->getLabel('agent_show_license'); ?>
                                            <?php echo $this->form->getInput('agent_show_license'); ?></li>
                                            <li><?php echo $this->form->getLabel('agent_show_featured'); ?>
                                            <?php echo $this->form->getInput('agent_show_featured'); ?></li>
                                            <li><?php echo $this->form->getLabel('agent_feat_num'); ?>
                                            <?php echo $this->form->getInput('agent_feat_num'); ?></li>
                                            <li><?php echo $this->form->getLabel('agent_feat_pos'); ?>
                                            <?php echo $this->form->getInput('agent_feat_pos'); ?></li>
                                        </ul>
                                    </div>
                                </fieldset>
                            </div>
                        </td>
                    </tr>
                </table>
                
                <?php echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_COMPANIES' ), 'company_panel'); ?>
                
                <div class="ip_spacer"></div>
                <table width="100%">
                    <tr>
                        <td>                            
                            <div class="width-60 fltlft">
                                <fieldset class="adminform">
                                    <legend><?php echo JText::_('COM_IPROPERTY_COMPANY_SETTINGS'); ?></legend>
                                    <div class="fltlft">                
                                        <ul class="adminformlist">
                                            <li><?php echo $this->form->getLabel('company_photo_width'); ?>
                                            <?php echo $this->form->getInput('company_photo_width'); ?></li>
                                            <li><?php echo $this->form->getLabel('co_show_image'); ?>
                                            <?php echo $this->form->getInput('co_show_image'); ?></li>
                                            <li><?php echo $this->form->getLabel('co_show_address'); ?>
                                            <?php echo $this->form->getInput('co_show_address'); ?></li>
                                            <li><?php echo $this->form->getLabel('co_show_contact'); ?>
                                            <?php echo $this->form->getInput('co_show_contact'); ?></li>
                                            <li><?php echo $this->form->getLabel('co_show_email'); ?>
                                            <?php echo $this->form->getInput('co_show_email'); ?></li>
                                            <li><?php echo $this->form->getLabel('co_show_phone'); ?>
                                            <?php echo $this->form->getInput('co_show_phone'); ?></li>
                                            <li><?php echo $this->form->getLabel('co_show_fax'); ?>
                                            <?php echo $this->form->getInput('co_show_fax'); ?></li>
                                            <li><?php echo $this->form->getLabel('co_show_website'); ?>
                                            <?php echo $this->form->getInput('co_show_website'); ?></li>
                                            <li><?php echo $this->form->getLabel('co_show_license'); ?>
                                            <?php echo $this->form->getInput('co_show_license'); ?></li>
                                            <li><?php echo $this->form->getLabel('co_show_featured'); ?>
                                            <?php echo $this->form->getInput('co_show_featured'); ?></li>
                                            <li><?php echo $this->form->getLabel('co_feat_num'); ?>
                                            <?php echo $this->form->getInput('co_feat_num'); ?></li>
                                            <li><?php echo $this->form->getLabel('co_feat_pos'); ?>
                                            <?php echo $this->form->getInput('co_feat_pos'); ?></li>
                                        </ul>
                                    </div>
                                </fieldset>
                            </div>
                        </td>
                    </tr>
                </table>
                
                <?php echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_QUICKSEARCH' ), 'quicksearch_panel'); ?>
                
                <div class="ip_spacer"></div>
                <table width="100%">
                    <tr>
                        <td>                            
                            <div class="width-60 fltlft">
                                <fieldset class="adminform">
                                    <legend><?php echo JText::_('COM_IPROPERTY_QUICKSEARCH_SETTINGS'); ?></legend>
                                    <div class="fltlft">                
                                        <ul class="adminformlist">
                                            <li><?php echo $this->form->getLabel('qs_show_keyword'); ?>
                                            <?php echo $this->form->getInput('qs_show_keyword'); ?></li>
                                            <li><?php echo $this->form->getLabel('qs_show_cat'); ?>
                                            <?php echo $this->form->getInput('qs_show_cat'); ?></li>
                                            <li><?php echo $this->form->getLabel('qs_show_stype'); ?>
                                            <?php echo $this->form->getInput('qs_show_stype'); ?></li>
                                            <li><?php echo $this->form->getLabel('qs_show_country'); ?>
                                            <?php echo $this->form->getInput('qs_show_country'); ?></li>
                                            <li><?php echo $this->form->getLabel('qs_show_city'); ?>
                                            <?php echo $this->form->getInput('qs_show_city'); ?></li>
                                            <li><?php echo $this->form->getLabel('qs_show_county'); ?>
                                            <?php echo $this->form->getInput('qs_show_county'); ?></li>
                                            <li><?php echo $this->form->getLabel('qs_show_region'); ?>
                                            <?php echo $this->form->getInput('qs_show_region'); ?></li>
                                            <li><?php echo $this->form->getLabel('qs_show_state'); ?>
                                            <?php echo $this->form->getInput('qs_show_state'); ?></li>
                                            <li><?php echo $this->form->getLabel('qs_show_province'); ?>
                                            <?php echo $this->form->getInput('qs_show_province'); ?></li>
                                            <li><?php echo $this->form->getLabel('qs_show_minbeds'); ?>
                                            <?php echo $this->form->getInput('qs_show_minbeds'); ?></li>
                                            <li><?php echo $this->form->getLabel('qs_show_minbaths'); ?>
                                            <?php echo $this->form->getInput('qs_show_minbaths'); ?></li>
                                            <li><?php echo $this->form->getLabel('qs_show_price'); ?>
                                            <?php echo $this->form->getInput('qs_show_price'); ?></li>
                                        </ul>
                                    </div>
                                </fieldset>
                            </div>
                        </td>
                    </tr>
                </table>
                
                <?php echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_ADVSEARCH' ), 'advsearch_panel'); ?>
                
                <div class="ip_spacer"></div>
                <table width="100%">
                    <tr>
                        <td>                            
                            <div class="width-60 fltlft">
                                <fieldset class="adminform">
                                    <legend><?php echo JText::_('COM_IPROPERTY_ADV_SEARCH_SETTINGS'); ?></legend>
                                    <div class="fltlft">                
                                        <ul class="adminformlist">
                                            <li><?php echo $this->form->getLabel('adv_perpage'); ?>
                                            <?php echo $this->form->getInput('adv_perpage'); ?></li>
                                            <li><?php echo $this->form->getLabel('adv_nolimit'); ?>
                                            <?php echo $this->form->getInput('adv_nolimit'); ?></li>
                                            <li><?php echo $this->form->getLabel('adv_price_low'); ?>
                                            <?php echo $this->form->getInput('adv_price_low'); ?></li>
                                            <li><?php echo $this->form->getLabel('adv_price_high'); ?>
                                            <?php echo $this->form->getInput('adv_price_high'); ?></li>
                                            <li><?php echo $this->form->getLabel('adv_beds_low'); ?>
                                            <?php echo $this->form->getInput('adv_beds_low'); ?></li>
                                            <li><?php echo $this->form->getLabel('adv_beds_high'); ?>
                                            <?php echo $this->form->getInput('adv_beds_high'); ?></li>
                                            <li><?php echo $this->form->getLabel('adv_baths_low'); ?>
                                            <?php echo $this->form->getInput('adv_baths_low'); ?></li>
                                            <li><?php echo $this->form->getLabel('adv_baths_high'); ?>
                                            <?php echo $this->form->getInput('adv_baths_high'); ?></li>
                                            <li><?php echo $this->form->getLabel('adv_sqft_low'); ?>
                                            <?php echo $this->form->getInput('adv_sqft_low'); ?></li>
                                            <li><?php echo $this->form->getLabel('adv_sqft_high'); ?>
                                            <?php echo $this->form->getInput('adv_sqft_high'); ?></li>
                                            <li><?php echo $this->form->getLabel('adv_default_lat'); ?>
                                            <?php echo $this->form->getInput('adv_default_lat'); ?></li>
                                            <li><?php echo $this->form->getLabel('adv_default_long'); ?>
                                            <?php echo $this->form->getInput('adv_default_long'); ?></li>
                                            <li><?php echo $this->form->getLabel('adv_default_zoom'); ?>
                                            <?php echo $this->form->getInput('adv_default_zoom'); ?></li>
                                            <li><?php echo $this->form->getLabel('adv_maptype'); ?>
                                            <?php echo $this->form->getInput('adv_maptype'); ?></li>
                                            <li><?php echo $this->form->getLabel('show_savesearch'); ?>
                                            <?php echo $this->form->getInput('show_savesearch'); ?></li>
                                            <li><?php echo $this->form->getLabel('show_searchupdate'); ?>
                                            <?php echo $this->form->getInput('show_searchupdate'); ?></li>
                                        </ul>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="width-40 fltrt">
                                <fieldset class="adminform">
                                    <legend><?php echo JText::_('COM_IPROPERTY_ADV_SEARCH_CRITERIA'); ?></legend>
                                    <div class="fltlft">                
                                        <ul class="adminformlist">
                                            <li><?php echo $this->form->getLabel('adv_show_shapetools'); ?>
                                            <?php echo $this->form->getInput('adv_show_shapetools'); ?></li>
                                            <li><?php echo $this->form->getLabel('adv_show_hoa'); ?>
                                            <?php echo $this->form->getInput('adv_show_hoa'); ?></li>
                                            <li><?php echo $this->form->getLabel('adv_show_reo'); ?>
                                            <?php echo $this->form->getInput('adv_show_reo'); ?></li>
                                            <li><?php echo $this->form->getLabel('adv_show_wf'); ?>
                                            <?php echo $this->form->getInput('adv_show_wf'); ?></li>
                                            <li><?php echo $this->form->getLabel('adv_show_stype'); ?>
                                            <?php echo $this->form->getInput('adv_show_stype'); ?></li>
                                            <li><?php echo $this->form->getLabel('adv_show_country'); ?>
                                            <?php echo $this->form->getInput('adv_show_country'); ?></li>
                                            <li><?php echo $this->form->getLabel('adv_show_locstate'); ?>
                                            <?php echo $this->form->getInput('adv_show_locstate'); ?></li>
                                            <li><?php echo $this->form->getLabel('adv_show_province'); ?>
                                            <?php echo $this->form->getInput('adv_show_province'); ?></li>
                                            <li><?php echo $this->form->getLabel('adv_show_county'); ?>
                                            <?php echo $this->form->getInput('adv_show_county'); ?></li>
                                            <li><?php echo $this->form->getLabel('adv_show_region'); ?>
                                            <?php echo $this->form->getInput('adv_show_region'); ?></li>
                                            <li><?php echo $this->form->getLabel('adv_show_thumb'); ?>
                                            <?php echo $this->form->getInput('adv_show_thumb'); ?></li>
                                            <li><?php echo $this->form->getLabel('adv_show_preview'); ?>
                                            <?php echo $this->form->getInput('adv_show_preview'); ?></li>
                                        </ul>
                                    </div>
                                </fieldset>
                            </div>
                        </td>
                    </tr>
                </table>
                
                <?php echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_GALLERY' ), 'gallery_panel'); ?>
                
                <div class="ip_spacer"></div>
                <table width="100%">
                    <tr>
                        <td>                            
                            <div class="width-60 fltlft">
                                <fieldset class="adminform">
                                    <legend><?php echo JText::_('COM_IPROPERTY_GENERAL_GALLERY_SETTINGS'); ?></legend>
                                    <div class="fltlft">                
                                        <ul class="adminformlist">
                                            <li><?php echo $this->form->getLabel('gallerytype'); ?>
                                            <?php echo $this->form->getInput('gallerytype'); ?></li>
                                            <li><?php echo $this->form->getLabel('gallery_width'); ?>
                                            <?php echo $this->form->getInput('gallery_width'); ?></li>
                                            <li><?php echo $this->form->getLabel('gallery_height'); ?>
                                            <?php echo $this->form->getInput('gallery_height'); ?></li>
                                            <li><?php echo $this->form->getLabel('imgpath'); ?>
                                            <?php echo $this->form->getInput('imgpath'); ?></li>
                                            <li><?php echo $this->form->getLabel('maximgs'); ?>
                                            <?php echo $this->form->getInput('maximgs'); ?></li>
                                            <li><?php echo $this->form->getLabel('maximgsize'); ?>
                                            <?php echo $this->form->getInput('maximgsize'); ?></li>
                                            <li><?php echo $this->form->getLabel('gplibrary'); ?>
                                            <?php echo $this->form->getInput('gplibrary'); ?></li>
                                        </ul>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="width-40 fltrt">
                                <fieldset class="adminform">
                                    <legend><?php echo JText::_('COM_IPROPERTY_OPTIMIZATION_SETTINGS'); ?></legend>
                                    <div class="fltlft">                
                                        <ul class="adminformlist">
                                            <li><?php echo $this->form->getLabel('imgwidth'); ?>
                                            <?php echo $this->form->getInput('imgwidth'); ?>
                                            <?php echo $this->form->getInput('imgheight'); ?></li>
                                            <li><?php echo $this->form->getLabel('imgproportion'); ?>
                                            <?php echo $this->form->getInput('imgproportion'); ?></li>
                                            <li><?php echo $this->form->getLabel('thumbwidth'); ?>
                                            <?php echo $this->form->getInput('thumbwidth'); ?>
                                            <?php echo $this->form->getInput('thumbheight'); ?></li>
                                            <li><?php echo $this->form->getLabel('thumbproportion'); ?>
                                            <?php echo $this->form->getInput('thumbproportion'); ?></li>
                                            <li><?php echo $this->form->getLabel('thumbquality'); ?>
                                            <?php echo $this->form->getInput('thumbquality'); ?></li>
                                            <li><?php echo $this->form->getLabel('watermark'); ?>
                                            <?php echo $this->form->getInput('watermark'); ?></li>
                                            <li><?php echo $this->form->getLabel('watermark_text'); ?>
                                            <?php echo $this->form->getInput('watermark_text'); ?></li>
                                        </ul>
                                    </div>
                                </fieldset>
                            </div>
                        </td>
                    </tr>
                </table>
                
                <?php echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_MISC' ), 'misc_panel'); ?>
                
                <div class="ip_spacer"></div>
                <div id="ipmessage"></div>
                <table width="100%">
                    <tr>
                        <td>                            
                            <div class="width-100 fltlft">
                                <fieldset class="adminform">
                                    <legend><?php echo JText::_( 'COM_IPROPERTY_SALE_TYPES' ); ?></legend>
                                    <table class="adminform" width="100%">
                                        <tr>
                                            <td><input type="button" onclick="saveStypes(); return false;" value="<?php echo JText::_( 'COM_IPROPERTY_SAVE' ); ?>" /></td>
                                            <td width="100%">&nbsp;</td>
                                        </tr>
                                    </table>
                                    <table class="adminlist" cellspacing="1" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="25%"><?php echo JText::_( 'COM_IPROPERTY_TITLE' ); ?></th>
                                                <th width="30%"><?php echo JText::_( 'COM_IPROPERTY_BANNER_IMAGE' ); ?></th>
                                                <th width="10%"><?php echo JText::_( 'COM_IPROPERTY_BANNER_COLOR' ); ?></span></th>
                                                <th width="10%"><?php echo JText::_( 'COM_IPROPERTY_PUBLISHED' ); ?></th>
                                                <th width="10%"><?php echo JText::_( 'COM_IPROPERTY_SHOW_BANNER' ); ?></th>
                                                <th width="5%"><?php echo JText::_( 'COM_IPROPERTY_ID' ); ?></th>
                                                <th width="10%"><?php echo JText::_( 'COM_IPROPERTY_ACTION' ); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody id="ajax-stypes-container">
                                        </tbody>
                                    </table>
                                </fieldset>
                            </div>
                            <div class="width-60 fltlft">
                                <fieldset class="adminform">
                                    <legend><?php echo JText::_('COM_IPROPERTY_DISCLAIMER'); ?></legend>
                                    <div class="fltlft">                
                                        <ul class="adminformlist">
                                            <li><?php echo $this->form->getLabel('disclaimer'); ?>
                                            <?php echo $this->form->getInput('disclaimer'); ?>
                                        </ul>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="width-40 fltlft">
                                <fieldset class="adminform">
                                    <legend><?php echo JText::_('COM_IPROPERTY_GOOGLE_SETTINGS'); ?></legend>
                                    <div class="fltlft">                
                                        <ul class="adminformlist">
                                            <li><?php echo $this->form->getLabel('googlemap_enable'); ?>
                                            <?php echo $this->form->getInput('googlemap_enable'); ?>
                                            <li><?php echo $this->form->getLabel('max_zoom'); ?>
                                            <?php echo $this->form->getInput('max_zoom'); ?>
                                        </ul>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="width-40 fltlft">
                                <fieldset class="adminform">
                                    <legend><?php echo JText::_('COM_IPROPERTY_FEED_SETTINGS'); ?></legend>
                                    <div class="fltlft">                
                                        <ul class="adminformlist">
                                            <li><?php echo $this->form->getLabel('feed_zillow'); ?>
                                            <?php echo $this->form->getInput('feed_zillow'); ?>
                                            <li><?php echo $this->form->getLabel('feed_kml'); ?>
                                            <?php echo $this->form->getInput('feed_kml'); ?>
                                        </ul>
                                    </div>
                                </fieldset>
                            </div>
                        </td>
                    </tr>
                </table>
                <?php echo JHtml::_('tabs.end'); ?>
                <input type="hidden" name="task" value="" />
                <?php echo JHtml::_('form.token'); ?>
            </form>
            <div class="clear"></div>
            <p class="copyright"><?php echo ipropertyAdmin::footer( ); ?></p>
        </td>
    </tr>
</table>