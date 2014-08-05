<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<form action="<?php echo JRoute::_('index.php?option=com_iproperty&layout=add&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="iproperty-form" class="form-validate">
    <div class="width-60 fltlft">
		<fieldset class="adminform">
            <legend><?php echo JText::_('COM_IPROPERTY_AMENITIES'); ?></legend>
            <ul class="adminformlist">
                <li><?php echo $this->form->getInput('amenlist'); ?></li>
            </ul>
        </fieldset>
    </div>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
<div class="clr"></div>
<p class="copyright"><?php echo ipropertyAdmin::footer( ); ?></p>