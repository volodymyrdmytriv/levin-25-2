<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Iproperty
 * @copyright (C) 2013 the Thinkery
 * @license see LICENSE.php
 */

// No direct access.
defined('_JEXEC') or die;

$buttons = modIpQuickIconHelper::getButtons();
?>
<div id="cpanel">
    <?php
    foreach ($buttons as $button):
        echo modIpQuickIconHelper::button($button);
    endforeach;
    ?>
</div>
