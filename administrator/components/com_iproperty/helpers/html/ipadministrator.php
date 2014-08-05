<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die;

abstract class JHtmlIpAdministrator
{
	static function featured($value = 0, $i, $canChange = true, $controller = false)
	{
		if(!$controller) return;
        
        // Array of image, task, title, action
		$states	= array(
			0	=> array('disabled.png',	$controller.'.feature',	'COM_IPROPERTY_UNFEATURED',	'COM_IPROPERTY_FEATURE'),
			1	=> array('featured.png',	$controller.'.unfeature',	'COM_IPROPERTY_FEATURED',		'COM_IPROPERTY_UNFEATURE'),
		);
		$state	= JArrayHelper::getValue($states, (int) $value, $states[1]);
		$html	= JHtml::_('image','admin/'.$state[0], JText::_($state[2]), NULL, true);
		if ($canChange) {
			$html	= '<a href="#" onclick="return listItemTask(\'cb'.$i.'\',\''.$state[1].'\')" title="'.JText::_($state[3]).'">'.$html.'</a>';
		}

		return $html;
	}

    static function super($value = 0, $i, $canChange = true, $controller = false)
	{
		if(!$controller) return;

        // Array of image, task, title, action
		$states	= array(
			0	=> array('disabled.png',	$controller.'.super',	'COM_IPROPERTY_UNSUPER',	'COM_IPROPERTY_SUPER'),
			1	=> array('featured.png',	$controller.'.unsuper',	'COM_IPROPERTY_SUPER',		'COM_IPROPERTY_UNSUPER'),
		);
		$state	= JArrayHelper::getValue($states, (int) $value, $states[1]);
		$html	= JHtml::_('image','admin/'.$state[0], JText::_($state[2]), NULL, true);
		if ($canChange) {
			$html	= '<a href="#" onclick="return listItemTask(\'cb'.$i.'\',\''.$state[1].'\')" title="'.JText::_($state[3]).'">'.$html.'</a>';
		}

		return $html;
	}
    
    static function approved($value = 0, $i, $canChange = true, $controller = false)
	{
		if(!$controller) return;
        
        // Array of image, task, title, action
		$states	= array(
			0	=> array('icon-16-deny.png',	$controller.'.approve',	'COM_IPROPERTY_UNAPPROVED',	'COM_IPROPERTY_APPROVE'),
			1	=> array('icon-16-allow.png',	$controller.'.unapprove',	'COM_IPROPERTY_APPROVED',		'COM_IPROPERTY_UNAPPROVE'),
		);
		$state	= JArrayHelper::getValue($states, (int) $value, $states[1]);
		$html	= JHtml::_('image','admin/'.$state[0], JText::_($state[2]), NULL, true);
		if ($canChange) {
			$html	= '<a href="#" onclick="return listItemTask(\'cb'.$i.'\',\''.$state[1].'\')" title="'.JText::_($state[3]).'">'.$html.'</a>';
		}

		return $html;
	}
}