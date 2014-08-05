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
<h1 class="ip_cpanel_header"><?php echo JText::_('COM_IPROPERTY_THINKERY_NEWS'); ?></h1>
<div class="tnews_content">
    <table class="adminlist" cellspacing="1">
        <thead>
            <tr>
                <th width="100%"><?php echo JText::_('COM_IPROPERTY_THINKERY_NEWS'); ?></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </tfoot>
        <tbody>
        <?php
            $limit                  = 5;
            $options                = array();
            $options['rssUrl']      = 'http://extensions.thethinkery.net/index.php?format=feed&type=rss';
            $options['cache_time']  = '86400';

            $rss        = JFactory::getXMLParser('RSS', $options);
            $cntItems   = $rss ? $rss->get_item_quantity() : false;

            $k = 0;
            if( !$cntItems ) {
                echo '<tr class="row'.$k.'" style="text-align: center !important;"><td>'.JText::_( 'COM_IPROPERTY_NO_THINK_NEWS' ).'</td></tr>';
            }else{
                $cntItems = ($cntItems > $limit) ? $limit : $cntItems;
                for( $j = 0; $j < $cntItems; $j++ ){
                    $item           = $rss->get_item($j);
                    $description    = ipropertyHTML::snippet($item->get_description(), 1000);
                    echo '
                    <tr class="row'.$k.'"><td class="ip_newstitle"><a href="'.$item->get_link().'" target="_blank">'.$item->get_title().'</a></td></tr>
                    <tr class="row'.$k.'"><td class="ip_newsdesc">'.$description.'</td></tr>';
                    $k = 1 - $k;
                }
            }
        ?>
        </tbody>
    </table>
</div>