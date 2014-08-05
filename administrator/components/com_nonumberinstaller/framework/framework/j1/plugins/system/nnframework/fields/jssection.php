<?php
/**
 * Element: JSSection
 * Displays a multiselectbox of available JoomSuite Resources categories
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

require_once JPATH_PLUGINS . '/system/nnframework/helpers/functions.php';

class nnFieldJSSection
{
	var $_version = '12.12.7';

	function getInput($name, $id, $value, $params)
	{
		$this->params = $params;

		if (!NNFrameworkFunctions::extensionInstalled('resource')) {
			return 'JoomSuite Resources files not found...';
		}

		$db = JFactory::getDBO();
		$tables = $db->getTableList();
		if (!in_array($db->getPrefix() . 'js_res_category', $tables)) {
			return 'JoomSuite Resources category table not found in database...';
		}

		$size = (int) $this->def('size');
		$multiple = $this->def('multiple');
		$get_categories = $this->def('getcategories', 1);

		if (!is_array($value)) {
			$value = explode(',', $value);
		}

		$where = 'published = 1';
		if (!$get_categories) {
			$where .= ' AND parent = 0';
		}

		$query = "SELECT id, parent, name FROM #__js_res_category WHERE " . $where;
		$db->setQuery($query);
		$menuItems = $db->loadObjectList();

		// establish the hierarchy of the menu
		// TODO: use node model
		$children = array();

		if ($menuItems) {
			// first pass - collect children
			foreach ($menuItems as $v) {
				$pt = $v->parent;
				$list = @$children[$pt] ? $children[$pt] : array();
				array_push($list, $v);
				$children[$pt] = $list;
			}
		}

		// second pass - get an indent list of the items
		require_once JPATH_LIBRARIES . '/joomla/html/html/menu.php';
		$list = JHTMLMenu::treerecurse(0, '', array(), $children, 9999, 0, 0);

		// assemble items to the array
		$options = array();
		foreach ($list as $item) {
			$options[] = JHtml::_('select.option', $item->id, $item->treename, 'value', 'text', 0);
		}

		require_once JPATH_PLUGINS . '/system/nnframework/helpers/html.php';
		return nnHTML::selectlist($options, $name, $value, $id, $size, $multiple);
	}

	private function def($val, $default = '')
	{
		return (isset($this->params[$val]) && (string) $this->params[$val] != '') ? (string) $this->params[$val] : $default;
	}
}

class JElementNN_JSSection extends JElement
{
	var $_name = 'JSSection';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$this->_nnfield = new nnFieldJSSection;
		return $this->_nnfield->getInput($control_name . '[' . $name . ']', $control_name . $name, $value, $node->attributes());
	}
}
