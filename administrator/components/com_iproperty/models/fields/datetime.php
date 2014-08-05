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

class JFormFieldDatetime extends JFormField
{
    protected $type = 'Datetime';

	protected function getInput()
	{
		$document = JFactory::getDocument();
        $size = $this->element['size'] ? $this->element['size'] : 30;
        
        $language = JFactory::getLanguage();
        $lang_tag = $language->getTag();
        
        $available_languages = array('cs-CZ', 'de-DE', 'en-Us', 'es-ES', 'fr-FR', 'he-IL', 'it-IT', 'nl-NL', 'pl-PL', 'pt-BR', 'ru-RU');           
        
        // add the datepicker stuff
        $datepick_base = JURI::root(true).'/components/com_iproperty/assets/js/datepicker/';
        // check for current language and if locale file exists for datepicker, if not default to english
        if(in_array($lang_tag, $available_languages)){
            $locale = $lang_tag;
            $document->addScript($datepick_base.'Locale.'.$lang_tag.'.DatePicker.js');
        }else{
            $locale = 'en-US';
            $document->addScript($datepick_base.'Locale.en-US.DatePicker.js');
        }
        $document->addScript($datepick_base.'Picker.js');
        $document->addScript($datepick_base.'Picker.Attach.js');
        $document->addScript($datepick_base.'Picker.Date.js');
        $document->addStyleSheet($datepick_base.'datepicker_vista/datepicker_vista.css');

        $datescript = "window.addEvent('domready', function() {"."\n";
        $datescript .= " var ipdatepicker = new Picker.Date(document.id('ip_datepicker_".$this->element['name']."'), { "."\n";
        $datescript .= " timePicker: true,"."\n";
        $datescript .= " positionOffset: {x: 5, y: 0}, "."\n";
        $datescript .= " pickerClass: 'datepicker_vista', "."\n";
        $datescript .= " useFadeInOut: !Browser.ie, "."\n";
        $datescript .= " format: '%Y-%m-%d %H:%M:%S', "."\n";
        $datescript .= " });"."\n";
        $datescript .= " Locale.use('".$locale."'); "."\n";
        $datescript .= "});"."\n";
        
        $document->addScriptDeclaration($datescript);
        
        return '<input name="'.$this->name.'" type="text" value="'.$this->value.'" size="'.$size.'" class="inputbox" id="ip_datepicker_'.$this->element['name'].'" />';
	}
}