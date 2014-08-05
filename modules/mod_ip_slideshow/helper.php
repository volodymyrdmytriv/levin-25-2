<?php
/**
 * @version 2.0.2 2013-03-20
 * @package Joomla
 * @subpackage Iproperty
 * @copyright (C) 2013 the Thinkery
 * @license see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
require_once(JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'helpers'.DS.'html.helper.php');
require_once(JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'helpers'.DS.'property.php');
require_once(JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'helpers'.DS.'route.php');
require_once(JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'helpers'.DS.'query.php');
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_iproperty'.DS.'classes'.DS.'admin.class.php');

class modIPSlideshowHelper
{	
	function loadScripts($params, $images) 
    {
		$doc = JFactory::getDocument();

        if(!defined('_IPSLIDESCRIPTS')){
            define('_IPSLIDESCRIPTS', true);
            $doc->addScript(JURI::root(true).'/modules/mod_ip_slideshow/assets/js/slideshow.js');
            $doc->addStyleSheet(JURI::root(true).'/modules/mod_ip_slideshow/assets/css/slideshow.css');
        }
		
		$showCaption        = $params->get( 'showCaption', 1 );
        $showPrice          = $params->get( 'showPrice', 1 );
		$width              = $params->get( 'width', 400 );
		$height             = $params->get( 'height', 300 );
		$imageDuration      = $params->get( 'imageDuration', 9000 );
		$transDuration      = $params->get( 'transDuration', 2000);
		$transType          = $params->get( 'transType', 'kenburns');
        $controller         = $params->get( 'showController', true);
        $loop               = $params->get( 'loopShow', true);
        $thumbnails         = $params->get( 'showThumbnails', true);
        $suffix             = htmlspecialchars($params->get('moduleclass_sfx'));
        $cleansuffix        = str_replace(' ', '_', $suffix); 
        
        // depending on which transition type selected, load proper script
        $sstype = '';
        switch ($transType){
            case 'none':
            default:
                //no special effects
            break;
            case 'flash':
                if(!defined('_IPSLIDESCRIPTS_FLASH')){
                    define('_IPSLIDESCRIPTS_FLASH', true);
                    $doc->addScript(JURI::root(true).'/modules/mod_ip_slideshow/assets/js/slideshow.flash.js');
                }
                $sstype = ".Flash";
            break;
            case 'kenburns':
                if(!defined('_IPSLIDESCRIPTS_KB')){
                    define('_IPSLIDESCRIPTS_KB', true);
                    $doc->addScript(JURI::root(true).'/modules/mod_ip_slideshow/assets/js/slideshow.kenburns.js');
                }
                $sstype = ".KenBurns";
            break;
            case 'push':
                if(!defined('_IPSLIDESCRIPTS_PUSH')){
                    define('_IPSLIDESCRIPTS_PUSH', true);
                    $doc->addScript(JURI::root(true).'/modules/mod_ip_slideshow/assets/js/slideshow.push.js');
                }
                $sstype = ".Push";
            break;
            case 'fold':
                if(!defined('_IPSLIDESCRIPTS_FOLD')){
                    define('_IPSLIDESCRIPTS_FOLD', true);
                    $doc->addScript(JURI::root(true).'/modules/mod_ip_slideshow/assets/js/slideshow.fold.js');
                }
                $sstype = ".Fold";
            break;
        }
		
		$imgPush           = '//<![CDATA['."\n";
        $imgPush            .= "window.addEvent('domready', function() {\n";
		$imgPush            .= "	var imgs".$cleansuffix." = {"."\r\n";
		
		$i = 0;
        foreach($images as $img) {
			// new img object format for the new slideshow script:
			// var data = {'1.jpg': { caption: 'Caption', href: 'link.html' }, etc.};

            if(!strpos($img->mainimage, 'nopic')){
                $imgPush .= "		'" . $img->mainimage . "':{ ";
                $img->title = ($showPrice) ? trim($img->title).' - '.$img->formattedprice : trim($img->title);
                if ($showCaption == 1) {
                    $imgPush .= "caption: '".$img->title.' - '.trim(preg_replace( '/\s+/', ' ', $img->introtext))."', href: '".trim($img->link)."'";
                } else {
                    $imgPush .= "caption: '', href: '".trim($img->link)."'";
                }
                $imgPush .= "}";
				
				$i++;
				if($i != count($images)){
					$imgPush .= ","."\r\n";
				}else{
					$imgPush .= "\r\n";
				}
			}
		}

		// trim off trailing comma
		//$imgPush = rtrim(',', $imgPush);
		
		$imgPush	.= "	};"."\r\n";

        $imgPush    .= "	var myshow".$cleansuffix." = new Slideshow".$sstype."( 'ip_slideshow".$cleansuffix."', imgs".$cleansuffix.", {"."\r\n";
        // options array
        $imgPush    .= "        width: $width,"."\r\n"
                    .  "        height: $height,"."\r\n"
                    .  "        delay: $imageDuration,"."\r\n"
                    .  "        duration: $transDuration,"."\r\n"
                    .  "        controller: $controller,"."\r\n"
                    .  "        loop: $loop,"."\r\n"
                    .  "        thumbnails: $thumbnails,"."\r\n"
                    .  "        captions: $showCaption,"."\r\n"
                    .  "        replace:[/(\.[^\.]+)$/, '_thumb$1']"."\r\n" // this line will append the normal IP thumb suffix
                    .  "    });"."\r\n";
        
        // any classes need to be added to "classes" array in options
        //$imgPush .= "myshow.h2.setStyles({color: '$titleColor', fontSize: '$titleSize'});";
        //        myshow.caps.p.setStyles({color: '$descColor', fontSize: '$descSize'});
        $imgPush .= "	});"."\r\n";
        $imgPush .= "//]]>"."\r\n";
					
		$doc->addScriptDeclaration($imgPush);
	}
	
    // added by the Thinkery for Intellectual Property - 06/29/2010
	function prepareContent( $text, $length=300 ) 
    {
		// strips tags won't remove the actual jscript
		$text = preg_replace( "'<script[^>]*>.*?</script>'si", "", $text );
		$text = preg_replace( '/{.+?}/', '', $text);
		// replace line breaking tags with whitespace
		$text = preg_replace( "'<(br[^/>]*?/|hr[^/>]*?/|/(div|h[1-6]|li|p|td))>'si", '', $text );
		$text = strip_tags( $text );
		if (strlen($text) > $length) $text = substr($text, 0, $length) . "...";
		return $text;
	}

    function getPropertiesList( $where, $limitstart=0, $limit=9999, $sort = 'p.title', $order = 'ASC' )
	{
		$db = JFactory::getDBO();
        $property = new ipropertyHelperproperty($db);
        $property->setType('properties');
        $property->setWhere( $where );
        $property->setOrderBy( $sort, $order );
       
        $properties = $property->getProperty($limitstart,$limit);
        
        return $properties;
	}
	
	function getList(&$params)
	{
		$count                  = (int) $params->get('count', 5);
		$text_length            = intval($params->get( 'preview_count', 75) );

        // Ordering
		switch ($params->get( 'ordering' ))
		{
			case '1':
				$sort           = 'price';
                $order          = 'ASC';
				break;
            case '2':
                $sort           = 'price';
                $order          = 'DESC';
                break;
			case '3':
				$sort           = 'p.street';
                $order		    = 'ASC';
				break;
            case '4':
				$sort           = 'p.street';
                $order		    = 'DESC';
				break;
            case '5':
            default:
                $sort           = 'RAND()';
                $order          = '';
                break;
            case '6':
                $sort           = 'p.created';
                $order          = 'DESC';
                break;
		}

        $where = array();   
        //specific stype - added 2.0.1
        if($params->get('prop_stype')) $where[] = 'p.stype = '.(int)$params->get('prop_stype');
        //update 2.0.1 - new option to select subcategories as well
        if($params->get('cat_id') && $params->get('cat_subcats')){
            $db = JFactory::getDbo();
            
            $cats_array = array( $params->get('cat_id') );
            $squery = $db->setQuery(IpropertyHelperQuery::getCategories($params->get('cat_id')));
            $subcats = $db->loadObjectList();
            
            foreach($subcats as $s){
                $cats_array[] = (int)$s->id;
            }
            $where[] = "pm.cat_id IN (".(implode(',', $cats_array)).")";
        }elseif( $params->get('cat_id')){
            $where[] = 'pm.cat_id = '.$params->get('cat_id');
        }
        if( $params->get('showFeatured')) $where[] = 'p.featured = 1';
        
        $rows = modIPSlideshowHelper::getPropertiesList($where,0,$count, $sort, $order);

        $i		= 0;
        $lists	= array();
        if( $rows ){
			
            foreach ( $rows as $row )
            {
                $available_cats = ipropertyHTML::getAvailableCats($row->id);
                $first_cat      = $available_cats[0];
                $lists[$i]      = new stdClass();

                $lists[$i]->link            = JRoute::_(ipropertyHelperRoute::getPropertyRoute($row->id.':'.$row->prop_alias, $first_cat, true), false);
                $lists[$i]->mainimage       = ipropertyHTML::getThumbnail($row->id, '', '', $params->get('width', 500), '', '', false, false);
                $lists[$i]->title  			= htmlspecialchars( addslashes($row->street_address) );

                $prepared_text = modIPSlideshowHelper::prepareContent($row->short_description, $params->get('preview_count', 250));
                $prepared_text = addslashes($prepared_text);
                if($params->get('clean_desc')){
                    $lists[$i]->introtext = ipropertyHTML::sentence_case($prepared_text);
                }else{
                    $lists[$i]->introtext = $prepared_text;
                }
                $lists[$i]->formattedprice = $row->formattedprice;
                $i++;

                $prepared_text = '';
            }
        }

		return $lists;
	}	
}
