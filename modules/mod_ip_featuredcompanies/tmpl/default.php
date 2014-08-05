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

                    echo '<tr>
                             <td width="10%" valign="top">
                               <div class="ip_featuredcompanies_thumb" style="position: relative; width: '.$thumb_width.' !important; height: '.$thumb_height.' !important; border: solid 1px '.$params->get( 'border_color', '#fff' ).'; overflow:hidden !important;">
                                    <a href="'.$list[$i]->link.'"><img src="'.$list[$i]->mainimage.'" width="'.$params->get('thumb_width').'" alt="'.htmlspecialchars($list[$i]->name).'" /></a>
                               </div>
                             </td>
                             <td width="90%" valign="top">
                               <div class="ip_featuredcompanies_overview" style="margin-top: 5px;">
                                    <a href="' . $list[$i]->link . '" class="ip_featuredcompanies_title">' . $list[$i]->name . '</a>';
                                    echo '<br />';
                                    if($list[$i]->introtext && $show_desc) echo '<p>' . $list[$i]->introtext . '</p>';
                                    echo '<br />
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

                    echo '<td width="'.$percentage.'%" valign="top">
                               <div class="ip_featuredcompanies_thumb" style="position: relative; width: '.$thumb_width.' !important; height: '.$thumb_height.' !important; border: solid 1px '.$params->get( 'border_color', '#fff' ).'; overflow:hidden !important;">
                                    <a href="'.$list[$i]->link.'"><img src="'.$list[$i]->mainimage.'" width="'.$params->get('thumb_width').'" alt="'.htmlspecialchars($list[$i]->name).'" /></a>
                               </div>
                               <div class="ip_featuredcompanies_overview" style="margin-top: 5px;">
                                    <a href="' . $list[$i]->link . '" class="ip_featuredcompanies_title">' . $list[$i]->name . '</a>';
                                    echo '<br />';
                                    if($list[$i]->introtext && $show_desc) echo '<p>' . $list[$i]->introtext . '</p>';
                                    echo '<br />
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
