<?php
/**
 * $ModDesc
 * 
 * @version   $Id: $file.php $Revision
 * @package   modules
 * @subpackage  $Subpackage.
 * @copyright Copyright (C) November 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */
// no direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once dirname(__FILE__).DS.'helper.php';
$list = modK2ScrollerHelper::processFunction( $params, $module->module );
if( !empty($list) ):
	 
	
	$tmp = $params->get( 'module_height', 'auto' );
	$moduleHeight   =  ( $tmp=='auto' ) ? 'auto' : (int)$tmp.'px';
	$tmp = $params->get( 'module_width', 'auto' );
	$moduleWidth    =  ( $tmp=='auto') ? 'auto': (int)$tmp.'px';
	$openTarget 	= $params->get( 'open_target', '_parent' ); 
	$class 			= !$params->get( 'navigator_pos', 0 ) ? '':'lof-'.$params->get( 'navigator_pos', 0 );
	$class .= ' '. ($params->get('display_button','horizontal')=='horizontal'?'lof-horizontal':'lof-vertical'); 
	$mainWidth    = (int)$params->get( 'thumbnail_width', 960 );
	$mainHeight   = (int)$params->get( 'thumbnail_height', 320 );
 
 
	$displayButton	= trim($params->get( 'display_button', '' ));
	$itemLayout 	= 'sliding-image';
	$theme		    =  $params->get( 'theme', 'basic' ); 
	$showReadmore	= $params->get( 'show_readmore', '1' );
	$showTitle 		= $params->get( 'show_title', '1' );
	$showDescription 		= $params->get( 'show_description', '1' );
	$showCaption	= $params->get( 'show_caption', '1' );
	$bgdesc 		= "#".$params->get( 'bgdesc', '000' );
 	$document = JFactory::getDocument();
	$styles = ' #unoslider'.$module->id.' {color:'."#".$params->get( 'colordesc', 'ffffff' ).' }
				#unoslider'.$module->id.' a {color:'."#".$params->get( 'colorlink', 'ffffff' ).' }	
	';
	$document->addStyleDeclaration(  $styles );
	
	$effect = $params->get("effect");
	if( (int)$params->get("effect_random")  == 0  && $effect ){
 		$effect = "'".implode("','",$effect)."'";
	}else {
		$effect = "'chess', 'flash', 'spiral_reversed', 'spiral', 'sq_appear', 'sq_flyoff', 'sq_drop', 'sq_squeeze', 'sq_random', 'sq_diagonal_rev', 'sq_diagonal', 'sq_fade_random', 'sq_fade_diagonal_rev', 'sq_fade_diagonal', 'explode', 'implode', 'fountain', 'blind_bottom', 'blind_top', 'blind_right', 'blind_left', 'shot_right', 'shot_left', 'alternate_vertical', 'alternate_horizontal', 'zipper_right', 'zipper_left', 'bar_slide_random', 'bar_slide_bottomright', 'bar_slide_bottomright', 'bar_slide_topright', 'bar_slide_topleft', 'bar_fade_bottom', 'bar_fade_top', 'bar_fade_right', 'bar_fade_left', 'bar_fade_random', 'v_slide_top', 'h_slide_right', 'v_slide_bottom', 'h_slide_left', 'stretch', 'squeez', 'fade'";	
	}
	

	
	if( $params->get("debug",0) ){
		$theme = JRequest::getVar("theme",$theme);
	}
	
	modK2ScrollerHelper::loadMediaFiles( $params, $module, $theme );
 
 
	require( JModuleHelper::getLayoutPath($module->module) );
 
	?>
	

<?php endif; ?>

