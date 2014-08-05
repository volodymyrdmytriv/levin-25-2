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

class JFormFieldColorChooser extends JFormField
{
    protected $type = 'ColorChooser';

	protected function getInput()
	{
		$document   = JFactory::getDocument();
        $cwheel     = $this->element['cwheel'];
        $inputid    = $this->element['name'];
        $imgpath    = ($this->element['imgpath']) ? $this->element['imgpath'] : 'components/com_iproperty/assets/js/moorainbow/images/';
        $rgb_array  = ($this->_hex2RGB($this->value)) ? $this->_hex2RGB($this->value) : '58, 142, 246';
        
        $document->addScript(JURI::root(true).'/components/com_iproperty/assets/js/moorainbow/mooRainbow_12.js');
        $document->addStyleSheet(JURI::root(true).'/components/com_iproperty/assets/js/moorainbow/mooRainbow.css');
        
        $script = "
        window.addEvent('domready', function() {
            new MooRainbow('".$cwheel."', {
                'id': '".$cwheel."',
                'wheel': true,
                'imgPath' : '".$imgpath."',
                'startColor': [".$rgb_array."],
                'onChange': function(color) {
                    $('".$inputid."').value = color.hex;
                    $('".$inputid."Preview').style.background = color.hex;
                }
            });
        });";
        
        $document->addScriptDeclaration($script);
        
        return '<fieldset class="radio inputbox">
                    <input id="'.$inputid.'" class="inputbox" name="'.$this->name.'" type="text" value="'.$this->value.'" size="20" />
                    '.JHtml::_('image','admin/expandall.png', 'Select', 'id="'.$cwheel.'" style="margin-left: 3px;"', true).'<span class="colorpicker_block" id="'.$inputid.'Preview" style="background: '.$this->value.';">'.JText::_( 'COM_IPROPERTY_CURRENT_COLOR' ).'</span>
                </fieldset>';
	}
    
    protected function _hex2RGB($hexStr, $returnAsString = true, $seperator = ',') 
    {
        if(!$hexStr) return false;
        
        $hexStr     = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
        $rgbArray   = array();
        
        if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
            $colorVal           = hexdec($hexStr);
            $rgbArray['red']    = 0xFF & ($colorVal >> 0x10);
            $rgbArray['green']  = 0xFF & ($colorVal >> 0x8);
            $rgbArray['blue']   = 0xFF & $colorVal;
        } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
            $rgbArray['red']    = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
            $rgbArray['green']  = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
            $rgbArray['blue']   = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
        } else {
            return false; //Invalid hex color code
        }
        return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
    }
}