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

abstract class modIpQuickIconHelper
{
	protected static $buttons = array();

	public static function button($button)
	{
		if (!empty($button['access'])) {
			if (is_bool($button['access']) && $button['access'] == false) {
				return '';
			}

			// Take each pair of permission, context values.
			for ($i = 0, $n = count($button['access']); $i < $n; $i += 2) {
				if (!JFactory::getUser()->authorise($button['access'][$i], $button['access'][$i+1])) {
					return '';
				}
			}
		}

		ob_start();
		require JModuleHelper::getLayoutPath('mod_ip_quickicon', 'default_button');
		$html = ob_get_clean();
		return $html;
	}

	public static function &getButtons()
	{
		if (empty(self::$buttons)) {
			self::$buttons = array(
				array(
					'link' => JRoute::_('index.php?option=com_iproperty'),
					'image' => 'administrator/modules/mod_ip_quickicon/images/icon-ip-main.png',
					'text' => JText::_('MOD_IP_QUICKICON_IPROPERTY'),
					'access' => array('core.manage', 'com_iproperty')
				),
				array(
					'link' => JRoute::_('index.php?option=com_iproperty&view=categories'),
					'image' => 'administrator/modules/mod_ip_quickicon/images/icon-ip-cat.png',
					'text' => JText::_('MOD_IP_QUICKICON_CATEGORIES'),
					'access' => array('core.manage', 'com_iproperty')
				),
				array(
					'link' => JRoute::_('index.php?option=com_iproperty&view=properties'),
					'image' => 'administrator/modules/mod_ip_quickicon/images/icon-ip-prop.png',
					'text' => JText::_('MOD_IP_QUICKICON_PROPERTIES'),
					'access' => array('core.manage', 'com_iproperty')
				),
				array(
					'link' => JRoute::_('index.php?option=com_iproperty&view=companies'),
					'image' => 'administrator/modules/mod_ip_quickicon/images/icon-ip-co.png',
					'text' => JText::_('MOD_IP_QUICKICON_COMPANIES'),
					'access' => array('core.manage', 'com_iproperty')
				),
				array(
					'link' => JRoute::_('index.php?option=com_iproperty&view=agents'),
					'image' => 'administrator/modules/mod_ip_quickicon/images/icon-ip-agents.png',
					'text' => JText::_('MOD_IP_QUICKICON_AGENTS'),
					'access' => array('core.manage', 'com_iproperty')
				),
				array(
					'link' => JRoute::_('index.php?option=com_iproperty&view=amenities'),
					'image' => 'administrator/modules/mod_ip_quickicon/images/icon-ip-amen.png',
					'text' => JText::_('MOD_IP_QUICKICON_AMENITIES'),
					'access' => array('core.manage', 'com_iproperty')
				),
				array(
					'link' => JRoute::_('index.php?option=com_iproperty&view=openhouses'),
					'image' => 'administrator/modules/mod_ip_quickicon/images/icon-ip-oh.png',
					'text' => JText::_('MOD_IP_QUICKICON_OH'),
					'access' => array('core.manage', 'com_iproperty')
				),
				array(
					'link' => JRoute::_('index.php?option=com_iproperty&view=settings'),
					'image' => 'administrator/modules/mod_ip_quickicon/images/icon-ip-settings.png',
					'text' => JText::_('MOD_IP_QUICKICON_SETTINGS'),
					'access' => array('core.manage', 'com_iproperty')
				)
			);
		}

		return self::$buttons;
	}
}
