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

<div class="ip_spacer"></div>
<h1 class="ip_cpanel_header"><?php echo JText::_( 'COM_IPROPERTY_HELP' ); ?></h1>
<div class="tnews_content">
    <table class="adminlist" cellspacing="1">
        <thead>
            <tr>
                <th width="100%"><?php echo JText::_( 'COM_IPROPERTY_HELP' ); ?></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="6">
                    &nbsp;
                </td>
            </tr>
        </tfoot>
        <tbody>
            <tr class="row0" style="text-align: center !important;">
                <td valign="top"><p><?php echo JHTML::_('image', 'administrator/components/com_iproperty/assets/images/iproperty_admin_logo.gif', 'Intellectual Property :: By The Thinkery' ); ?></p></td>
            </tr>
            <tr class="row0" style="text-align: center !important;">
                <td valign="top"><p><?php echo sprintf(JText::_( 'COM_IPROPERTY_IP_HELP_DESC' ), 'http://extensions.thethinkery.net'); ?></p></td>
            </tr>
        </tbody>
    </table>
</div>