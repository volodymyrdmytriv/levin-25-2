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
?>

<script language="javascript" type="text/javascript">
    <?php
    if ($this->item->id != 0) {
        echo "window.addEvent('domready', function() {
            var parentList = document.getElementById('jform_parent');
            for (i = parentList.length - 1; i>=0; i--) {
                if (parentList.options[i].value == ".$this->item->id.") {
                    parentList.remove(i);
                }
            }
            $('jform_parent').getElements('options[value=".$this->item->id."]').dispose();
        });";
    }
    ?>
    Joomla.submitbutton = function(task)
	{
		if (task == 'category.cancel' || document.formvalidator.isValid(document.id('iproperty-form'))) {
            <?php echo $this->form->getField('desc')->save(); ?>
            Joomla.submitform(task, document.getElementById('iproperty-form'));
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_iproperty&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="iproperty-form" class="form-validate">
    <div class="width-60 fltlft">
		<fieldset class="adminform">
            <legend><?php echo JText::_('COM_IPROPERTY_DETAILS'); ?></legend>
            <div class="width-50 fltlft">                
                <ul class="adminformlist">
                    <li><?php echo $this->form->getLabel('parent'); ?>
                    <?php echo $this->form->getInput('parent'); ?></li>
                    <li><?php echo $this->form->getLabel('ordering'); ?>
                    <?php echo $this->form->getInput('ordering'); ?></li>
                    <li><?php echo $this->form->getLabel('title'); ?>
                    <?php echo $this->form->getInput('title'); ?></li>
                    <li><?php echo $this->form->getLabel('alias'); ?>
                    <?php echo $this->form->getInput('alias'); ?></li>
                </ul>
            </div>
            <div class="clr" style="height: 10px;"></div>
            <?php echo $this->form->getLabel('iphead1'); ?>
            <div class="clr"></div>
            <?php echo $this->form->getInput('desc'); ?>
        </fieldset>
    </div>
    <div class="width-40 fltrt">
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_IPROPERTY_IMAGE'); ?></legend>
            <ul class="adminformlist">
                <li><?php echo $this->form->getInput('icon'); ?></li>
            </ul>
        </fieldset>
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_IPROPERTY_PUBLISHING'); ?></legend>
            <ul class="adminformlist">
                <li><?php echo $this->form->getLabel('access'); ?>
                <?php echo $this->form->getInput('access'); ?></li>
                <li><?php echo $this->form->getLabel('state'); ?>
                <?php echo $this->form->getInput('state'); ?></li>
                <li><?php echo $this->form->getLabel('publish_up'); ?>
                <?php echo $this->form->getInput('publish_up'); ?></li>
                <li><?php echo $this->form->getLabel('publish_down'); ?>
                <?php echo $this->form->getInput('publish_down'); ?></li>
            </ul>
        </fieldset>
    </div>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
<div class="clr"></div>
<p class="copyright"><?php echo ipropertyAdmin::footer( ); ?></p>