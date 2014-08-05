<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin');

class plgIpropertyJcomments extends JPlugin
{
	function plgIpropertyJcomments(&$subject, $config)  {
		parent::__construct($subject, $config);
        $this->loadLanguage();
	}
    
    function onBeforeRenderForms($property, $settings, $sidecol)
    {
		if ($this->params->get('before', false)) $this->doJcommentsForm($property, $settings, $sidecol);
    }
	
	function onAfterRenderForms($property, $settings, $sidecol)
    {
        if (!$this->params->get('before', false)) $this->doJcommentsForm($property, $settings, $sidecol);
    }    

	function doJcommentsForm($property, $settings, $sidecol)
	{
        $app = JFactory::getApplication();
		if($app->getName() != 'site') return true;
        
        if(file_exists(JPATH_SITE.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php')){
            require_once(JPATH_SITE.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php');
        }else{
            return true;
        }
        		
		echo JHtml::_('tabs.panel', JText::_($this->params->get('tabtitle', 'PLG_IP_JCOMMENTS_COMMENTS')), 'ipjcomments');
		echo JComments::showComments($property->id, 'com_iproperty', $property->street_address);
		
		return true;
	}	
}
