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

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.calendar');
JHtml::_('behavior.formvalidation');

// Create shortcut to parameters.
$params = $this->state->get('params');

// Change header element background to match template per IP settings
$headers_array = array('description', 'geocode', 'general_amen', 'exterior_amen', 'interior_amen');
foreach($headers_array as $h){
    $this->form->setFieldAttribute($h.'_header', 'color', $this->settings->accent);
    $this->form->setFieldAttribute($h.'_header', 'tcolor', $this->settings->secondary_accent);
}
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task) {
		if (task == 'propform.cancel'){
            <?php echo $this->form->getField('description')->save(); ?>
			Joomla.submitform(task);
        }else if(document.formvalidator.isValid(document.id('adminForm'))) {
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
            if(document.id('jform_stype').selectedIndex == ''){
                alert('Please select a sale type!');
                return false;
            }else if(document.id('jform_categories').selectedIndex == ''){
                alert('Please select at least one category!');
                return false;
            }
			<?php echo $this->form->getField('description')->save(); ?>
			Joomla.submitform(task);
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
    
    // autocomplete stuff
	document.addEvent('domready', function() {
		// set the inputs we want to autocomplete
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
	});    
</script>

<div class="edit item-page<?php echo $this->pageclass_sfx; ?>">
    <?php if ($this->params->get('show_page_heading', 1)) : ?>
        <h1>
            <?php echo $this->escape($this->params->get('page_heading')); ?>
        </h1>
    <?php endif; ?>
    <div class="ip_mainheader">
        <h2><?php echo $this->iptitle; ?></h2>
    </div>

    <form action="<?php echo JRoute::_('index.php?option=com_iproperty&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate ipform">
        <div class="formelm-buttons">
            <button type="button" onclick="Joomla.submitbutton('propform.apply')">
                <?php echo JText::_('COM_IPROPERTY_APPLY') ?>
            </button>
            <button type="button" onclick="Joomla.submitbutton('propform.save')">
                <?php echo JText::_('JSAVE') ?>
            </button>
            <button type="button" onclick="Joomla.submitbutton('propform.cancel')">
                <?php echo JText::_('JCANCEL') ?>
            </button>
        </div>
        <?php
        echo JHtml::_('tabs.start', 'prop_tabs', array('useCookie' => false));
        echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_DESCRIPTION' ), 'description_panel');
        ?>
        <div class="ip_spacer"></div>
        <div class="width-100">
            <fieldset>
                <legend><?php echo JText::_('COM_IPROPERTY_DETAILS'); ?></legend>
                <div class="formelm"><?php echo $this->form->getLabel('mls_id'); ?>
                <?php echo $this->form->getInput('mls_id'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('available'); ?>
                <?php echo $this->form->getInput('available'); ?></div>
                <?php if($this->settings->showtitle): ?>
                    <div class="formelm">
                        <?php echo $this->form->getLabel('title'); ?>
                        <?php echo $this->form->getInput('title'); ?>
                    </div>
                <?php endif; ?>       

                <?php if (is_null($this->item->id) || $this->ipauth->getAdmin()):?>
                    <div class="formelm">
                        <?php echo $this->form->getLabel('alias'); ?>
                        <?php echo $this->form->getInput('alias'); ?>
                    </div>
                <?php else: ?>
                    <div class="formelm">
                        <?php echo $this->form->getLabel('alias'); ?>
                        <?php echo $this->form->getValue('alias'); ?>
                    </div>
                <?php endif; ?>                
                <?php if($this->ipauth->getAdmin()): //only show company if admin user ?>
                    <div class="formelm"><?php echo $this->form->getLabel('listing_office'); ?>
                    <?php echo $this->form->getInput('listing_office'); ?></div>
                <?php else: //if not admin, set the listing office as the user agent company id ?>
                    <?php if($this->form->getValue('listing_office')): ?>
                        <div class="formelm"><?php echo $this->form->getLabel('listing_office'); ?>
                        <?php echo ipropertyHTML::getCompanyName($this->form->getValue('listing_office')); ?></div>
                        <input type="hidden" name="jform[listing_office]" value="<?php echo $this->form->getValue('listing_office'); ?>" />
                    <?php else: ?>
                        <input type="hidden" name="jform[listing_office]" value="<?php echo $this->ipauth->getUagentCid(); ?>" />
                    <?php endif; ?>
                <?php endif; ?>            
                <div class="formelm"><?php echo $this->form->getLabel('stype'); ?>
                <?php echo $this->form->getInput('stype'); ?></div>
                <div class="formelm">
                    <?php echo $this->form->getLabel('price'); ?>
                    <?php echo $this->form->getInput('price'); ?>
                    &nbsp;<?php echo JText::_( 'COM_IPROPERTY_PER' ); ?>&nbsp;
                    <?php echo $this->form->getInput('stype_freq'); ?>
                </div>
                <div class="formelm"><?php echo $this->form->getLabel('price2'); ?>
                <?php echo $this->form->getInput('price2'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('call_for_price'); ?>
                <?php echo $this->form->getInput('call_for_price'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('vtour'); ?>
                <?php echo $this->form->getInput('vtour'); ?></div>
                <div class="formelm">
                    <?php echo $this->form->getLabel('categories'); ?>
                    <?php echo $this->form->getInput('categories'); ?>
                    <?php if($this->ipauth->getAdmin() || $this->ipauth->getSuper()): //only show agents if admin or super agent user ?>
                        <?php echo $this->form->getInput('agents'); ?>
                    <?php else: ?>
                        <input type="hidden" name="jform[agents][]" value="" />
                    <?php endif; ?>
                </div>
                <div class="formelm"><?php echo $this->form->getLabel('short_description'); ?>
                <?php echo $this->form->getInput('short_description'); ?></div> 
                <div class="formelm">
                    <?php echo $this->form->getLabel('description_header'); ?>
                    <div class="clr"></div>
                    <?php echo $this->form->getInput('description'); ?>
                </div>            
            </fieldset>
        </div>

        <?php echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_LOCATION' ), 'location_panel'); ?>

        <div class="ip_spacer"></div>
        <div class="width-100">
            <fieldset>
                <legend><?php echo JText::_('COM_IPROPERTY_LOCATION'); ?></legend>
                <div class="formelm"><?php echo $this->form->getLabel('hide_address'); ?>
                <?php echo $this->form->getInput('hide_address'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('street_num'); ?>
                <?php echo $this->form->getInput('street_num'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('street'); ?>
                <?php echo $this->form->getInput('street'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('street2'); ?>
                <?php echo $this->form->getInput('street2'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('apt'); ?>
                <?php echo $this->form->getInput('apt'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('city'); ?>
                <?php echo $this->form->getInput('city'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('postcode'); ?>
                <?php echo $this->form->getInput('postcode'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('locstate'); ?>
                <?php echo $this->form->getInput('locstate'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('province'); ?>
                <?php echo $this->form->getInput('province'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('country'); ?>
                <?php echo $this->form->getInput('country'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('region'); ?>
                <?php echo $this->form->getInput('region'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('county'); ?>
                <?php echo $this->form->getInput('county'); ?></div>
            </fieldset>
            <fieldset>
            <legend><?php echo JText::_( 'COM_IPROPERTY_DRAG_AND_DROP' ); ?></legend> 
                <?php echo $this->form->getLabel('geocode_header'); ?>
				<div class="formelm"><?php echo $this->form->getLabel('show_map'); ?>
				<?php echo $this->form->getInput('show_map'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('latitude'); ?>
                <?php echo $this->form->getInput('latitude'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('longitude'); ?>
                <?php echo $this->form->getInput('longitude'); ?></div>
                <div><?php echo $this->form->getInput('google_map'); ?></div>
            </fieldset>
        </div>

        <?php echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_DETAILS' ), 'details_panel'); ?>

        <div class="ip_spacer"></div>
        <div class="width-100">
            <fieldset>
                <legend><?php echo JText::_('COM_IPROPERTY_DETAILS'); ?></legend>
                <div class="formelm"><?php echo $this->form->getLabel('beds'); ?>
                <?php echo $this->form->getInput('beds'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('baths'); ?>
                <?php echo $this->form->getInput('baths'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('sqft'); ?>
                <?php echo $this->form->getInput('sqft'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('lotsize'); ?>
                <?php echo $this->form->getInput('lotsize'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('lot_acres'); ?>
                <?php echo $this->form->getInput('lot_acres'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('lot_type'); ?>
                <?php echo $this->form->getInput('lot_type'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('heat'); ?>
                <?php echo $this->form->getInput('heat'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('cool'); ?>
                <?php echo $this->form->getInput('cool'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('fuel'); ?>
                <?php echo $this->form->getInput('fuel'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('garage_type'); ?>
                <?php echo $this->form->getInput('garage_type'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('garage_size'); ?>
                <?php echo $this->form->getInput('garage_size'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('siding'); ?>
                <?php echo $this->form->getInput('siding'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('roof'); ?>
                <?php echo $this->form->getInput('roof'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('reception'); ?>
                <?php echo $this->form->getInput('reception'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('tax'); ?>
                <?php echo $this->form->getInput('tax'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('income'); ?>
                <?php echo $this->form->getInput('income'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('yearbuilt'); ?>
                <?php echo $this->form->getInput('yearbuilt'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('zoning'); ?>
                <?php echo $this->form->getInput('zoning'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('propview'); ?>
                <?php echo $this->form->getInput('propview'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('school_district'); ?>
                <?php echo $this->form->getInput('school_district'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('style'); ?>
                <?php echo $this->form->getInput('style'); ?></div>
                <?php if($this->settings->adv_show_wf): ?>
                    <div class="formelm"><?php echo $this->form->getLabel('frontage'); ?>
                    <?php echo $this->form->getInput('frontage'); ?></div>
                <?php endif; ?>
                <?php if($this->settings->adv_show_reo): ?>
                    <div class="formelm"><?php echo $this->form->getLabel('reo'); ?>
                    <?php echo $this->form->getInput('reo'); ?></div>
                <?php endif; ?>
                <?php if($this->settings->adv_show_hoa): ?>
                    <div class="formelm"><?php echo $this->form->getLabel('hoa'); ?>
                    <?php echo $this->form->getInput('hoa'); ?></div>
                <?php endif; ?>
            </fieldset>
        </div>

        <?php  echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_AMENITIES' ), 'amenities_panel'); ?>

        <div class="ip_spacer"></div>
        <div class="width-100">
            <fieldset>
                <legend><?php echo JText::_('COM_IPROPERTY_AMENITIES'); ?></legend>
                <div>
                    <?php echo $this->form->getLabel('general_amen_header'); ?>
                    <?php echo $this->form->getInput('general_amens'); ?>
                </div>
                <div>
                    <?php echo $this->form->getLabel('interior_amen_header'); ?>
                    <?php echo $this->form->getInput('interior_amens'); ?>
                </div>
                <div>
                    <?php echo $this->form->getLabel('exterior_amen_header'); ?>
                    <?php echo $this->form->getInput('exterior_amens'); ?>
                </div>
            </fieldset>
        </div>

        <?php echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_IMAGES' ), 'images_panel'); ?>

        <div class="ip_spacer"></div> 
        <div class="width-100">
            <?php  echo JText::_( 'COM_IPROPERTY_IMAGES_OVERVIEW' ); ?>
        </div>
        <div class="clear"></div>
        <?php if($this->item->id): ?>
            <?php echo $this->form->getInput('gallery'); ?>
        <?php else: ?>
            <div class="ip_attention"><?php echo JText::_( 'COM_IPROPERTY_SAVE_BEFORE_IMAGES' ); ?></div>
        <?php endif; ?>
            
        <!-- 2.0.1 Added video -->
        <?php if($this->form->getLabel('video')): ?>
        <?php echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_VIDEO' ), 'video_panel'); ?>
        <div class="ip_spacer"></div>
        <div class="width-100">
            <fieldset>
                <legend><?php echo JText::_( 'COM_IPROPERTY_VIDEO' ); ?></legend>
                <div class="formelm"><?php echo $this->form->getLabel('video'); ?>
                <?php echo $this->form->getInput('video'); ?></div>
            </fieldset>
        </div>
        <?php endif; ?>

        <?php echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_OTHER' ), 'misc_panel'); ?>

        <div class="ip_spacer"></div> 
        <div class="width-100">
            <fieldset>
                <legend><?php echo JText::_('COM_IPROPERTY_AGENT_NOTES'); ?></legend>
                <div class="formelm"><?php echo $this->form->getLabel('agent_notes'); ?>
                <?php echo $this->form->getInput('agent_notes'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('terms'); ?>
                <?php echo $this->form->getInput('terms'); ?></div>
            </fieldset>
            <fieldset class="adminform">
                <legend><?php echo JText::_('COM_IPROPERTY_PUBLISHING'); ?></legend>
                <div class="formelm"><?php echo $this->form->getLabel('access'); ?>
                <?php echo $this->form->getInput('access'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('publish_up'); ?>
                <?php echo $this->form->getInput('publish_up'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('publish_down'); ?>
                <?php echo $this->form->getInput('publish_down'); ?></div>
            </fieldset>
            <fieldset class="adminform">
            <legend><?php echo JText::_( 'COM_IPROPERTY_META_INFO' ); ?></legend>
                <div class="formelm"><?php echo $this->form->getLabel('metakey'); ?>
                <?php echo $this->form->getInput('metakey'); ?></div>
                <div class="formelm"><?php echo $this->form->getLabel('metadesc'); ?>
                <?php echo $this->form->getInput('metadesc'); ?></div>
            </fieldset>
        </div>

        <?php
        $this->dispatcher->trigger('onAfterRenderPropertyEdit', array($this->item, $this->settings ));
        echo JHtml::_('tabs.end');
        ?>   
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="return" value="<?php echo $this->return_page;?>" />
        <?php echo JHtml::_( 'form.token' ); ?>
    </form>
</div>