<?php
/**
 * NoNumber Framework Helper File: Assignments: Languages
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

/**
 * Assignments: Languages
 */
class NNFrameworkAssignmentsLanguages
{
	var $_version = '12.12.7';

	/**
	 * passLanguages
	 *
	 * @param  <object> $params
	 * @param  <array> $selection
	 * @param  <string> $assignment
	 *
	 * @return <bool>
	 */
	function passLanguages(&$main, &$params, $selection = array(), $assignment = 'all')
	{
		$lang = JFactory::getLanguage();
		return $main->passSimple($lang->getTag(), $selection, $assignment, 1);
	}
}
