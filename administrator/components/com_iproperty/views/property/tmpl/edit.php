<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.modal');
JHtml::_('behavior.keepalive');
?>
<script language="javascript" type="text/javascript">
	

    Joomla.submitbutton = function(task)
	{
		// if save as copy, make alias unique
		if (task == 'property.save2copy'){
			var alias = document.id('jform_alias').value;
			document.id('jform_alias').value = alias +'_'+String.uniqueID();
		}
	
        if (task == 'property.cancel'){
            <?php echo $this->form->getField('description')->save(); ?>
			Joomla.submitform(task, document.getElementById('iproperty-form'));
        }else if(document.formvalidator.isValid(document.id('iproperty-form'))) {
            <?php if($this->ipauth->getAdmin()): //only confirm company if admin user ?>
                if(document.id('jform_listing_office').selectedIndex == ''){
                    alert('Please select a listing office!');
                    return false;
                }
            <?php endif; ?>
            <?php if($this->ipauth->getAdmin() || $this->ipauth->getSuper()): //only confirm agnets if admin or super agent ?>
                if(document.id('jform_agents').selectedIndex == ''){
                    alert('Please select at least one agent!');
                    return false;
                }
            <?php endif; ?>
            if(document.id('jform_type').selectedIndex == ''){
                alert('Please select a type!');
                return false;
            }if(document.id('jform_stype').selectedIndex == ''){
                alert('Please select a sale type!');
                return false;
            }else if(document.id('jform_categories').selectedIndex == ''){
                alert('Please select at least one category!');
                return false;
            }
			<?php echo $this->form->getField('description')->save(); ?>
			Joomla.submitform(task, document.id('iproperty-form'));
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}

    // autocomplete stuff
	document.addEvent('domready', function() {
		// set the inputs we want to autocomplete
		/* Volodya
		var autoCity 	= $('jform_city');
		var autoProv 	= $('jform_province');
		var autoRegion 	= $('jform_region');
		var autoCounty	= $('jform_county');
		
		new Autocompleter.Request.JSON(autoCity, '<?php echo JURI::base('true'); ?>/index.php?option=com_iproperty&task=ajax.ajaxAutocomplete&format=raw&field=city&<?php echo JUtility::getToken(); ?>=1', {
			'indicatorClass': 'autocompleter-loading',
			'minLength': 2,
			'selectMode': 'pick'
		});
		new Autocompleter.Request.JSON(autoProv, '<?php echo JURI::base('true'); ?>/index.php?option=com_iproperty&task=ajax.ajaxAutocomplete&format=raw&field=province&<?php echo JUtility::getToken(); ?>=1', {
			'indicatorClass': 'autocompleter-loading',
			'minLength': 2,
			'selectMode': 'pick'
		});
		new Autocompleter.Request.JSON(autoRegion, '<?php echo JURI::base('true'); ?>/index.php?option=com_iproperty&task=ajax.ajaxAutocomplete&format=raw&field=region&<?php echo JUtility::getToken(); ?>=1', {
			'indicatorClass': 'autocompleter-loading',
			'minLength': 2,
			'selectMode': 'pick'
		});
		new Autocompleter.Request.JSON(autoCounty, '<?php echo JURI::base('true'); ?>/index.php?option=com_iproperty&task=ajax.ajaxAutocomplete&format=raw&field=county&<?php echo JUtility::getToken(); ?>=1', {
			'indicatorClass': 'autocompleter-loading',
			'minLength': 2,
			'selectMode': 'pick'
		});
		*/
	});
</script>


<form action="<?php echo JRoute::_('index.php?option=com_iproperty&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="iproperty-form" class="form-validate">
    <div class="width-60 fltlft">
        <?php
        echo JHtml::_('tabs.start', 'prop_tabs', array('useCookie' => false));
        echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_DESCRIPTION' ), 'description_panel');
        ?>
        <div class="ip_spacer"></div>
        <div class="width-100">
            <fieldset class="adminform">
            <legend><?php echo JText::_( 'COM_IPROPERTY_DETAILS' ); ?></legend>
                <ul class="adminformlist">
                    <?php if($this->settings->showtitle): ?>
                        <li><?php echo $this->form->getLabel('title'); ?>
                        <?php echo $this->form->getInput('title'); ?></li>
                    <?php endif; ?>
                    <li><?php echo $this->form->getLabel('alias'); ?>
                    <?php echo $this->form->getInput('alias'); ?></li>
                    <li><?php echo $this->form->getLabel('mls_id'); ?>
                    <?php echo $this->form->getInput('mls_id'); ?></li>
                    <li><?php echo $this->form->getLabel('available'); ?>
                    <?php echo $this->form->getInput('available'); ?></li>
                    <?php if($this->ipauth->getAdmin()): //only show company if admin user ?>
                        <li><?php echo $this->form->getLabel('listing_office'); ?>
                        <?php echo $this->form->getInput('listing_office'); ?></li>
                    <?php else: //if not admin, set the listing office as the user agent company id ?>
                        <?php if($this->form->getValue('listing_office')): ?>
                            <li><?php echo $this->form->getLabel('listing_office'); ?>
                            <?php echo ipropertyHTML::getCompanyName($this->form->getValue('listing_office')); ?></li>
                        <?php endif; ?>
                        <input type="hidden" name="jform[listing_office]" value="<?php echo $this->ipauth->getUagentCid(); ?>" />
                    <?php endif; ?>
                    <li><?php echo $this->form->getLabel('type'); ?>
                    <?php echo $this->form->getInput('type'); ?></li>
                    <li><?php echo $this->form->getLabel('stype'); ?>
                    <?php echo $this->form->getInput('stype'); ?></li>
                    <li><?php echo $this->form->getLabel('price'); ?>
                        <fieldset class="radio inputbox">
                            <?php echo $this->form->getInput('price'); ?>
                            <label>&nbsp;<?php echo JText::_( 'COM_IPROPERTY_PER' ); ?>&nbsp;</label>
                            <?php echo $this->form->getInput('stype_freq'); ?>
                        </fieldset>
                    </li>
                    <li><?php echo $this->form->getLabel('price2'); ?>
                    <?php echo $this->form->getInput('price2'); ?></li>
                    <li><?php echo $this->form->getLabel('call_for_price'); ?>
                    <?php echo $this->form->getInput('call_for_price'); ?></li>
                    <li><?php echo $this->form->getLabel('vtour'); ?>
                    <?php echo $this->form->getInput('vtour'); ?></li>
                    <li>
                        <?php echo $this->form->getLabel('categories'); ?>
                        <?php echo $this->form->getInput('categories'); ?>
                        <?php if($this->ipauth->getAdmin() || $this->ipauth->getSuper()): //only show agents if admin or super agent user ?>
                            <?php echo $this->form->getInput('agents'); ?>
                        <?php else: ?>
                            <input type="hidden" name="jform[agents][]" value="" />
                        <?php endif; ?>
                    </li>
                    <li><?php echo $this->form->getLabel('short_description'); ?>
                    <?php echo $this->form->getInput('short_description'); ?></li>
                    <li>
                        <?php echo $this->form->getLabel('description_header'); ?>
                        <div class="clr"></div>
                        <?php echo $this->form->getInput('description'); ?>
                    </li>
                </ul>
                <div class="clr" style="height: 10px;"></div>
            </fieldset>
        </div>

        <?php echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_LOCATION' ), 'location_panel'); ?>

        <div class="ip_spacer"></div>
        <div class="width-100">
            <fieldset class="adminform">
            <legend><?php echo JText::_( 'COM_IPROPERTY_LOCATION' ); ?></legend>
                <ul class="adminformlist">
                    <li><?php echo $this->form->getLabel('hide_address'); ?>
                    <?php echo $this->form->getInput('hide_address'); ?></li>
                    <li><?php echo $this->form->getLabel('street_num'); ?>
                    <?php echo $this->form->getInput('street_num'); ?></li>
                    <li><?php echo $this->form->getLabel('street'); ?>
                    <?php echo $this->form->getInput('street'); ?></li>
                    <li><?php echo $this->form->getLabel('street2'); ?>
                    <?php echo $this->form->getInput('street2'); ?></li>
                    <li><?php echo $this->form->getLabel('apt'); ?>
                    <?php echo $this->form->getInput('apt'); ?></li>
                    <li><?php echo $this->form->getLabel('city'); ?>
                    <?php echo $this->form->getInput('city'); ?></li>
                    <li><?php echo $this->form->getLabel('postcode'); ?>
                    <?php echo $this->form->getInput('postcode'); ?></li>
                    <li><?php echo $this->form->getLabel('locstate'); ?>
                    <?php echo $this->form->getInput('locstate'); ?></li>
                    <li><?php echo $this->form->getLabel('province'); ?>
                    <?php echo $this->form->getInput('province'); ?></li>
                    <li><?php echo $this->form->getLabel('country'); ?>
                    <?php echo $this->form->getInput('country'); ?></li>
                    <li><?php echo $this->form->getLabel('region'); ?>
                    <?php echo $this->form->getInput('region'); ?></li>
                    <li><?php echo $this->form->getLabel('county'); ?>
                    <?php echo $this->form->getInput('county'); ?></li>
                </ul>
            </fieldset>
            <fieldset class="adminform">
            <legend><?php echo JText::_( 'COM_IPROPERTY_DRAG_AND_DROP' ); ?></legend>
                <?php echo $this->form->getLabel('geocode_header'); ?>
                <div class="width-40 fltlft">
                    <ul class="adminformlist">
                        <li><?php echo $this->form->getLabel('show_map'); ?>
                        <?php echo $this->form->getInput('show_map'); ?></li>
                        <li><?php echo $this->form->getLabel('latitude'); ?>
                        <?php echo $this->form->getInput('latitude'); ?></li>
                        <li><?php echo $this->form->getLabel('longitude'); ?>
                        <?php echo $this->form->getInput('longitude'); ?></li>
                    </ul>
                </div>
                <div class="width-60 fltrt">
                    <?php echo $this->form->getInput('google_map'); ?>
                </div>
            </fieldset>
        </div>

        <?php echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_DETAILS' ), 'details_panel'); ?>

        <div class="ip_spacer"></div>
        <div class="width-100">
            <fieldset class="adminform">
            <legend><?php echo JText::_( 'COM_IPROPERTY_DETAILS' ); ?></legend>
                <div class="width-50 fltlft">
                    <ul class="adminformlist">
                        <li><?php echo $this->form->getLabel('beds'); ?>
                        <?php echo $this->form->getInput('beds'); ?></li>
                        <li><?php echo $this->form->getLabel('baths'); ?>
                        <?php echo $this->form->getInput('baths'); ?></li>
                        <li><?php echo $this->form->getLabel('sqft'); ?>
                        <?php echo $this->form->getInput('sqft'); ?></li>
                        <li><?php echo $this->form->getLabel('lotsize'); ?>
                        <?php echo $this->form->getInput('lotsize'); ?></li>
                        <li><?php echo $this->form->getLabel('lot_acres'); ?>
                        <?php echo $this->form->getInput('lot_acres'); ?></li>
                        <li><?php echo $this->form->getLabel('lot_type'); ?>
                        <?php echo $this->form->getInput('lot_type'); ?></li>
                        <li><?php echo $this->form->getLabel('heat'); ?>
                        <?php echo $this->form->getInput('heat'); ?></li>
                        <li><?php echo $this->form->getLabel('cool'); ?>
                        <?php echo $this->form->getInput('cool'); ?></li>
                        <li><?php echo $this->form->getLabel('fuel'); ?>
                        <?php echo $this->form->getInput('fuel'); ?></li>
                        <li><?php echo $this->form->getLabel('garage_type'); ?>
                        <?php echo $this->form->getInput('garage_type'); ?></li>
                        <li><?php echo $this->form->getLabel('garage_size'); ?>
                        <?php echo $this->form->getInput('garage_size'); ?></li>
                        <li><?php echo $this->form->getLabel('siding'); ?>
                        <?php echo $this->form->getInput('siding'); ?></li>
                        <li><?php echo $this->form->getLabel('roof'); ?>
                        <?php echo $this->form->getInput('roof'); ?></li>
                        <li><?php echo $this->form->getLabel('reception'); ?>
                        <?php echo $this->form->getInput('reception'); ?></li>
                        <li><?php echo $this->form->getLabel('tax'); ?>
                        <?php echo $this->form->getInput('tax'); ?></li>
                        <li><?php echo $this->form->getLabel('income'); ?>
                        <?php echo $this->form->getInput('income'); ?></li>
                    </ul>
                </div>
                <div class="width-50 fltlft">
                    <ul class="adminformlist">
                        <li><?php echo $this->form->getLabel('yearbuilt'); ?>
                        <?php echo $this->form->getInput('yearbuilt'); ?></li>
                        <li><?php echo $this->form->getLabel('zoning'); ?>
                        <?php echo $this->form->getInput('zoning'); ?></li>
                        <li><?php echo $this->form->getLabel('propview'); ?>
                        <?php echo $this->form->getInput('propview'); ?></li>
                        <li><?php echo $this->form->getLabel('school_district'); ?>
                        <?php echo $this->form->getInput('school_district'); ?></li>
                        <li><?php echo $this->form->getLabel('style'); ?>
                        <?php echo $this->form->getInput('style'); ?></li>
                        <?php if($this->settings->adv_show_wf): ?>
                            <li><?php echo $this->form->getLabel('frontage'); ?>
                            <?php echo $this->form->getInput('frontage'); ?></li>
                        <?php endif; ?>
                        <?php if($this->settings->adv_show_reo): ?>
                            <li><?php echo $this->form->getLabel('reo'); ?>
                            <?php echo $this->form->getInput('reo'); ?></li>
                        <?php endif; ?>
                        <?php if($this->settings->adv_show_hoa): ?>
                            <li><?php echo $this->form->getLabel('hoa'); ?>
                            <?php echo $this->form->getInput('hoa'); ?></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </fieldset>
        </div>
        <?php echo JHtml::_('tabs.panel', 'Demographics', 'demographics_panel'); ?>

        <?php
        	if($this->propid)
        	{ 
        		include('edit.demographics.php');
        	}
        	else 
        	{
        		echo 'Please Save Newly created property to edit demographics!';
        	}
        ?>
        
        <?php  echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_AMENITIES' ), 'amenities_panel'); ?>

        <div class="ip_spacer"></div>
        <div class="width-100">
            <fieldset class="adminform">
            <legend><?php echo JText::_( 'COM_IPROPERTY_DETAILS' ); ?></legend>
                <div class="width-30 fltlft" style="margin-right: 20px;">
                    <?php echo $this->form->getLabel('general_amen_header'); ?>
                    <?php echo $this->form->getInput('general_amens'); ?>
                </div>
                <div class="width-30 fltlft" style="margin-right: 20px;">
                    <?php echo $this->form->getLabel('interior_amen_header'); ?>
                    <?php echo $this->form->getInput('interior_amens'); ?>
                </div>
                <div class="width-30 fltlft">
                    <?php echo $this->form->getLabel('exterior_amen_header'); ?>
                    <?php echo $this->form->getInput('exterior_amens'); ?>
                </div>
            </fieldset>
        </div>

        <?php echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_IMAGES' ), 'images_panel'); ?>

        <div class="ip_spacer"></div>
        <div style="padding: 10px;">
            <?php  echo JText::_( 'COM_IPROPERTY_IMAGES_OVERVIEW' ); ?>
        </div>
        <div class="clear"></div>
        <?php if($this->item->id): ?>
            <?php echo $this->form->getInput('gallery'); ?>
        <?php else: ?>
            <div class="ip_attention"><?php echo JText::_( 'COM_IPROPERTY_SAVE_BEFORE_IMAGES' ); ?></div>
        <?php endif; ?>

        <?php echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_VIDEO' ), 'video_panel'); ?>

        <div class="ip_spacer"></div>
        <div class="width-100">
            <fieldset class="adminform">
            <legend><?php echo JText::_( 'COM_IPROPERTY_VIDEO' ); ?></legend>
                <ul class="adminformlist">
                    <li><?php echo $this->form->getLabel('video'); ?>
                    <?php echo $this->form->getInput('video'); ?></li>
                </ul>
            </fieldset>
        </div>

        <?php echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_AGENT_NOTES' ), 'notes_panel'); ?>

        <div class="ip_spacer"></div>
        <div class="width-100">
            <fieldset class="adminform">
            <legend><?php echo JText::_( 'COM_IPROPERTY_AGENT_NOTES' ); ?></legend>
                <ul class="adminformlist">
                    <li><?php echo $this->form->getLabel('agent_notes'); ?>
                    <?php echo $this->form->getInput('agent_notes'); ?></li>
                    <li><?php echo $this->form->getLabel('terms'); ?>
                    <?php echo $this->form->getInput('terms'); ?></li>
                </ul>
            </fieldset>
        </div>
		
		<?php echo JHtml::_('tabs.panel', 'Spaces', 'spaces_panel'); ?>
        
        <?php
        	if($this->propid)
        	{ 
        		include('edit.spaces.php');
        	}
        	else 
        	{
        		echo 'Please Save Newly created property to edit Spaces!';
        	}
        	
        ?>

        <?php echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_NMS_TENANTS' ), 'tenants_panel'); ?>
        <?php  
        	if($this->propid)
        	{ 
        		include('edit.tenants.php');
        	}
        	else 
        	{
        		echo 'Please Save Newly created property to edit Tenants!';
        	}
        	
        ?>


        <?php
        $this->dispatcher->trigger('onAfterRenderPropertyEdit', array($this->item, $this->settings ));
        echo JHtml::_('tabs.end');
        ?>
    </div>


    <!-- right bar -->
    <div class="width-40 fltrt ip_paneldown">
        <?php if ($this->ipauth->getSuper() || $this->ipauth->getAdmin()): ?>
            <fieldset class="adminform superagent_params">
                <legend><?php echo JText::_('COM_IPROPERTY_DETAILS'); ?></legend>
                <ul class="adminformlist">
                    <li><?php echo $this->form->getLabel('hits'); ?>
                    <?php echo $this->form->getInput('hits'); ?></li>
                    <li><?php echo $this->form->getLabel('created_by'); ?>
                    <?php echo $this->form->getInput('created_by'); ?></li>
                    <li><?php echo $this->form->getLabel('created'); ?>
                    <?php echo $this->form->getInput('created'); ?></li>
                    <?php if( $this->item->modified && $this->item->modified != '0000-00-00 00:00:00' ): ?>
                        <li><?php echo $this->form->getLabel('modified'); ?>
                        <?php echo $this->form->getInput('modified'); ?></li>
                        <li><?php echo $this->form->getLabel('modified_by'); ?>
                        <?php echo $this->form->getInput('modified_by'); ?></li>
                    <?php endif; ?>
                    <li><?php echo $this->form->getLabel('featured'); ?>
                    <?php echo $this->form->getInput('featured'); ?></li>
                    <li><?php echo $this->form->getLabel('approved'); ?>
                    <?php echo $this->form->getInput('approved'); ?></li>
                </ul>
            </fieldset>
        <?php endif; ?>
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_IPROPERTY_PUBLISHING'); ?></legend>
            <ul class="adminformlist">
                <li><?php echo $this->form->getLabel('access'); ?>
                <?php echo $this->form->getInput('access'); ?></li>
                <li><?php echo $this->form->getLabel('publish_up'); ?>
                <?php echo $this->form->getInput('publish_up'); ?></li>
                <li><?php echo $this->form->getLabel('publish_down'); ?>
                <?php echo $this->form->getInput('publish_down'); ?></li>
                <li><?php echo $this->form->getLabel('state'); ?>
                <?php echo $this->form->getInput('state'); ?></li>
            </ul>
        </fieldset>
        <fieldset class="adminform">
        <legend><?php echo JText::_( 'COM_IPROPERTY_META_INFO' ); ?></legend>
            <ul class="adminformlist">
                <li><?php echo $this->form->getLabel('metakey'); ?>
                <?php echo $this->form->getInput('metakey'); ?></li>
                <li><?php echo $this->form->getLabel('metadesc'); ?>
                <?php echo $this->form->getInput('metadesc'); ?></li>
            </ul>
        </fieldset>
    </div>
    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
</form>
<div class="clr"></div>
<p class="copyright"><?php echo ipropertyAdmin::footer( ); ?></p>