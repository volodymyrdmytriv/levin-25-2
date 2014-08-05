<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */
 
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.formvalidation');
?>

<form action="<?php JRoute::_('index.php?option=com_iproperty&view=bulkimport'); ?>" method="post" name="adminForm" id="iproperty-form" class="form-validate">
    <table cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td valign="top" width="20%" class="ip_cpanel_toolbar">
                <?php ipropertyAdmin::buildAdminToolbar(); ?>
            </td>
            <td valign="top" width="80%" class="ip_cpanel_display">
                <div class="ip_warning"><?php echo JText::_( 'COM_IPROPERTY_BULKIMPORT_WARNING' );?></div>
                <div class="width-60 fltlft">
                    <fieldset class="adminform">
                        <legend><?php echo JText::_( 'COM_IPROPERTY_BULKIMPORT_FILE' ); ?></legend>
                        <ul class="adminformlist">
                            <li><?php echo JText::_( 'COM_IPROPERTY_BULKIMPORT_FILE' ); ?></li>
                            <li><label for="csv file"><?php echo JText::_( 'COM_IPROPERTY_FILE_TO_IMPORT' ); ?></label>
                                <?php echo $this->dataFiles; ?>
                            </li>                                
                        </ul>
                    </fieldset>
                </div>
                <div class="width-40 fltlft">
                    <fieldset class="adminform">
                        <legend><?php echo JText::_( 'COM_IPROPERTY_DETAILS' ); ?></legend>
                            <ul class="adminformlist">
                                <li>
                                    <label for="dump db"><?php echo JText::_( 'COM_IPROPERTY_DUMP_DATABASE' ).':'; ?></label>
                                    <fieldset class="iputbox radio"><?php echo JHTML::_('select.booleanlist', 'empty', 'class="inputbox"', ''); ?></fieldset>
                                </li>
                                <li>
                                    <label for="debug"><?php echo JText::_( 'COM_IPROPERTY_DEBUG_LOG' ).':'; ?></label>
                                    <fieldset class="iputbox radio"><?php echo JHTML::_('select.booleanlist', 'debug', 'class="inputbox"', '1'); ?></fieldset>
                                </li>
                                <li>
                                    <label for="img_path"><?php echo JText::_( 'COM_IPROPERTY_IMAGE_PATH' ); ?>:</label>
                                    <input type="text" name="img_path" value="media/com_iproperty" size="40" class="inputbox" />
                                </li>
                            </ul>
                    </fieldset>
                </div>
                <div class="clear"></div>
                <p class="copyright"><?php echo ipropertyAdmin::footer( ); ?></p>
            </td>
        </tr>
    </table>
    <input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>