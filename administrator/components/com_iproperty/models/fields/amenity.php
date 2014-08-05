<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');

class JFormFieldAmenity extends JFormField
{
    protected $type = 'Amenity';

	protected function getInput()
	{
		$document = JFactory::getDocument();
        $document->addScript('components/com_iproperty/assets/js/addInput.js');
        ?>
        <p><?php echo JText::_( 'COM_IPROPERTY_AMENITY_DESC' ); ?></p>
        <div id="parah"></div>
        <div class="clear"></div>
        <div class="parah_controls">
            <div class="parah_text">-- <?php echo JText::_( 'COM_IPROPERTY_CLICK_BELOW' ); ?> --</div>
            <?php echo JHtml::_('image.administrator','remove.png', 'components/com_iproperty/assets/images/',null,'','Remove','onclick="deleteInput();"'); ?>
            <?php echo JHtml::_('image.administrator','add.png', 'components/com_iproperty/assets/images/',null,'','Add','onclick="addInput();"'); ?>
        </div>
        <?php
	}
}


