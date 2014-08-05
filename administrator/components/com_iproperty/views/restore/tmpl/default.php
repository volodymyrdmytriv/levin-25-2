<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
?>
<table cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>
        <td valign="top" width="20%" class="ip_cpanel_toolbar">
            <?php ipropertyAdmin::buildAdminToolbar(); ?>
        </td>
        <td valign="top" width="80%" class="ip_cpanel_display">            
            <form action="<?php echo JRoute::_('index.php?option=com_iproperty'); ?>" method="post" name="adminForm" id="adminForm">                
                <table class="adminform" width="100%">
                    <tr>
                        <td>
                            <div class="ip_warning"><?php echo JText::_( 'COM_IPROPERTY_THIS_OPERATION_IS_UNDOABLE' );?></div>
                            <?php echo JText::_( 'COM_IPROPERTY_BACKUP_FILE_TO_RESTORE_FROM' ); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <fieldset class="adminform">
                            <legend><?php echo JText::_( 'COM_IPROPERTY_RESTORE_FROM_BACKUP_COPY' ); ?></legend>
                                <ul class="adminformlist">
                                    <li>
                                        <label><?php echo JText::_( 'COM_IPROPERTY_BACKUP' ); ?></label>
                                        <?php echo $this->backupFiles; ?>
                                    </li>
                                </ul>
                            </fieldset>
                            <fieldset class="adminform">
                            <legend><?php echo JText::_('COM_IPROPERTY_DB_PREFIX'); ?> - <span style="color: #ff0000;"><?php echo JText::_('COM_IPROPERTY_IMPORTANT'); ?></span></legend>
                                <ul class="adminformlist">
                                    <li><label class="hasTip" title="<?php echo JText::_('COM_IPROPERTY_DB_PREFIX'); ?> :: <?php echo JText::_('COM_IPROPERTY_DB_PREFIX_TIP'); ?>"><?php echo JText::_('COM_IPROPERTY_DB_PREFIX'); ?></label>
                                        <input type="text" name="bak_prefix" value="" class="inputbox" />
                                    </li>
                                </ul>
                            </fieldset>
                        </td>
                    </tr>
                </table>
                <?php echo JHTML::_( 'form.token' ); ?>
                <input type="hidden" name="task" value="" />
            </form>
            <p class="copyright"><?php echo ipropertyAdmin::footer( ); ?></p>
        </td>
    </tr>
</table>