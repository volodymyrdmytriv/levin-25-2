<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die;

class JHtmlIcon
{
	static function create($type = 'property')
	{
		$uri = JFactory::getURI();
        
        switch($type){
            case 'property':
                $controller = 'propform';
                break;
            case 'agent':
                $controller = 'agentform';
                break;
            case 'company':
                $controller = 'companyform';
                break;
        }

		$url = 'index.php?option=com_iproperty&view='.$controller.'&task='.$controller.'.add&return='.base64_encode($uri).'&id=0';
		$text = JHtml::_('image','system/new.png', JText::_('JNEW'), NULL, true);

		$button =  JHtml::_('link',JRoute::_($url), $text);

		$output = '<span class="hasTip" title="'.JText::_('COM_IPROPERTY_CREATE_ITEM').'">'.$button.'</span>';
		return $output;
	}

	static function edit($object, $type = 'property', $text_only = false, $show_over = true)
	{
		// Initialise variables.
		$user	= JFactory::getUser();
		$userId	= $user->get('id');
		$uri	= JFactory::getURI();

		// Ignore if the state is negative (trashed).
		if ($object->state < 0) {
			return;
		}
        
        switch($type){
            case 'property':
                $controller = 'propform';
                $checkin    = 'checkinProp';
                break;
            case 'agent':
                $controller = 'agentform';
                $checkin    = 'checkinAgent';
                break;
            case 'company':
                $controller = 'companyform';
                $checkin    = 'checkinCompany';
                break;
        }

		JHtml::_('behavior.tooltip');

		// Show checked_out icon if the article is checked out by a different user
		if (property_exists($object, 'checked_out') && property_exists($object, 'checked_out_time') && $object->checked_out > 0 && $object->checked_out != $user->get('id')) {
			$checkoutUser = JFactory::getUser($object->checked_out); 
            $url	= 'index.php?option=com_iproperty&view='.$controller.'&task='.$controller.'.'.$checkin.'&id='.$object->id.'&return='.base64_encode($uri).'&'.JUtility::getToken().'=1';
            
            if($text_only){
                $button = JHtml::_('link',JRoute::_($url), JText::_('JLIB_HTML_CHECKED_OUT'));
            }else{
                $button = JHtml::_('link',JRoute::_($url), JHtml::_('image','system/checked_out.png', NULL, NULL, true));
            }
            //echo $object->checked_out_time;
            $date			= addslashes(htmlspecialchars(JHtml::_('date', $object->checked_out_time, JText::_('DATE_FORMAT_LC')), ENT_COMPAT, 'UTF-8'));
            $time			= addslashes(htmlspecialchars(JHtml::_('date', $object->checked_out_time, 'H:i'), ENT_COMPAT, 'UTF-8'));
			//$date   = JHtml::_('date',$object->checked_out_time);            
            
			$tooltip = JText::_('JLIB_HTML_CHECKED_OUT').' :: '.JText::sprintf('COM_IPROPERTY_CHECKED_OUT_BY', $checkoutUser->name).'<br />'.$date.'<br />'.$time;
			return '<span class="hasTip" title="'.htmlspecialchars($tooltip, ENT_COMPAT, 'UTF-8').'">'.$button.'</span>';
		}

		$url	= 'index.php?option=com_iproperty&view='.$controller.'&task='.$controller.'.edit&id='.$object->id.'&return='.base64_encode($uri);
		
        if($text_only){
            $text = JText::_('JGLOBAL_EDIT');
        }else{
            $icon	= $object->state ? 'edit.png' : 'edit_unpublished.png';
            $text	= JHtml::_('image','system/'.$icon, JText::_('JGLOBAL_EDIT'), NULL, true);
        }

		if ($object->state == 0) {
			$overlib = JText::_('JUNPUBLISHED');
		}
		else {
			$overlib = JText::_('JPUBLISHED');
		}

		if($type == 'property' && $show_over){
            $date = JHtml::_('date',$object->created);
            $author = $object->created_by ? $object->created_by : 'Admin';

            $overlib .= '&lt;br /&gt;';
            $overlib .= $date;
            $overlib .= '&lt;br /&gt;';
            $overlib .= JText::sprintf('COM_IPROPERTY_CREATED_BY', htmlspecialchars($author, ENT_COMPAT, 'UTF-8'));
        }

		$button = JHtml::_('link', JRoute::_($url), $text);

		if($show_over){
            $output = '<span class="hasTip" title="'.JText::_('JGLOBAL_EDIT').' :: '.$overlib.'">'.$button.'</span>';
        }else{
            $output = $button;
        }
		return $output;
	}
}