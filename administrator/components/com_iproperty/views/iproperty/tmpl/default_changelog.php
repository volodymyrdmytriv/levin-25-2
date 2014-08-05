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
<h1 class="ip_cpanel_header"><?php echo JText::_( 'COM_IPROPERTY_CHANGE_LOG' ); ?></h1>
<div class="tnews_content">
    <table class="adminlist" cellspacing="1">
        <thead>
            <tr>
                <th width="100%"><?php echo JText::_( 'COM_IPROPERTY_CHANGE_LOG' ); ?></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </tfoot>
        <tbody>
        <?php
            $logfile        = JPATH_COMPONENT_ADMINISTRATOR.DS.'assets'.DS.'CHANGELOG.TXT';
            if(JFile::exists($logfile)){
                $logcontent     = JFile::read($logfile);
                $logcontent     = htmlspecialchars($logcontent, ENT_COMPAT, 'UTF-8');
            }else{
                $logcontent     = '';
            }

            if( !$logcontent ) {
                echo '<tr class="row0" style="text-align: center !important;"><td>'.JText::_( 'COM_IPROPERTY_NO_CHANGELOG' ).'</td></tr>';
            }else{
                echo '<tr class="row0"><td><pre>'.$logcontent.'</pre></td></tr>';
            }
        ?>
        </tbody>
    </table>
</div>