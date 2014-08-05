<?php
/**
 * Install File
 * Does the stuff for the specific extensions
 *
 * @package         Tooltips
 * @version         2.2.1
 *
 * @author          Peter van Westen <peter@nonumber.nl>
 * @link            http://www.nonumber.nl
 * @copyright       Copyright © 2012 NoNumber All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

$name = 'Tooltips';
$alias = 'tooltips';
$ext = $name . ' (editor button & system plugin)';

// EDITOR BUTTON PLUGIN
$states[] = installExtension($states, $alias, 'System - ' . $name, 'plugin');
$states[] = installExtension($states, $alias, 'Editor Button - ' . $name, 'plugin', array('folder' => 'editors-xtd'));
