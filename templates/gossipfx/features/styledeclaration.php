<?php
/**
* @version   $Id: styledeclaration.php 4699 2012-10-29 19:14:22Z james $
 * @author		RocketTheme http://www.rockettheme.com
 * @copyright 	Copyright (C) 2007 - 2012 RocketTheme, LLC
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */
defined('JPATH_BASE') or die();

gantry_import('core.gantryfeature');

class GantryFeatureStyleDeclaration extends GantryFeature {
    var $_feature_name = 'styledeclaration';

    function isEnabled() {
        /** @var $gantry Gantry */
		global $gantry;
        $menu_enabled = $this->get('enabled');

        if (1 == (int)$menu_enabled) return true;
        return false;
    }

	function init() {
        /** @var $gantry Gantry */
		global $gantry;
		$browser = $gantry->browser;

        // Colors
        $linkColor = new Color($gantry->get('linkcolor'));
        $css = 'a, ul.menu li .separator {color:'.$gantry->get('linkcolor').';}';
        $css .= '.button, .readon, .readmore, button.validate, #member-profile a, #member-registration a, .formelm-buttons button, .btn-primary {border-color:'.$linkColor->darken('20%').';}';
	
		//GossipFX
		$css .= '#rt-header {border-color:'.$gantry->get('linkcolor').';}';
		$css .= '.gf-menu.l1 > li.active {background:'.$gantry->get('linkcolor').';}';
		$css .= '#rt-top ul.menu li a:hover {color:'.$gantry->get('linkcolor').';}';
		
		//GossipFX - !important
		$css .= '#btl .btl-panel > span:hover, input.btl-buttonsubmit, button.btl-buttonsubmit, .gkIsButtons, .gkIsWrapper-gk_eSport .gkIsPreloader, .gkIsWrapper-gk_publisher figcaption, div.k2TagCloudBlock a:hover, div.k2TagCloudBlock a:focus, h4.sprocket-lists-title:hover, .weeklynews .nspArt:hover h4.nspHeader {background:'.$gantry->get('linkcolor').' !important;}';
		$css .= '#bt_ul li a:hover, div.k2TagCloudBlock a, a#gantry-totop:hover, .layout-showcase .sprocket-features-desc a.readon, .modsliderwall .caption a, div.itemHeader span.itemAuthor a:hover, div.itemAuthorLatest ul li a:hover, a.itemRelTitle:hover, div.k2ItemsBlock ul li a.moduleItemTitle:hover, div.catItemHeader span.catItemAuthor a:hover, div.catItemHeader h3.catItemTitle a:hover, div.userItemHeader h3.userItemTitle a:hover, div.tagItemHeader h2.tagItemTitle a:hover, div.genericItemHeader h2.genericItemTitle a:hover, .joomfx-contacts .email a:hover, .gkIsWrapper-gk_eSport .gkIsTextTitle a:hover, .featured .nspArt h4.nspHeader a:hover, .featured .nspArt p.nspInfo a:hover, .title5 .nspArt h4.nspHeader a:hover, .nspArt h4.nspHeader a:hover, .latest .nspArt p.nspInfo a:hover, .gkTabsWrap.vertical ol li.active, .gkTabsWrap.horizontal ol li.active, .gkTabsWrap.vertical ol li:hover, .gkTabsWrap.horizontal ol li:hover, .nspArt p.nspInfo a:hover, div.k2LatestCommentsBlock ul li a:hover, div.k2LatestCommentsBlock ul li a:focus, .sprocket-lists-item a.readon, #rt-footer ul li a:hover, #rt-copyright .rt-omega a:hover, .item-page h2 a:hover, ul.menu li a:hover, form#login-form ul li a:hover, .blog h2 a:hover, .items-more li a:hover, .login ul li a:hover, .component-content .login + div ul li a:hover, .sprocket-mosaic-filter ul li.active, .sprocket-mosaic-filter ul li:hover, .sprocket-mosaic-order ul li.active, .sprocket-mosaic-order ul li:hover, .sprocket-mosaic-item .sprocket-mosaic-title a:hover, a.sprocket-readmore:hover, a.readon1:hover, div.k2CategoriesListBlock ul li a:hover, #Kunena #ktab a:hover span, #Kunena #ktab #current a span, #Kunena a:hover, #Kunena div.k_guest b  {color:'.$gantry->get('linkcolor').' !important;}';
		$css .= '#btl .btl-panel > span:hover, input.btl-buttonsubmit, button.btl-buttonsubmit, div.itemCategory a:hover, div.itemCategory a:focus, div.itemTagsBlock ul.itemTags li a:hover, div.itemTagsBlock ul.itemTags li a:focus, div.userItemCategory a:hover, div.userItemTagsBlock ul.userItemTags li a:hover, div.tagItemCategory a:hover, div.genericItemCategory a:hover, div.itemCommentsForm form input#submitCommentButton, div.catItemReadMore a:hover, div.userItemReadMore a:hover, div.userItemCommentsLink a:hover, div.tagItemReadMore a:hover, div.genericItemReadMore a:hover, div.catItemCommentsLink a:hover, #btl-panel-profile:hover, #Kunena .kpagination span {background: '.$gantry->get('linkcolor').'; !important}'."\n";
		$css .= 'input.btl-buttonsubmit:hover, button.btl-buttonsubmit:hover {background:'.$linkColor->lighten('10%').' !important;}';
		$css .= 'div.itemCommentsForm form input#submitCommentButton:hover, #Kunena #ktop span.ktoggler {background-color: '.$linkColor->lighten('10%').'; '.$this->_createGradient('top', $linkColor->lighten('10%'), '1', '0%', $linkColor->darken('3%'), '1', '100%').' !important}'."\n";
		$css .= 'div.itemCommentsForm form input#submitCommentButton {border-color:'.$linkColor->darken('20%').' !important;}';
		$css .= '.gkIsWrapper-gk_publisher .gkIsPreloader, #Kunena .button:hover,#Kunena .kbutton:hover, #Kunena .kheader h2 {background-color:'.$gantry->get('linkcolor').' !important;}';
		$css .= '.gkIsWrapper-gk_publisher ol li:hover, .gkIsWrapper-gk_publisher ol li.active {background:'.$linkColor->lighten('20%').' !important;}';
		$css .= '.sprocket-features-desc a.readon {color:'.$linkColor->lighten('10%').' !important;}';
		$css .= '.featured .nspArt:hover img.nspImage, .sprocket-mosaic-item:hover .sprocket-mosaic-image {border-color:'.$gantry->get('linkcolor').' !important;}';
		$css .= 'div.k2LatestCommentsBlock ul li span.lcUsername {color:'.$linkColor->darken('12%').' !important;}';
		$css .= '#Kunena #ktab a:hover, #Kunena #ktab #current a {border-top: 5px solid '.$gantry->get('linkcolor').' !important;}';
		$css .= '#Kunena .kpagination span {border-color: '.$gantry->get('linkcolor').' !important;}';

		
        // Gradients
        $css .= '.button, .readon, .readmore, button.validate, #member-profile a, #member-registration a, .formelm-buttons button, .btn-primary {background-color: '.$linkColor->lighten('4%').'; '.$this->_createGradient('top', $linkColor->lighten('4%'), '1', '0%', $linkColor->darken('9%'), '1', '100%').'}'."\n";
        $css .= '.button:hover, .readon:hover, .readmore:hover, button.validate:hover, #member-profile a:hover, #member-registration a:hover, .formelm-buttons button:hover, .btn-primary:hover {background-color: '.$linkColor->lighten('10%').'; '.$this->_createGradient('top', $linkColor->lighten('10%'), '1', '0%', $linkColor->darken('3%'), '1', '100%').'}'."\n";
        $css .= '.button:active, .readon:active, .readmore:active, button.validate:active, #member-profile a:active, #member-registration a:active, .formelm-buttons button:active, .btn-primary:active {background-color: '.$linkColor->darken('2%').'; '.$this->_createGradient('top', $linkColor->darken('2%'), '1', '0%', $linkColor->lighten('8%'), '1', '100%').'}'."\n";

        // Logo
        $css .= $this->buildLogo();

	    $this->_disableRokBoxForiPhone();

        $gantry->addInlineStyle($css);
        if ($gantry->get('layout-mode')=="responsive") $gantry->addLess('mediaqueries.less');
        if ($gantry->get('layout-mode')=="960fixed") $gantry->addLess('960fixed.less');
        if ($gantry->get('layout-mode')=="1200fixed") $gantry->addLess('1200fixed.less');

	}

