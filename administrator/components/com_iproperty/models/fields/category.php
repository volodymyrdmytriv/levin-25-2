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
require_once (JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'helpers'.DS.'query.php' );

class JFormFieldCategory extends JFormField
{
    protected $type = 'Category';

	protected function getInput()
	{
		$multiple   = ($this->element['multiple']) ? ' multiple="multiple"' : '';
        $size       = ($this->element['size']) ? ' size="'.$this->element['size'].'"' : '';
        $style      = ($this->element['style']) ? ' style="'.$this->element['style'].'"' : '';
        
        //JPlugin::loadLanguage('com_iproperty', JPATH_ADMINISTRATOR);
        JFactory::getLanguage()->load('com_iproperty', JPATH_ADMINISTRATOR);
        
        $cats = ipropertyHTML::multicatSelectList('','','', true);

        return JHtml::_('select.genericlist', $cats, $this->name, 'class="inputbox"'.$multiple.$size.$style, 'value', 'text', $this->value, $this->id);
	}

    public function getOptions()
	{
        //JPlugin::loadLanguage('com_iproperty', JPATH_ADMINISTRATOR);
        JFactory::getLanguage()->load('com_iproperty', JPATH_ADMINISTRATOR);

        $options = array();
        $options = ipropertyHTML::multicatSelectList('','','', true);

		return $options;
    }
}


