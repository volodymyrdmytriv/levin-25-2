<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Iproperty
 * @copyright (C) 2013 the Thinkery
 * @license see LICENSE.php
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
?>
<div style="position: relative;" class="ip_featuredmod_holder<?php echo $moduleclass_sfx; ?>">
    <table width="100%" cellpadding="5" cellspacing="1" class="ip_featuredmod_table">
        <?php
           if( $params->get('iplayout', 1) == 1 ): //horizontal layout
                for($i = 0; $i < sizeof($list); $i++):

                    /* BANNER DISPLAY */
                    if($params->get('show_banners', 1) == 1){
                        $new = ipropertyHTML::isNew($list[$i]->created, $settings->new_days);
                        $updated = ipropertyHTML::isNew($list[$i]->modified, $settings->updated_days);
                        $banner_display = ipropertyHTML::displayBanners($list[$i]->stype, $new, JURI::root(true), $settings, $updated);
                    }else{
                        $banner_display = '';
                    }
                    /* END BANNER DISPLAY */

                    echo '<tr>
                             <td width="10%" valign="top">
                               <div class="ip_featured_thumb" style="position: relative; width: '.$thumb_width.' !important; height: '.$thumb_height.' !important; border: solid 1px '.$params->get( 'border_color', '#fff' ).'; overflow:hidden !important;">
                                    '.$list[$i]->mainimage.$banner_display.'
                               </div>
                             </td>
                             <td width="90%" valign="top">
                               <div class="ip_featured_overview" style="margin-top: 5px;">
                                    <a href="' . $list[$i]->link . '" class="ip_featured_title">' . $list[$i]->street_address . '</a> - ';
                                    echo '<em>';
                                    if($list[$i]->city) echo $list[$i]->city;
                                    if($list[$i]->state) echo ', '.$list[$i]->state;
                                    if($list[$i]->province) echo ', '.$list[$i]->province;
                                    echo '</em>';
                                    if($list[$i]->introtext && $show_desc) echo '<p>' . $list[$i]->introtext . '</p>';
                                    echo '<br />
                                    <b>' . $list[$i]->formattedprice . '</b>
                               </div>
                            </td>
                          </tr>';
                endfor;
         else: //vertical layout
         ?>
            <tr>
                <?php
                $percentage = round(100 / $params->get( 'columns', 3 ));

                $x = 0;
                $br = 0;
                for($i = 0; $i < count($list); $i++):

                    /* BANNER DISPLAY */
                    if($params->get('show_banners', 1) == 1){
                        $new = ipropertyHTML::isNew($list[$i]->created, $settings->new_days);
                        $updated = ipropertyHTML::isNew($list[$i]->modified, $settings->updated_days);
                        $banner_display = ipropertyHTML::displayBanners($list[$i]->stype, $new, JURI::root(true), $settings, $updated);
                    }else{
                        $banner_display = '';
                    }
                    /* END BANNER DISPLAY */

                    echo '<td width="'.$percentage.'%" valign="top">
                               <div class="ip_featured_thumb" style="position: relative; width: '.$thumb_width.' !important; height: '.$thumb_height.' !important; border: solid 1px '.$params->get( 'border_color', '#fff' ).'; overflow:hidden !important;">
                                    '.$list[$i]->mainimage.$banner_display.'
                               </div>
                               <div class="ip_featured_overview" style="margin-top: 5px;">';
                                    echo '<p>';
                                    echo '<a href="' . $list[$i]->link . '" class="ip_featured_title">' . $list[$i]->street_address . '</a><br />';
                                    echo '<em>';
                                    if($list[$i]->city) echo $list[$i]->city;
                                    if($list[$i]->state) echo ', '.$list[$i]->state;
                                    if($list[$i]->province) echo ', '.$list[$i]->province;
                                    echo '</em>';
                                    echo '</p>';
                                    if($list[$i]->introtext && $show_desc) echo '<p>' . $list[$i]->introtext . '</p>';
                                    echo '<b>' . $list[$i]->formattedprice . '</b>
                               </div>
                          </td>';
                    $x++;

                    if( $x == $params->get('columns', 3) && ($i != sizeof($list) - 1)){
                        echo '</tr><tr>';
                        $x = 0;
                    }

                    if( $x < $params->get('columns', 3) && $i == sizeof($list)){
                        if( $x < $params->get('columns', 3)){
                            echo '<td width="'.$percentage.'%" valign="top">&nbsp;</td>';
                            $x++;
                        }
                    }
                endfor;
                ?>
            </tr>
        <?php endif; ?>
    </table>
</div>