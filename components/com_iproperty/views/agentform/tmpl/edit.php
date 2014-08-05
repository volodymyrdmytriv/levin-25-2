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
	
		if (task == 'agentform.cancel'){
            <?php echo $this->form->getField('bio')->save(); ?>
			Joomla.submitform(task);
        }else if(document.formvalidator.isValid(document.id('adminForm'))) {
            <?php if($this->ipauth->getAdmin()): //only confirm company if admin user ?>
                if(document.id('jform_company').selectedIndex == ''){
                    alert('Please select a company!');
                    return false;
                }
            <?php endif; ?>
			<?php echo $this->form->getField('bio')->save(); ?>
			Joomla.submitform(task);
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}

    checkAgentEmail = function(){
        document.id('system-message-container').set('tween', {duration: 4500});
        var checkurl = '<?php echo JURI::base('true'); ?>/index.php?option=com_iproperty&task=ajax.checkUserEmail';
        var agentEmail = document.id('jform_email').value;
        
        req = new Request({
            method: 'post',
            url: checkurl,
            data: { 'email': agentEmail,
                    'agent_id': <?php echo (int) $this->item->id; ?>,
                    '<?php echo JUtility::getToken(); ?>':'1',
                    'format': 'raw'},
            onRequest: function() {
                document.id('system-message-container').set('html', '');
            },
            onSuccess: function(response) {
                if(response){
                    document.id('system-message-container').highlight('#ff0000');
                    document.id('jform_email').value = '';
                    document.id('jform_email').set('class', 'inputbox invalid');
                    document.id('jform_email').focus();
                    document.id('system-message-container').set('html', '<div class="ip_warning"><?php echo JText::_('COM_IPROPERTY_AGENT_EMAIL_ALREADY_EXISTS'); ?></div>');                    
                }
            }
        }).send();
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
    
    <div id="system-message-container"></div>

    <form action="<?php echo JRoute::_('index.php?option=com_iproperty&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate ipform">
        <div class="formelm-buttons">
            <button type="button" onclick="Joomla.submitbutton('agentform.apply')">
                <?php echo JText::_('COM_IPROPERTY_APPLY') ?>
            </button>
            <button type="button" onclick="Joomla.submitbutton('agentform.save')">
                <?php echo JText::_('JSAVE') ?>
            </button>
            <button type="button" onclick="Joomla.submitbutton('agentform.cancel')">
                <?php echo JText::_('JCANCEL') ?>
            </button>
        </div>
        <?php
        echo JHtml::_('tabs.start', 'agent_tabs', array('useCookie' => false));
        echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_DETAILS' ), 'details_panel');
        ?>
        <div class="ip_spacer"></div>
        <div class="width-100">
            <fieldset>
                <legend><?php echo JText::_('COM_IPROPERTY_DETAILS'); ?></legend>
                <div class="formelm">
                    <?php echo $this->form->getLabel('fname'); ?>
                    <?php echo $this->form->getInput('fname'); ?>
                </div>
                <div class="formelm">
                    <?php echo $this->form->getLabel('lname'); ?>
                    <?php echo $this->form->getInput('lname'); ?>
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
                <?php if($this->ipauth->getAdmin()): //only show company if admin user ?>
                    <div class="formelm"><?php echo $this->form->getLabel('company'); ?>
                    <?php echo $this->form->getInput('company'); ?></div>
                <?php elseif($this->form->getValue('company')): //if not admin and company already set, leave it as a hidden field ?>
                    <div class="formelm"><?php echo $this->form->getLabel('company'); ?>
                    <?php echo ipropertyHTML::getCompanyName($this->form->getValue('company')); ?></div>
                    <input type="hidden" name="jform[company]" value="<?php echo $this->form->getValue('company'); ?>" />
                <?php else: ?>
                    <input type="hidden" name="jform[company]" value="<?php echo $this->ipauth->getUagentCid(); ?>" />
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
                    <?php echo $this->form->getLabel('mobile'); ?>
                    <?php echo $this->form->getInput('mobile'); ?>
                </div>
                <div class="formelm">
                    <?php echo $this->form->getLabel('fax'); ?>
                    <?php echo $this->form->getInput('fax'); ?>
                </div>
                <div class="formelm">
                    <?php echo $this->form->getLabel('alicense'); ?>
                    <?php echo $this->form->getInput('alicense'); ?>
                </div>
            </fieldset>
            <fieldset>
                <legend><?php echo JText::_('COM_IPROPERTY_ADDRESS'); ?></legend>
                <div class="formelm">
                    <?php echo $this->form->getLabel('street'); ?>
                    <?php echo $this->form->getInput('street'); ?>
                </div>
                <div class="formelm">
                    <?php echo $this->form->getLabel('street2'); ?>
                    <?php echo $this->form->getInput('street2'); ?>
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
                <div class="formelm">
                    <?php echo $this->form->getLabel('msn'); ?>
                    <?php echo $this->form->getInput('msn'); ?>
                </div>
                <div class="formelm">
                    <?php echo $this->form->getLabel('skype'); ?>
                    <?php echo $this->form->getInput('skype'); ?>
                </div>
                <div class="formelm">
                    <?php echo $this->form->getLabel('gtalk'); ?>
                    <?php echo $this->form->getInput('gtalk'); ?>
                </div>
                <div class="formelm">
                    <?php echo $this->form->getLabel('twitter'); ?>
                    <?php echo $this->form->getInput('twitter'); ?>
                </div>
                <div class="formelm">
                    <?php echo $this->form->getLabel('social1'); ?>
                    <?php echo $this->form->getInput('social1'); ?>
                </div>
            </fieldset>
        </div>
        <?php echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_IMAGE' ).'/'.JText::_('COM_IPROPERTY_AGENT_BIO'), 'img_panel');?> 
        <div class="ip_spacer"></div>
        <div class="width-100">
            <fieldset>
                <legend><?php echo JText::_('COM_IPROPERTY_IMAGE'); ?></legend>
                <div class="formelm">
                    <?php echo $this->form->getInput('icon'); ?>
                </div>
            </fieldset>
            <fieldset>
                <legend><?php echo JText::_('COM_IPROPERTY_AGENT_BIO'); ?></legend>
                <div class="formelm">
                    <?php echo $this->form->getLabel('iphead1'); ?>
                    <div class="clr"></div>
                    <?php echo $this->form->getInput('bio'); ?>
                </div>            
            </fieldset>
        </div>  
        <!-- super agent or admin can edit params -->
        <?php if ($this->ipauth->getAdmin() || $this->ipauth->getSuper()): 
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
                <fieldset class="adminform superagent_params">
                    <legend><?php echo JText::_('COM_IPROPERTY_AGENT_PARAMETERS'); ?></legend>
                    <?php foreach($this->form->getFieldset('superagent_params') as $field) :?>
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