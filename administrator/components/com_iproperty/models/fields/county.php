<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');
require_once (JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'helpers'.DS.'html.helper.php' );

class JFormFieldCounty extends JFormField
{
    protected $type = 'County';

	protected function getInput()
	{
		//JPlugin::loadLanguage('com_iproperty', JPATH_ADMINISTRATOR);
        JFactory::getLanguage()->load('com_iproperty', JPATH_ADMINISTRATOR);
        
        $counties = ipropertyHTML::county_select_list('','','', true);
		return JHtml::_('select.genericlist', $counties, $this->name, 'class="inputbox"', 'value', 'text', $this->value, $this->id);
	}

    public function getOptions()
	{
        //JPlugin::loadLanguage('com_iproperty', JPATH_ADMINISTRATOR);
        JFactory::getLanguage()->load('com_iproperty', JPATH_ADMINISTRATOR);

		$options = array();
		$options = ipropertyHTML::county_select_list('','','', true);

		return $options;
    }
}


