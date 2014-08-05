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
JHtml::_('behavior.formvalidation');

// Create shortcut to parameters.
$params = $this->state->get('params');
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task) {
		// hack for &*%& IE8
		if(Browser.ie8){
			if(document.getElementById('pluploadcontainer') != null){
				document.id('pluploadcontainer').destroy();
			}
		}	
	
		if (task == 'companyform.cancel'){
			Joomla.submitform(task);
        }else if(document.formvalidator.isValid(document.id('adminForm'))) {
			Joomla.submitform(task);
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
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
            <button type="button" onclick="Joomla.submitbutton('companyform.apply')">
                <?php echo JText::_('COM_IPROPERTY_APPLY') ?>
            </button>
            <button type="button" onclick="Joomla.submitbutton('companyform.save')">
                <?php echo JText::_('JSAVE') ?>
            </button>
            <button type="button" onclick="Joomla.submitbutton('companyform.cancel')">
                <?php echo JText::_('JCANCEL') ?>
            </button>
        </div>
        <?php
        echo JHtml::_('tabs.start', 'company_tabs', array('useCookie' => false));
        echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_DETAILS' ), 'details_panel');
        ?>
        <div class="ip_spacer"></div>
        <div class="width-100">
            <fieldset>
                <legend><?php echo JText::_('COM_IPROPERTY_DETAILS'); ?></legend>                   
                <div class="formelm">
                    <?php echo $this->form->getLabel('name'); ?>
                    <?php echo $this->form->getInput('name'); ?>
                </div>
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
                <div class="formelm">
                    <?php echo $this->form->getLabel('email'); ?>
                    <?php echo $this->form->getInput('email'); ?>
                </div>
                <div class="formelm">
                    <?php echo $this->form->getLabel('phone'); ?>
                    <?php echo $this->form->getInput('phone'); ?>
                </div>
                <div class="formelm">
                    <?php echo $this->form->getLabel('fax'); ?>
                    <?php echo $this->form->getInput('fax'); ?>
                </div>
                <div class="formelm">
                    <?php echo $this->form->getLabel('clicense'); ?>
                    <?php echo $this->form->getInput('clicense'); ?>
                </div>
            </fieldset>
            <fieldset>
                <legend><?php echo JText::_('COM_IPROPERTY_ADDRESS'); ?></legend>
                <div class="formelm">
                    <?php echo $this->form->getLabel('street'); ?>
                    <?php echo $this->form->getInput('street'); ?>
                </div>
                <div class="formelm">
                    <?php echo $this->form->getLabel('city'); ?>
                    <?php echo $this->form->getInput('city'); ?>
                </div>
                <div class="formelm">
                    <?php echo $this->form->getLabel('locstate'); ?>
                    <?php echo $this->form->getInput('locstate'); ?>
                </div>
                <div class="formelm">
                    <?php echo $this->form->getLabel('province'); ?>
                    <?php echo $this->form->getInput('province'); ?>
                </div>
                <div class="formelm">
                    <?php echo $this->form->getLabel('postcode'); ?>
                    <?php echo $this->form->getInput('postcode'); ?>
                </div>
                <div class="formelm">
                    <?php echo $this->form->getLabel('country'); ?>
                    <?php echo $this->form->getInput('country'); ?>
                </div>
            </fieldset>
            <fieldset>
                <legend><?php echo JText::_('COM_IPROPERTY_WEB'); ?></legend>
                <div class="formelm">
                    <?php echo $this->form->getLabel('website'); ?>
                    <?php echo $this->form->getInput('website'); ?>
                </div>
            </fieldset>
            <fieldset>
                <legend><?php echo JText::_('COM_IPROPERTY_IMAGE'); ?></legend>
                <div class="formelm">
                    <?php echo $this->form->getInput('icon'); ?>
                </div>
            </fieldset>
        </div> 
        <!-- admin can edit params -->
        <?php if ($this->ipauth->getAdmin()): 
            echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_OTHER' ), 'misc_panel');?>
                <fieldset class="adminform">
                    <legend><?php echo JText::_('JPUBLISHED'); ?></legend>
                    <div class="formelm">
                        <?php echo $this->form->getLabel('state'); ?>
                        <?php echo $this->form->getInput('state'); ?>
                    </div>
                    <div class="formelm">
                        <?php echo $this->form->getLabel('featured'); ?>
                        <?php echo $this->form->getInput('featured'); ?>                   
                    </div>
                </fieldset>
                <fieldset class="adminform admin_params">
                    <legend><?php echo JText::_('COM_IPROPERTY_COMPANY_PARAMETERS'); ?></legend>
                    <?php foreach($this->form->getFieldset('admin_params') as $field) :?>
                        <div class="formelm"><?php echo $field->label; ?>
                        <?php echo $field->input; ?></div>
                    <?php endforeach; ?>
                </fieldset>                
        <?php endif; ?>
        <?php echo JHtml::_('tabs.end'); ?>
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="return" value="<?php echo $this->return_page;?>" />
        <?php echo JHtml::_( 'form.token' ); ?>
    </form>
</div>