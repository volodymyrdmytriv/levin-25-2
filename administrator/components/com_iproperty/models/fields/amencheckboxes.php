<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined('JPATH_PLATFORM') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');

class JFormFieldAmenCheckboxes extends JFormField
{
	protected $type = 'AmenCheckboxes';

	protected $forceMultiple = true;

	protected function getInput()
	{
		// Initialize variables.
		$html = array();

		// Initialize some field attributes.
		$class = $this->element['class'] ? ' class="checkboxes '.(string) $this->element['class'].'"' : ' class="checkboxes"';

		// Start the checkbox field output.
		$html[] = '<fieldset id="'.$this->id.'"'.$class.'>';

		// Get the field options.
		$options = $this->getOptions($this->element['category']);

		// Build the checkbox field output.
		$html[] = '<ul style="list-style: none;">';
        if(count($options)){
            foreach ($options as $i => $option) {

                // Initialize some option attributes.
                $checked	= (in_array((string) $option->value, (array) $this->value) ? ' checked="checked"' : '');
                $class		= !empty($option->class) ? ' class="'.$option->class.'"' : '';
                $disabled	= !empty($option->disable) ? ' disabled="disabled"' : '';

                // Initialize some JavaScript option attributes.
                $onclick	= !empty($option->onclick) ? ' onclick="'.$option->onclick.'"' : '';

                $html[] = '<li>';
                $html[] = '<input type="checkbox" id="'.$this->id.$i.'" name="'.$this->name.'"' .
                        ' value="'.htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8').'"'
                        .$checked.$class.$onclick.$disabled.'/>';

                $html[] = '<label for="'.$this->id.$i.'" style="margin-left: 3px;">'.JText::_($option->text).'</label>';
                $html[] = '</li>';
            }
        }else{
            $html[] = '<li>'.JText::_('COM_IPROPERTY_NO_RESULTS').'</li>';
        }
		$html[] = '</ul>';

		// End the checkbox field output.
		$html[] = '</fieldset>';

		return implode($html);
	}
    
	protected function getOptions($cat = '')
	{
		// Initialize variables.
        $options = array();
        
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        
        $query->select('id as value, title as text');
        $query->from('#__iproperty_amenities');
        if($cat) $query->where('cat = '.(int)$cat);
        $query->order('title ASC');
        
        $db->setQuery($query);
        $amen_array = $db->loadObjectList();

		foreach ($amen_array as $option) {
			// Create a new option object based on the <option /> element.
			$tmp = JHtml::_('select.option', (string) $option->value, trim((string) $option->text));

			// Set some option attributes.
			$tmp->class = 'inputbox';

			// Set some JavaScript option attributes.
			//$tmp->onclick = 'alert("here")';

			// Add the option object to the result set.
			$options[] = $tmp;
		}

		reset($options);

		return $options;
	}
}
