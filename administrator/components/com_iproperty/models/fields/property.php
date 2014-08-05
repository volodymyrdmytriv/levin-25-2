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
require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_iproperty'.DS.'classes'.DS.'admin.class.php' );
require_once (JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'helpers'.DS.'html.helper.php' );

class JFormFieldProperty extends JFormField
{
    protected $type = 'Property';

	protected function getInput()
	{
		$useauth = ($this->element['useauth']) ? true : false;
        
        //JPlugin::loadLanguage('com_iproperty', JPATH_ADMINISTRATOR);
        JFactory::getLanguage()->load('com_iproperty', JPATH_ADMINISTRATOR);
        
        $properties = ipropertyHTML::propertySelectList('', '', '', true, $useauth);
		return JHtml::_('select.genericlist', $properties, $this->name, 'class="inputbox" style="width: 250px;"', 'value', 'text', $this->value, $this->id);
	}

    public function getOptions($useauth = '')
	{
        $useauth = ($useauth) ? true : false;
        
        //JPlugin::loadLanguage('com_iproperty', JPATH_ADMINISTRATOR);
        JFactory::getLanguage()->load('com_iproperty', JPATH_ADMINISTRATOR);

        $options = array();
        $options = ipropertyHTML::propertySelectList('', '', '', true, $useauth);

		return $options;
    }
}