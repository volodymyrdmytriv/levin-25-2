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

<div class="ip_related<?php echo $moduleclass_sfx; ?>">
    <ul class="<?php echo $ul_class; ?>">
        <?php
            foreach($list as $p) {
                echo '<li class="'.$li_class.'"><a href="' . $p->link . '">'.$p->street_address.'</a></li>';
            }
         ?>
    </ul>
</div>