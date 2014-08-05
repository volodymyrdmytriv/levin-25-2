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

<form action="<?php echo JRoute::_('index.php?option=com_iproperty&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="iproperty-form" class="form-validate">
    <div class="width-60 fltlft">
		<fieldset class="adminform">
            <legend><?php echo JText::_('COM_IPROPERTY_DETAILS'); ?></legend>
            <div class="fltlft">                
                <ul class="adminformlist">
                    <li><?php echo $this->form->getLabel('name'); ?>
                    <?php echo $this->form->getInput('name'); ?></li>
                    <li><?php echo $this->form->getLabel('prop_id'); ?>
                    <?php echo $this->form->getInput('prop_id'); ?></li>
                    <li><?php echo $this->form->getLabel('openhouse_start'); ?>
                    <?php echo $this->form->getInput('openhouse_start'); ?></li>
                    <li><?php echo $this->form->getLabel('openhouse_end'); ?>
                    <?php echo $this->form->getInput('openhouse_end'); ?></li>
                    <li><?php echo $this->form->getLabel('comments'); ?>
                    <?php echo $this->form->getInput('comments'); ?></li>
                </ul>
            </div>
        </fieldset>
    </div>
    <div class="width-40 fltlft">
        <fieldset class="adminform">
        <legend><?php echo JText::_( 'COM_IPROPERTY_PUBLISHING' ); ?></legend>
            <ul class="adminformlist">
                <li><?php echo $this->form->getLabel('state'); ?>
                <?php echo $this->form->getInput('state'); ?></li>                    
            </ul>
        </fieldset>
    </div>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
<div class="clr"></div>
<p class="copyright"><?php echo ipropertyAdmin::footer( ); ?></p>