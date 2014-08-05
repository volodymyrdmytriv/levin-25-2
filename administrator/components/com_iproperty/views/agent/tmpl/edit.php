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
?>

<script language="javascript" type="text/javascript">
    Joomla.submitbutton = function(task)
	{
		if (task == 'agent.cancel' || document.formvalidator.isValid(document.id('iproperty-form'))) {
			<?php echo $this->form->getField('bio')->save(); ?>
            Joomla.submitform(task, document.getElementById('iproperty-form'));
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}

    checkAgentUser = function(){
        $('message').set('tween', {duration: 4500});
        var checkurl = '<?php echo JURI::base('true'); ?>/index.php?option=com_iproperty&task=ajax.checkUserAgent';
        var attachedUser = $('jform_user_id_id').value;
        
        req = new Request({
            method: 'post',
            url: checkurl,
            data: { 'user_id': attachedUser,
                    'agent_id': <?php echo (int) $this->item->id; ?>,
                    '<?php echo JUtility::getToken(); ?>':'1',
                    'format': 'raw'},
            onRequest: function() {
                $('message').set('html', '');
            },
            onSuccess: function(response) {
                if(response){
                    $('message').highlight('#ff0000');
                    $('jform_user_id_id').value = '';
                    $('jform_user_id_name').value = '';
                    $('message').set('html', '<div class="ip_warning"><?php echo JText::_('COM_IPROPERTY_AGENT_USER_ALREADY_EXISTS'); ?></div>');                    
                }
            }
        }).send();
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_iproperty&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="iproperty-form" class="form-validate">
    <div class="width-60 fltlft">
		<fieldset class="adminform">
            <legend><?php echo JText::_('COM_IPROPERTY_DETAILS'); ?></legend>
            <div class="width-50 fltlft">                
                <ul class="adminformlist">
                    <li><?php echo $this->form->getLabel('fname'); ?>
                    <?php echo $this->form->getInput('fname'); ?></li>
                    <li><?php echo $this->form->getLabel('lname'); ?>
                    <?php echo $this->form->getInput('lname'); ?></li>
                    <li><?php echo $this->form->getLabel('title'); ?>
                    <?php echo $this->form->getInput('title'); ?></li>
                    <li><?php echo $this->form->getLabel('alias'); ?>
                    <?php echo $this->form->getInput('alias'); ?></li>
                    <li><?php echo $this->form->getLabel('company'); ?>
                    <?php echo $this->form->getInput('company'); ?></li>
                    <li><?php echo $this->form->getLabel('email'); ?>
                    <?php echo $this->form->getInput('email'); ?></li>
                    <li><?php echo $this->form->getLabel('phone'); ?>
                    <?php echo $this->form->getInput('phone'); ?></li>
                    <li><?php echo $this->form->getLabel('mobile'); ?>
                    <?php echo $this->form->getInput('mobile'); ?></li>
                    <li><?php echo $this->form->getLabel('fax'); ?>
                    <?php echo $this->form->getInput('fax'); ?></li>
                    <li><?php echo $this->form->getLabel('alicense'); ?>
                    <?php echo $this->form->getInput('alicense'); ?></li>
                </ul>
            </div>
            <div class="width-50 fltrt">
                <ul class="adminformlist">
                    <li><?php echo $this->form->getLabel('street'); ?>
                    <?php echo $this->form->getInput('street'); ?></li>
                    <li><?php echo $this->form->getLabel('street2'); ?>
                    <?php echo $this->form->getInput('street2'); ?></li>
                    <li><?php echo $this->form->getLabel('city'); ?>
                    <?php echo $this->form->getInput('city'); ?></li>
                    <li><?php echo $this->form->getLabel('locstate'); ?>
                    <?php echo $this->form->getInput('locstate'); ?></li>
                    <li><?php echo $this->form->getLabel('province'); ?>
                    <?php echo $this->form->getInput('province'); ?></li>
                    <li><?php echo $this->form->getLabel('postcode'); ?>
                    <?php echo $this->form->getInput('postcode'); ?></li>
                    <li><?php echo $this->form->getLabel('country'); ?>
                    <?php echo $this->form->getInput('country'); ?></li>
                </ul>
            </div>
            <div class="clr" style="height: 10px;"></div>
            <?php echo $this->form->getLabel('iphead1'); ?>
            <div class="clr"></div>
            <?php echo $this->form->getInput('bio'); ?>
        </fieldset>
    </div>
    <div class="width-40 fltrt">
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_IPROPERTY_IMAGE'); ?></legend>
            <ul class="adminformlist">
                <?php echo $this->form->getInput('icon'); ?>
            </ul>
        </fieldset>       
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_IPROPERTY_WEB'); ?></legend>
            <ul class="adminformlist">
                <li><?php echo $this->form->getLabel('website'); ?>
                <?php echo $this->form->getInput('website'); ?></li>
                <li><?php echo $this->form->getLabel('msn'); ?>
                <?php echo $this->form->getInput('msn'); ?></li>
                <li><?php echo $this->form->getLabel('skype'); ?>
                <?php echo $this->form->getInput('skype'); ?></li>
                <li><?php echo $this->form->getLabel('gtalk'); ?>
                <?php echo $this->form->getInput('gtalk'); ?></li>
                <li><?php echo $this->form->getLabel('linkedin'); ?>
                <?php echo $this->form->getInput('linkedin'); ?></li>
                <li><?php echo $this->form->getLabel('facebook'); ?>
                <?php echo $this->form->getInput('facebook'); ?></li>
                <li><?php echo $this->form->getLabel('twitter'); ?>
                <?php echo $this->form->getInput('twitter'); ?></li>
                <li><?php echo $this->form->getLabel('social1'); ?>
                <?php echo $this->form->getInput('social1'); ?></li>
            </ul>
        </fieldset>
        <!-- super agent or admin can edit params -->
        <?php if ($this->ipauth->getAdmin() || $this->ipauth->getSuper()): ?>
            <fieldset class="adminform">
                <legend><?php echo JText::_('COM_IPROPERTY_PUBLISHING'); ?></legend>
                <ul class="adminformlist">
                    <li><?php echo $this->form->getLabel('state'); ?>
                    <?php echo $this->form->getInput('state'); ?></li>
                    <li><?php echo $this->form->getLabel('featured'); ?>
                    <?php echo $this->form->getInput('featured'); ?></li>                    
                </ul>
            </fieldset>
            <fieldset class="adminform superagent_params">
                <legend><?php echo JText::_('COM_IPROPERTY_AGENT_PARAMETERS'); ?></legend>
                <ul class="adminformlist">
                    <?php foreach($this->form->getFieldset('superagent_params') as $field) :?>
                        <li><?php echo $field->label; ?>
                        <?php echo $field->input; ?></li>
                    <?php endforeach; ?>
                </ul>
            </fieldset>
        <?php endif; ?>
        <!-- only admin can set agent to super agent level -->
        <?php if ($this->ipauth->getAdmin()): ?>
            <fieldset class="adminform admin_params">
                <legend><?php echo JText::_('JADMINISTRATION'); ?></legend>
                <div id="message"></div>
                <ul class="adminformlist">
                    <li><?php echo $this->form->getLabel('user_id'); ?>
                    <?php echo $this->form->getInput('user_id'); ?></li>
                    <li><?php echo $this->form->getLabel('agent_type'); ?>
                    <?php echo $this->form->getInput('agent_type'); ?></li>
                </ul>
            </fieldset>
        <?php endif; ?>
    </div>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
<div class="clr"></div>
<p class="copyright"><?php echo ipropertyAdmin::footer( ); ?></p>