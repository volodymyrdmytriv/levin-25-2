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

class plgIpropertyFbcomment extends JPlugin
{
    function plgIpropertyFbcomment(&$subject, $config)  
    {
        parent::__construct($subject, $config);
    }

    function onBeforeRenderForms($property, $settings, $sidecol)
    {
		if ($this->params->get('before', false)) $this->doCommentTab($property, $settings, $sidecol);
    }
	
	function onAfterRenderForms($property, $settings, $sidecol)
    {
        if (!$this->params->get('before', false)) $this->doCommentTab($property, $settings, $sidecol);
    }

	function doCommentTab($property, $settings, $sidecol)
	{
		$app  = JFactory::getApplication();
        if($app->getName() != 'site') return true;
        $document = JFactory::getDocument();

        $posts  = (int) $this->params->get('number', 5);
        $scheme = (boolean) $this->params->get('scheme', false) ? 'dark' : 'light';
        $width  = (int) $this->params->get('width', 600);

        // check for moderator/appid
        $userid = (string) $this->params->get('moderator', 0);
        $appid  = (string) $this->params->get('app_id', 0);

        // add moderator/appid
        if ($userid) {
            $mod_tag = '<meta property="fb:admins" content="'.$userid.'"/>';
            $document->addCustomTag($mod_tag);
        }

        if ($appid) {
            $app_tag = '<meta property="fb:app_id" content="'.$appid.'"/>';
            $document->addCustomTag($app_tag);
        }

        echo JHtml::_('tabs.panel', JText::_($this->params->get('tabtitle', 'PLG_IP_FBCOMMENT_COMMENTS')), 'ipfbcomments');
        
        echo '<div id="fb-root"></div>';
		echo '<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>';
		echo '<fb:comments href="'.JURI::getInstance()->toString().'" num_posts="'.$posts.'" width="'.$width.'" colorscheme="'.$scheme.'"></fb:comments>';

        return true;	
	}
}
