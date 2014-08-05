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

class JFormFieldHits extends JFormField
{
	protected $type = 'Hits';

	protected function getInput()
    {
		$item = JRequest::getInt('id');
        if(!$item) return;
        
        // define variables
        $db = JFactory::getDbo();
        $document = JFactory::getDocument();
        
        // See if hits exist
        $query = $db->getQuery(true);
        $query->select('hits');
        $query->from('#__iproperty');
        $query->where('id = '.$item); 
        $db->setQuery($query);
        
        $js = "
        resetHits = function(){
            var checkurl = '".JURI::base('true')."/index.php?option=com_iproperty&task=ajax.resetHits';
            var propId = ".$item.";

            req = new Request({
                method: 'post',
                url: checkurl,
                data: { 'prop_id': propId,
                        '".JUtility::getToken()."':'1',
                        'format': 'raw'},
                onRequest: function() {
                    document.id('hits_msg').set('html', '');
                    document.id('hits_msg').set('class', 'loading_div');
                },
                onSuccess: function(response) {
                    if(response){
                        document.id('hits_msg').set('class', 'ip_message');
                        document.id('jform_hits').value = '0';
                        document.id('hits_msg').set('html', response);                    
                    }else{
                        document.id('hits_msg').set('class', 'ip_warning');
                        document.id('hits_msg').set('html', '".JText::_('COM_IPROPERTY_COUNTER_NOT_RESET')."');
                    }
                }
            }).send();
        }";
        
        $document->addScriptDeclaration($js);
        
        
        if($result = $db->loadResult()){
            ?>

            <div><div id="hits_msg"></div></div>
            <div class="fltlft">
                <input type="text" id="jform_hits" value="<?php echo $result; ?>" disabled="disabled" />
            </div>
            &nbsp;
            <div class="button2-left">
              <div class="blank">
                    <a title="<?php echo JText::_('COM_IPROPERTY_RESET'); ?>" onclick="resetHits();"><?php echo JText::_('COM_IPROPERTY_RESET'); ?></a>
              </div>
            </div>
            
            <?php
        }else{
            echo '0';
        }
	}
}