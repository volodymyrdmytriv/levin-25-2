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

class JFormFieldAgentSortBy extends JFormField
{
    protected $type = 'AgentSortby';

	protected function getInput()
	{	
        //JPlugin::loadLanguage('com_iproperty', JPATH_ADMINISTRATOR);
        JFactory::getLanguage()->load('com_iproperty', JPATH_ADMINISTRATOR);
        
        $default = array();
        $default[] = JHTML::_('select.option', '', JText::_('--'), "value", "text" );
        
        $sortbys = ipropertyHTML::buildAgentSortList('', '', true);
        $sortbys = array_merge( $default, $sortbys );
        
		return JHTML::_('select.genericlist', $sortbys, $this->name, 'class="inputbox"', 'value', 'text', $this->value, $this->id );
    }

    public function getOptions()
	{
        //JPlugin::loadLanguage('com_iproperty', JPATH_ADMINISTRATOR);
        JFactory::getLanguage()->load('com_iproperty', JPATH_ADMINISTRATOR);

        $options = array();
        $options = ipropertyHTML::buildAgentSortList('', '', true);

		array_unshift($options, JHtml::_('select.option', '', JText::_('--')));

		return $options;
    }
}