    function buildLogo(){
        /** @var $gantry Gantry */
		global $gantry;

        if ($gantry->get('logo-type')!="custom") return "";

        $source = $width = $height = "";

        $logo = str_replace("&quot;", '"', str_replace("'", '"', $gantry->get('logo-custom-image')));
        $data = json_decode($logo);

        if (!$data){
            if (strlen($logo)) $source = $logo;
            else return "";
        } else {
            $source = $data->path;
        }

        if (substr($gantry->baseUrl, 0, strlen($gantry->baseUrl)) == substr($source, 0, strlen($gantry->baseUrl))){
            $file = JPATH_ROOT . '/' . substr($source, strlen($gantry->baseUrl));
        } else {
            $file = JPATH_ROOT . '/' . $source;
        }

        if (isset($data->width) && isset($data->height)){
            $width = $data->width;
            $height = $data->height;
        } else {
            $size = @getimagesize($file);
            $width = $size[0];
            $height = $size[1];
        }

        if (!preg_match('/^\//', $source))
        {
            $source = JURI::root(true).'/'.$source;
        }

        $output = "";
        $output .= "#rt-logo {background: url(".$source.") 50% 0 no-repeat !important;}"."\n";
        $output .= "#rt-logo {width: ".$width."px;height: ".$height."px;}"."\n";

        $file = preg_replace('/\//i', DIRECTORY_SEPARATOR, $file);

        return (file_exists($file)) ?$output : '';
    }

