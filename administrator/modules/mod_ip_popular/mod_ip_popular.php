<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Iproperty
 * @copyright (C) 2013 the Thinkery
 * @license see LICENSE.php
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_iproperty'.DS.'classes'.DS.'admin.class.php');

$db = JFactory::getDbo();

// Filter by start and end dates.
$nullDate   = $db->Quote($db->getNullDate());
$date       = JFactory::getDate();
$nowDate    = $db->Quote($date->toSql());

$query = $db->getQuery(true);
$query->select('id, hits, title, created, CONCAT_WS(" ", street_num, street, street2) AS street_address')
        ->from('#__iproperty')
        ->where('state = 1')
        ->where('(publish_up = '.$nullDate.' OR publish_up <= '.$nowDate.')')
        ->where('(publish_down = '.$nullDate.' OR publish_down >= '.$nowDate.')')
        ->order('hits DESC');

$db->setQuery($query, 0, 10);
$rows = $db->loadObjectList();
?>

<table class="adminlist">
    <thead>
        <tr>
            <th><strong><?php echo JText::_( 'MOD_IP_POPADMIN_POPULAR' ); ?></strong></th>
            <th><strong><?php echo JText::_( 'MOD_IP_POPADMIN_CREATED' ); ?></strong></th>
            <th><strong><?php echo JText::_( 'MOD_IP_POPADMIN_HITS' ); ?></strong></th>
        </tr>
    </thead>
    <tbody>
    <?php
    if(count($rows) > 0){
        foreach ($rows as $row)
        {
            $link = JRoute::_('index.php?option=com_iproperty&task=property.edit&amp;id='.$row->id);
            ?>
            <tr>
                <td>
                    <a href="<?php echo $link; ?>"><?php echo htmlspecialchars($row->street_address, ENT_QUOTES, 'UTF-8');?></a>
                    <?php if($row->title) echo '<br />'.$row->title; ?>
                </td>
                <td><?php echo JHTML::_('date', $row->created, 'Y-m-d'); ?></td>
                <td><?php echo $row->hits;?></td>
            </tr>
            <?php
        }
    }else{
        echo '<tr><td colspan="3" style="text-align: center;">'.JText::_('MOD_IP_POPADMIN_NORESULTS').'</td></tr>';
    }
    ?>
    </tbody>
</table>