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

class JFormFieldGmap extends JFormField
{
    protected $type = 'Gmap';

	protected function getInput()
	{
		$width  = ($this->element['width']) ? $this->element['width'] : '100%';
        $height = ($this->element['width']) ? $this->element['height'] : '300px';
        $border = ($this->element['border']) ? $this->element['border'] : '#666';
        
        echo '<div id="map" style="width: '.$width.'; height: '.$height.'; border: solid 1px '.$border.';"><div align="center" style="padding: 5px;">'.JText::_($this->description).'</div></div>';
	}
}


