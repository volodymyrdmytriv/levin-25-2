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

class JFormFieldBaths extends JFormField
{
    protected $type = 'Baths';

	protected function getInput()
	{
		$settings   = ipropertyAdmin::config();
        $fractions  = ($this->element['fractions']) ? $this->element['fractions'] : $settings->baths_fraction;
        
        //JPlugin::loadLanguage('com_iproperty', JPATH_ADMINISTRATOR);
        JFactory::getLanguage()->load('com_iproperty', JPATH_ADMINISTRATOR);
        
        $baths = ipropertyHTML::baths_select_list('','','', $fractions, true);
		return JHtml::_('select.genericlist', $baths, $this->name, 'class="inputbox"', 'value', 'text', $this->value, $this->id);
	}

    public function getOptions($fractions = '')
	{
        $settings   = ipropertyAdmin::config();
        $fractions  = ($fractions) ? $fractions : $settings->baths_fraction;
        
        //JPlugin::loadLanguage('com_iproperty', JPATH_ADMINISTRATOR);
        JFactory::getLanguage()->load('com_iproperty', JPATH_ADMINISTRATOR);
        
        $options = array();
        $options = ipropertyHTML::baths_select_list('','','', $fractions, true);

		return $options;
    }
}