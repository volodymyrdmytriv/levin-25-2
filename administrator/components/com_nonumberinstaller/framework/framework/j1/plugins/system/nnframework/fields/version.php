<?php
/**
 * Element: Version
 * Displays the version check
 *
 * @package         NoNumber Framework
 * @version         12.12.7
 *
 * @author          Peter van Westen <peter@nonumber.nl>
 * @link            http://www.nonumber.nl
 * @copyright       Copyright © 2012 NoNumber All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

class nnFieldVersion
{
	var $_version = '12.12.7';

	function getInput($params)
	{
		$this->params = $params;

		$xml = $this->def('xml');
		$extension = $this->def('extension');

		$user = JFactory::getUser();
		$authorise = ($user->usertype == 'Super Administrator' || $user->usertype == 'Administrator');

		if (!strlen($extension) || !strlen($xml) || !$authorise) {
			return '';
		}

		// Import library dependencies
		require_once JPATH_PLUGINS . '/system/nnframework/helpers/versions.php';
		$versions = NNVersions::getInstance();

		return $versions->getMessage($extension, $xml);
	}

	private function def($val, $default = '')
	{
		return (isset($this->params[$val]) && (string) $this->params[$val] != '') ? (string) $this->params[$val] : $default;
	}
}

class JElementNN_Version extends JElement
{
	var $_name = 'Version';

	function fetchTooltip($label, $description, &$node, $control_name, $name)
	{
		return;
	}

	function fetchElement($name, $value, &$node, $control_name)
	{
		$this->_nnfield = new nnFieldVersion;
		return $this->_nnfield->getInput($node->attributes());
	}
}
