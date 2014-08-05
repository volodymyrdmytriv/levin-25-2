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
require_once (JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'helpers'.DS.'query.php' );

class JFormFieldAgent extends JFormField
{
    protected $type = 'Agent';

	protected function getInput()
	{
		$useauth    = ($this->element['useauth']) ? true : false;
        $multiple   = ($this->element['multiple']) ? ' multiple="multiple"' : '';
        $size       = ($this->element['size']) ? ' size="'.$this->element['size'].'"' : '';
        $style      = ($this->element['style']) ? ' style="'.$this->element['style'].'"' : '';
        
        //JPlugin::loadLanguage('com_iproperty', JPATH_ADMINISTRATOR);
        JFactory::getLanguage()->load('com_iproperty', JPATH_ADMINISTRATOR);
        
        $agents = ipropertyHTML::agentSelectList('','','', true, $useauth);
		return JHtml::_('select.genericlist', $agents, $this->name, 'class="inputbox"'.$multiple.$size.$style, 'value', 'text', $this->value, $this->id);
	}

    public function getOptions($useauth = '')
	{
        $useauth    = ($useauth) ? true : false;
        
        //JPlugin::loadLanguage('com_iproperty', JPATH_ADMINISTRATOR);
        JFactory::getLanguage()->load('com_iproperty', JPATH_ADMINISTRATOR);

		$options = array();
		$options = ipropertyHTML::agentSelectList('','','', true, $useauth);

		return $options;
    }
}