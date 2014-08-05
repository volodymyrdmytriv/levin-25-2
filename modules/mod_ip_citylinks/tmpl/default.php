<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Iproperty
 * @copyright (C) 2013 the Thinkery
 * @license see LICENSE.php
 */

//no direct access
defined('_JEXEC') or die('Restricted access');

echo '
    <div class="ipcitylist" style="height:'.$params->get('height', 400).'px; overflow: auto;">
        <ul class="ipcitylist'.$moduleclass_sfx.'">';
            foreach ($list as $l)
            {
                if($cat){
                    $link = ipropertyHelperRoute::getCatRoute($cat);
                    $link .= '&ipquicksearch=1';
                    $link .= '&city='.urlencode($l->city);
                }else{
                    $link = ipropertyHelperRoute::getAllPropertiesRoute();
                    $link .= '&ipquicksearch=1';
                    $link .= '&city='.urlencode($l->city);
                }
                $link       = JRoute::_($link);
                $cityword   = ucwords(strtolower($l->city));
                $cityword   = ($pretext) ? $pretext.' '.$cityword : $cityword;
                $cityword   = ($posttext) ? $cityword.' '.$posttext : $cityword;
                $cityword   = ($count) ? $cityword.' ('.$l->count.')' : $cityword;

                echo '<li class="ipcitylist_city"><a href="'.stripslashes($link).'">'.$cityword.'</a></li>';
            }
echo '
        </ul>
    </div>';
?>