    function _createGradient($direction, $from, $fromOpacity, $fromPercent, $to, $toOpacity, $toPercent){
        /** @var $gantry Gantry */
		global $gantry;
        $browser = $gantry->browser;

        $fromColor = $this->_RGBA($from, $fromOpacity);
        $toColor = $this->_RGBA($to, $toOpacity);
        $gradient = $default_gradient = '';

        $default_gradient = 'background: linear-gradient('.$direction.', '.$fromColor.' '.$fromPercent.', '.$toColor.' '.$toPercent.');';

        switch ($browser->engine) {
            case 'gecko':
                $gradient = ' background: -moz-linear-gradient('.$direction.', '.$fromColor.' '.$fromPercent.', '.$toColor.' '.$toPercent.');';
                break;

            case 'webkit':
                if ($browser->shortversion < '5.1'){

                    switch ($direction){
                        case 'top':
                            $from_dir = 'left top'; $to_dir = 'left bottom'; break;
                        case 'bottom':
                            $from_dir = 'left bottom'; $to_dir = 'left top'; break;
                        case 'left':
                            $from_dir = 'left top'; $to_dir = 'right top'; break;
                        case 'right':
                            $from_dir = 'right top'; $to_dir = 'left top'; break;
                    }
                    $gradient = ' background: -webkit-gradient(linear, '.$from_dir.', '.$to_dir.', color-stop('.$fromPercent.','.$fromColor.'), color-stop('.$toPercent.','.$toColor.'));';
                } else {
                    $gradient = ' background: -webkit-linear-gradient('.$direction.', '.$fromColor.' '.$fromPercent.', '.$toColor.' '.$toPercent.');';
                }
                break;

            case 'presto':
                $gradient = ' background: -o-linear-gradient('.$direction.', '.$fromColor.' '.$fromPercent.', '.$toColor.' '.$toPercent.');';
                break;

            case 'trident':
                if ($browser->shortversion >= '10'){
                    $gradient = ' background: -ms-linear-gradient('.$direction.', '.$fromColor.' '.$fromPercent.', '.$toColor.' '.$toPercent.');';
                } else if ($browser->shortversion <= '6'){
                    $gradient = $from;
                    $default_gradient = '';
                } else {

                    $gradient_type = ($direction == 'left' || $direction == 'right') ? 1 : 0;
                    $from_nohash = str_replace('#', '', $from);
                    $to_nohash = str_replace('#', '', $to);

                    if (strlen($from_nohash) == 3) $from_nohash = str_repeat(substr($from_nohash, 0, 1), 6);
                    if (strlen($to_nohash) == 3) $to_nohash = str_repeat(substr($to_nohash, 0, 1), 6);

                    if ($fromOpacity == 0 || $fromOpacity == '0' || $fromOpacity == '0%') $from_nohash = '00' . $from_nohash;
                    if ($toOpacity == 0 || $toOpacity == '0' || $toOpacity == '0%') $to_nohash = '00' . $to_nohash;

                    $gradient = " filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#".$to_nohash."', endColorstr='#".$from_nohash."',GradientType=".$gradient_type." );";

                    $default_gradient = '';

                }
                break;

            default:
                $gradient = $from;
                $default_gradient = '';
                break;
        }

        return  $default_gradient . $gradient;
    }

    function _HEX2RGB($hexStr, $returnAsString = false, $seperator = ','){
        $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr);
        $rgbArray = array();

        if (strlen($hexStr) == 6){
            $colorVal = hexdec($hexStr);
            $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
            $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
            $rgbArray['blue'] = 0xFF & $colorVal;
        } elseif (strlen($hexStr) == 3){
            $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
            $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
            $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
        } else {
            return false;
        }

        return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray;
    }

    function _RGBA($hex, $opacity){
        return 'rgba(' . $this->_HEX2RGB($hex, true) . ','.$opacity.')';
    }

	function _disableRokBoxForiPhone() {
		/** @var $gantry Gantry */
		global $gantry;

		if ($gantry->browser->platform == 'iphone' || $gantry->browser->platform == 'android') {
			$gantry->addInlineScript("window.addEvent('domready', function() {\$\$('a[rel^=rokbox]').removeEvents('click');});");
		}
	}
}
