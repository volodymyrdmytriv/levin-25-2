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

class JFormFieldCurrencies extends JFormField
{
    protected $type = 'Currencies';

	protected function getInput()
	{
        //JPlugin::loadLanguage('com_iproperty', JPATH_ADMINISTRATOR);
        JFactory::getLanguage()->load('com_iproperty', JPATH_ADMINISTRATOR);
        
        $currencies = ipropertyHTML::currencySelectList('', '', '', true );
		return JHtml::_('select.genericlist', $currencies, $this->name, 'class="inputbox" size="1"', 'value', 'text', $this->value, $this->id);
	}

    public function getOptions()
	{
        //JPlugin::loadLanguage('com_iproperty', JPATH_ADMINISTRATOR);
        JFactory::getLanguage()->load('com_iproperty', JPATH_ADMINISTRATOR);

		$options = array();
		$options = ipropertyHTML::currencySelectList('', '', '', true );

		return $options;
    }
}


