<?php
/**
 * Element: Sections / Categories
 * Displays a (multiple) selectbox of available sections and categories
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

class nnFieldSecsCats
{
	function getInput($name, $id, $value, $params)
	{
		$this->params = $params;

		$size = (int) $this->def('size');
		$multiple = $this->def('multiple');
		$show_uncategorized = $this->def('show_uncategorized');
		$auto_select_cats = $this->def('auto_select_cats', 1);

		$db = JFactory::getDBO();

		if (is_array($value)) {
			$value = implode(',', $value);
		}
		$value = str_replace('.', ':', $value);
		$value = explode(',', $value);

		$query = 'SELECT id, 0 AS parent, title AS name FROM #__sections WHERE published = 1 AND scope = "content" ORDER BY ordering';
		$db->setQuery($query);
		$sections = $db->loadObjectList();
		for ($i = 0; $i < count($sections); $i++) {
			$sec_name = explode("\n", wordwrap($sections[$i]->name, 86, "\n"));
			$sec_name = $sec_name['0'];
			$sec_name = ($sec_name != $sections[$i]->name) ? $sec_name . '...' : $sec_name;
			$sections[$i]->title = $sec_name;
		}

		$children = array();
		$children[] = $sections;
		foreach ($sections as $section) {
			$query = 'SELECT CONCAT( ' . $section->id . ', ":", id ) AS id, section AS parent, title AS name'
				. ' FROM #__categories'
				. ' WHERE published = 1'
				. ' AND section = ' . $section->id
				. ' ORDER BY ordering';
			$db->setQuery($query);
			$categories = $db->loadObjectList();
			for ($i = 0; $i < count($categories); $i++) {
				$cat_name = explode("\n", wordwrap($categories[$i]->name, 86, "\n"));
				$cat_name = $cat_name['0'];
				$cat_name = ($cat_name != $categories[$i]->name) ? $cat_name . '...' : $cat_name;
				$categories[$i]->name = $cat_name;
				if ($auto_select_cats && in_array($section->id, $value)) {
					$value[] = $categories[$i]->id;
				}
			}
			$children[$section->id] = $categories;
		}

		// second pass - get an indent list of the items
		require_once JPATH_LIBRARIES . '/joomla/html/html/menu.php';
		$list = JHTMLMenu::treerecurse(0, '', array(), $children, 9999, 0, 0);

		// assemble items to the array
		$options = array();
		if ($show_uncategorized) {
			$options[] = JHtml::_('select.option', '0', JText::_('Uncategorized'), 'value', 'text', 0);
		}
		foreach ($list as $item) {
			$item_name = preg_replace('#^((&nbsp;)*)- #', '\1', str_replace('&#160;', '&nbsp;', $item->treename));
			$options[] = JHtml::_('select.option', $item->id, $item_name, 'value', 'text', 0);
		}

		require_once JPATH_PLUGINS . '/system/nnframework/helpers/html.php';
		return nnHTML::selectlist($options, $name, $value, $id, $size, $multiple);
	}

	private function def($val, $default = '')
	{
		return (isset($this->params[$val]) && (string) $this->params[$val] != '') ? (string) $this->params[$val] : $default;
	}
}

class JElementNN_SecsCats extends JElement
{
	var $_name = 'SecsCats';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$this->_nnfield = new nnFieldSecsCats;
		return $this->_nnfield->getInput($control_name . '[' . $name . ']', $control_name . $name, $value, $node->attributes());
	}
}
