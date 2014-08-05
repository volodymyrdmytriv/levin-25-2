<?php
/**
 * @version   $Id: font.php 3103 2012-09-03 16:58:49Z djamil $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2012 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */

defined('JPATH_BASE') or die();

gantry_import('core.gantryfeature');

/**
 * @package         gantry
 * @subpackage      features
 */
class GantryFeatureFont extends GantryFeature
{

	var $_feature_name = 'font';
	var $_standard_fonts = array(
		"default",
		"geneva",
		"georgia",
		"helvetica",
		"helveticaneue",
		"lucida",
		"optima",
		"palatino",
		"trebuchet",
		"tahoma"
	);

	private $_value_backup;

	function isEnabled()
	{
		return true;
	}

	function isInPosition($position)
	{
		return false;
	}

	function isOrderable()
	{
		return false;
	}


	function init()
	{
		/** @var $gantry Gantry */
		global $gantry;

		$font_family = $this->get('family');

		if (strpos($font_family, ':')) {
			$explode = explode(':', $font_family);

			$delimiter = $explode[0];
			$name      = $explode[1];
			$variant   = isset($explode[2]) ? $explode[2] : null;

			// we re-set the font-family to a font-name with no delimiter
			// for backward compatibility
			$this->_backwardCompatibility($name);
		} else {
			$delimiter = false;
			$name      = $font_family;
			$variant   = null;
		}

		if (isset($variant) && $variant) $variant = ':' . $variant;

		switch ($delimiter) {
			// standard fonts
			case 's':
				break;
			// google fonts
			case 'g':
				$this->_addGoogleFont($name, $variant);
				break;
			default:
				if ($this->_isStandardFont($name)) break;
				if ($this->_searchForGoogleFont($name)) $this->_addGoogleFont($name, $variant);
		}

	}

	function _isStandardFont($name)
	{
		/** @var $gantry Gantry */
		global $gantry;
		if (strtolower($name) == strtolower($gantry->templateName) || in_array(strtolower($name), $this->_standard_fonts)) {
			return true;
		} else {
			return false;
		}
	}

	function _addGoogleFont($name, $variant)
	{
		/** @var $gantry Gantry */
		global $gantry;

		$variant = $variant ? $variant : '';

		$gantry->addStyle('//fonts.googleapis.com/css?family=' . str_replace(" ", "+", $name) . $variant);
		$gantry->addInlineStyle("h1, h2, .gf-menu .item, #btl .btl-panel, .btl-content-block h3, div.itemHeader h2.itemTitle, div.userItemHeader h3.userItemTitle, div.catItemHeader h3.catItemTitle, div.tagItemHeader h2.tagItemTitle, div.genericItemHeader h2.genericItemTitle, .layout-slideshow .sprocket-features-content h2, .big-button, .itemAuthorBlock h3, div.itemAuthorLatest h3, div.itemRelated h3, div.itemCommentsForm h3, h3.itemCommentsCounter, div.userBlock h2, ul.unoslider h4 a, .gkIsWrapper-gk_bikestore figcaption h3, .gkIsWrapper-gk_eSport .gkIsTextTitle a, .nspArt h4.nspHeader a, .gkTabsWrap.vertical ol li, .gkTabsWrap.horizontal ol li, .sprocket-lists-title, .featured .nspArt h4.nspHeader, .featured .nspArt h4.nspHeader a, .k2AccountPage th.k2ProfileHeading, .contact h3, #main .sprocket-mosaic .sprocket-mosaic-filter ul li, #main .sprocket-mosaic .sprocket-mosaic-filter ul li, .sprocket-mosaic .sprocket-mosaic-filter li, .sprocket-mosaic .sprocket-mosaic-filter li, #main .sprocket-mosaic .sprocket-mosaic-order ul li, #main .sprocket-mosaic .sprocket-mosaic-order ul li, .sprocket-mosaic .sprocket-mosaic-order li, .sprocket-mosaic .sprocket-mosaic-order li, #Kunena #ktab a, .nspHeadline h4 { font-family: '" . $name . "', 'Helvetica', arial, serif; }");
	}


	function _searchForGoogleFont($name)
	{
		/** @var $gantry Gantry */
		global $gantry;
		$google_json = $gantry->gantryPath . '/' . 'admin' . '/' . 'widgets' . '/' . 'fonts' . '/' . 'js' . '/' . 'google-fonts.json';
		if (!file_exists($google_json)) return false;

		$fonts = json_decode(file_get_contents($google_json), true);
		$fonts = $fonts['items'];

		return $this->_in_array_r($name, $fonts);
	}

	function _backwardCompatibility($value)
	{
		/** @var $gantry Gantry */
		global $gantry;
		$param = $this->_feature_name . '-family';

		if (in_array($param, $gantry->_bodyclasses)) {
			$position = array_search($param, $gantry->_bodyclasses);
			unset($gantry->_bodyclasses[$position]);
			array_splice($gantry->_bodyclasses, $position, 0, strtolower(str_replace(" ", "-", $param . '-' . $value)));
		}
	}

	function _in_array_r($needle, $haystack, $strict = true)
	{
		foreach ($haystack as $item) {
			if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->_in_array_r($needle, $item, $strict))) {
				return true;
			}
		}

		return false;
	}

}
