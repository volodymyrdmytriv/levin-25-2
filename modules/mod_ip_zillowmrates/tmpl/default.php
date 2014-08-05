<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Iproperty
 * @copyright (C) 2013 the Thinkery
 * @license see LICENSE.php
 */
 
defined('_JEXEC') or die('Restricted access'); 
$todayRates = $Mrates['today'];
$lastweekRates = $Mrates['lastWeek'];
?>
<strong><?php echo JText::_('TODAY RATE'); ?></strong>
<ul class="<?php echo $params->get('menuclass_sfx'); ?>">
    <li><strong><?php echo JText::_('MOD_IP_ZILLOW_30_FIXED'); ?>:</strong> <?php echo $todayRates['thirtyYearFixed']; ?>%</li>
    <li><strong><?php echo JText::_('MOD_IP_ZILLOW_15_FIXED'); ?>:</strong> <?php echo $todayRates['fifteenYearFixed']; ?>%</li>
    <li><strong><?php echo JText::_('MOD_IP_ZILLOW_51_ARM'); ?>:</strong> <?php echo $todayRates['fiveOneARM']; ?>%</li>
</ul>

<strong><?php echo JText::_('MOD_IP_ZILLOW_LAST_WEEK_RATE'); ?></strong>
<ul class="<?php echo $params->get('menuclass_sfx'); ?>">
    <li><strong><?php echo JText::_('MOD_IP_ZILLOW_30_FIXED'); ?>:</strong> <?php echo $lastweekRates['thirtyYearFixed']; ?>%</li>
    <li><strong><?php echo JText::_('MOD_IP_ZILLOW_15_FIXED'); ?>:</strong> <?php echo $lastweekRates['fifteenYearFixed']; ?>%</li>
    <li><strong><?php echo JText::_('MOD_IP_ZILLOW_51_ARM'); ?>:</strong> <?php echo $lastweekRates['fiveOneARM']; ?>%</li>
</ul>

<div align="center">
	<?php echo JText::_('MOD_IP_ZILLOW_PROVIDED_BY'); ?>
    <a href="http://www.zillow.com" target="_blank"><img src="<?php echo JURI::root(true); ?>/modules/mod_ip_zillowmrates/zillow_logo.gif" align="middle" border="0" alt="Zillow" /></a>
</div>