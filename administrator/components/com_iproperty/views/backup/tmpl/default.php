<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */
 
defined('_JEXEC') or die('Restricted access');
?>

<table cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>
        <td valign="top" width="20%" class="ip_cpanel_toolbar">
            <?php ipropertyAdmin::buildAdminToolbar(); ?>
        </td>
        <td valign="top" width="80%" class="ip_cpanel_display">
            <form action="<?php echo JRoute::_('index.php?option=com_iproperty&view=backup'); ?>" method="post" name="adminForm" id="iproperty-form">
                <table class="adminform" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td>
                            <div style="padding: 10px;">
                                <?php echo JText::_( 'COM_IPROPERTY_BACKUP_CONFIRM' ); ?>
                            </div>
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="task" value="" />
                <?php echo JHtml::_('form.token'); ?>
            </form>
            <div class="clr"></div>
            <p class="copyright"><?php echo ipropertyAdmin::footer( ); ?></p>
       </td>
    </tr>
</table>