<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Iproperty
 * @copyright (C) 2013 the Thinkery
 * @license see LICENSE.php
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
?>
<div class="ip_openhousemod<?php echo $moduleclass_sfx; ?>">
    <ul class="ipohmod<?php echo $params->get('ul_class'); ?>">
        <?php
        for($i=0; $i < sizeof($list); $i++){
            echo '<li class="ipohmodli'.$params->get('li_class').'">';
                    if($list[$i]->name) echo '<div class="ipoh_title">'.$list[$i]->name.'</div>';
                    echo '<a href="'.$list[$i]->link.'">'.$list[$i]->street_address.'</a>';
                    echo '<br />'.$list[$i]->start;
                    echo '<br /><b>'.JText::_('MOD_IP_OPENHOUSES_THROUGH').'</b>';
                    echo '<br />'.$list[$i]->end;
            echo '</li>';
        }
        ?>
    </ul>
</div>