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
<table cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>
        <td valign="top" width="20%" class="ip_cpanel_toolbar">
            <?php echo ipropertyAdmin::buildAdminToolbar(); ?>
        </td>
        <td valign="top" width="80%" class="ip_cpanel_display">
            <form action="<?php echo JRoute::_('index.php?option=com_iproperty'); ?>" method="post" name="adminForm" id="adminForm">
                <table class="adminlist" cellspacing="1">
                    <thead>
                        <tr>
                            <th><?php echo JText::_( 'COM_IPROPERTY_SELECT_CSS' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <?php echo $this->cssList; ?>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </tfoot>
                </table>
                <?php echo JHTML::_( 'form.token' ); ?>
                <input type="hidden" name="task" value="" />
            </form>
            <p class="copyright"><?php echo ipropertyAdmin::footer(); ?></p>
        </td>
    </tr>
</table>