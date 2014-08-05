<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Iproperty
 * @copyright (C) 2013 the Thinkery
 * @license see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include the helper functions only once
require_once('components'.DS.'com_iproperty'.DS.'helpers'.DS.'html.helper.php');
require_once('components'.DS.'com_iproperty'.DS.'helpers'.DS.'route.php');
require_once( dirname(__FILE__).DS.'helper.php' );

$showbutton      = $params->get('button', '');
$button_pos		 = $params->get('button_pos', 'right');
$width			 = intval($params->get('width', 20));
$maxlength		 = $width > 20 ? $width : 20;
$button_text	 = $params->get('dsearch', JText::_('JSEARCH_FILTER_SUBMIT'));
$text			 = $params->get('dkeyword', JText::_('MOD_IP_MLSSEARCH_DREF'));
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

if(JRequest::getVar('task') == 'ip_mls_search')
{
    $app = JFactory::getApplication();

    if (!JRequest::getVar('ip_mls_search')) {
        $app->redirect(JRoute::_(ipropertyHelperRoute::getAdvsearchRoute(), false), JText::_('MOD_IP_MLSSEARCH_PLEASE_ENTER_ID'), 'notice' );
    }

    $propid = modMlsSearchHelper::searchMLS(JRequest::getVar('ip_mls_search'));
    if (!$propid) {
        $app->redirect(JRoute::_(ipropertyHelperRoute::getAdvsearchRoute(), false), JText::_('MOD_IP_MLSSEARCH_NO_RESULTS'), 'notice' );
    } else {
        $available_cats = ipropertyHTML::getAvailableCats((int)$propid);
        $first_cat = $available_cats[0];
        $app->redirect(JRoute::_(ipropertyHelperRoute::getPropertyRoute($propid, $first_cat, true), false));
    }
}
require(JModuleHelper::getLayoutPath('mod_ip_mlssearch', $params->get('layout', 'default')));