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
<h1 class="ip_cpanel_header"><?php echo JText::_( 'COM_IPROPERTY_TOOLS' ); ?></h1>
<div class="tnews_content">
    <table class="adminlist" cellspacing="1">
        <thead>
            <tr>
                <th width="100%"><?php echo JText::_( 'COM_IPROPERTY_TOOLS' ); ?></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </tfoot>
        <tbody>
            <tr class="row0">
                <td>
                    <div id="cpanel">
                        <?php $this->dispatcher->trigger( 'onAfterRenderTools', array( $this->user, $this->settings ) ); ?>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>