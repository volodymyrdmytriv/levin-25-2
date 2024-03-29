<?php
/**
 * @package Locator Component
 * @copyright 2009 - Fatica Consulting L.L.C.
 * @license GPL - This is Open Source Software 
 * $Id$ ?
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.html.html');
jimport('joomla.form.formfield');//import the necessary class definition for formfield


/**
 * Supports an HTML select list of articles
 * @since  1.6
 */

if(class_exists('JFormField')){

	class JFormFieldTag extends JFormField
	{
		
		/**
		* The form field type.
		*
		* @var  string
		* @since	1.6
		*/
		protected $type = 'Tag'; //the form field type
	
		/**
		* Method to get content articles
		*
		* @return	array	The field option objects.
		* @since	1.6
		*/
		protected function getInput()
		{
			// Initialize variables.
			$session = JFactory::getSession();
			$options = array();
			
			$attr = '';
			
			// Initialize some field attributes.
			$attr .= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';
			
			// To avoid user's confusion, readonly="true" should imply disabled="true".
			if ( (string) $this->element['readonly'] == 'true' || (string) $this->element['disabled'] == 'true') {
				$attr .= ' disabled="disabled"';
			}
			
			$attr .= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : '';
			$attr .= $this->multiple ? ' multiple="multiple"' : '';
			
			// Initialize JavaScript field attributes.
			$attr .= $this->element['onchange'] ? ' onchange="'.(string) $this->element['onchange'].'"' : '';
				
			//now get to the business of finding the articles		
			$db = &JFactory::getDBO();
			
			$sql = '';
	
			switch ($this->name){
				
				case 'jform[params][country][]':{
					
				$sql =  'SELECT DISTINCT `value` as `id`,`value` as `name` FROM #__locations l 
						INNER JOIN #__location_fields_link fl ON fl.location_id = l.id
						INNER JOIN #__location_fields f ON f.id = fl.location_fields_id
						WHERE f.name = \'Country\' AND l.published = 1
						ORDER BY `value`';	
					
				}break;
				                	
				case 'jform[params][tags][]':{
					$sql = "SELECT id,name FROM #__location_tags  ORDER BY tag_group_order ,`order`,`name`";
					
				}break;
				
			}
	
			$options = array();
			
			$db->setQuery( $sql );
			
			$options = $db->loadObjectList();
							  
			return JHTML::_('select.genericlist',  $options, $this->name, trim($attr), 'id', 'name', $this->value );
	
		  
		}
	}
}

if(class_exists('JElement')){
	
	class JElementTag extends JElement
	{
		/**
		 * Element name
		 *
		 * @access	protected
		 * @var		string
		 */
		var	$_name = 'tag';
	
		
		function fetchElement($name, $value, &$node, $control_name)
		{
	
			         // Base name of the HTML control.
	                $ctrl  = $control_name .'['. $name .']';
	                $sql = "";
	                
	                switch ($node->attributes( 'source' )){
	                	
	                	case 'country':{
	                		
	                	$sql = 	'SELECT DISTINCT `value` as `id`,`value` as `name` FROM #__locations l 
						INNER JOIN #__location_fields_link fl ON fl.location_id = l.id
						INNER JOIN #__location_fields f ON f.id = fl.location_fields_id
						WHERE f.name = \'Country\'
						ORDER BY `value`';	
	                		
	                	}break;
	                	                	
	                	case 'tag':{
	                		$sql = "SELECT id,name FROM #__location_tags  ORDER BY tag_group_order ,`order`,`name`";
	                		
	                	}break;
	                	
	                }
	
					$db = JFactory::getDBO();
					$db->setQuery($sql);
					$dboptions = $db->loadObjectList();
	 
	                // Construct an array of the HTML OPTION statements.
	                $options = array ();
	                
	                if(count($dboptions) > 0){
	                	
		                foreach ($dboptions as $option)
		                {
		                        $val   = $option->id;
		                        $text  = $option->name;
		                        $options[] = JHTML::_('select.option', $val, JText::_($text));
		                }
	                }
	 
	                // Construct the various argument calls that are supported.
	                $attribs       = ' ';
	                if ($v = $node->attributes( 'size' )) {
	                        $attribs       .= 'size="'.$v.'"';
	                }
	                if ($v = $node->attributes( 'class' )) {
	                        $attribs       .= 'class="'.$v.'"';
	                } else {
	                        $attribs       .= 'class="inputbox"';
	                }
	                if ($m = $node->attributes( 'multiple' ))
	                {
	                        $attribs       .= ' multiple="multiple"';
	                        $ctrl          .= '[]';
	                }
	                
	 
	                // Render the HTML SELECT list.
	                return JHTML::_('select.genericlist', $options, $ctrl, $attribs, 'value', 'text', $value, $control_name.$name );
	
		}
	}
}