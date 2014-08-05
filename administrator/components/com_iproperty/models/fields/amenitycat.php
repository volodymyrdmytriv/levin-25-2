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

class JFormFieldAmenityCat extends JFormField
{
    protected $type = 'AmenityCat';

	protected function getInput()
	{
		$amenity_cats = array('' => JText::_('COM_IPROPERTY_SELECT'), 
                              0 => JText::_('COM_IPROPERTY_GENERAL_AMENITIES'), 
                              1 => JText::_('COM_IPROPERTY_INTERIOR_AMENITIES'), 
                              2 => JText::_('COM_IPROPERTY_EXTERIOR_AMENITIES'));
        
        $options = array();
        foreach( $amenity_cats as $key => $value ){
            $options[] = JHTML::_('select.option', $key, $value );
        }
        
		return JHtml::_('select.genericlist', $options, $this->name, 'class="inputbox"', 'value', 'text', $this->value, $this->id);
	}

    public function getOptions()
	{
        $amenity_cats = array('' => JText::_('COM_IPROPERTY_SELECT'), 
                              0 => JText::_('COM_IPROPERTY_GENERAL_AMENITIES'), 
                              1 => JText::_('COM_IPROPERTY_INTERIOR_AMENITIES'), 
                              2 => JText::_('COM_IPROPERTY_EXTERIOR_AMENITIES'));
        
        $options = array();
        foreach( $amenity_cats as $key => $value ){
            $options[] = JHTML::_('select.option', $key, $value );
        }

		return $options;
    }
}