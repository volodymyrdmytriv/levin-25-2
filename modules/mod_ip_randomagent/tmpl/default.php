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
<div style="position: relative;" class="ip_agentmod_holder">
    <table width="100%" cellpadding="5" cellspacing="1" class="ip_agentmod_table">
        <?php
           if( $params->get('iplayout', 1) == 1 ): //horizontal layout
                for($i = 0; $i < sizeof($list); $i++):
                    echo '<tr>
                             <td width="10%" valign="top">
                               <div class="ip_randomagent_thumb" style="position: relative; width: '.$thumb_width.' !important; height: '.$thumb_height.' !important; border: solid 1px '.$params->get( 'border_color', '#fff' ).'; overflow:hidden !important;">
                                    <a href="'.$list[$i]->link.'"><img src="'.$list[$i]->mainimage.'" width="'.$params->get('thumb_width').'" alt="'.$list[$i]->name.'" /></a>
                               </div>
                             </td>
                             <td width="90%" valign="top">
                               <div class="ip_randomagent_overview" style="margin-top: 5px;">';
                                    echo '<p>';
                                    echo '<a href="' . $list[$i]->link . '" class="ip_randomagent_title">' . $list[$i]->name . '</a><br />';
                                    if($list[$i]->company) echo '<a href="' . $list[$i]->clink . '" class="ip_agent_title">' . $list[$i]->company . '</a><br />';
                                    echo '</p>';
                                    if($list[$i]->introtext && $show_bio) echo '<p>' . $list[$i]->introtext . '</p>';
                                    echo '
                               </div>
                            </td>
                          </tr>';
                endfor;
         else: //vertical layout

            echo '<tr>';
            ?>
                <?php
                $percentage = round(100 / $params->get( 'columns', 3 ));

                $x = 0;
                $br = 0;
                for( $i = 0; $i < count($list); $i++):
                    echo '<td width="'.$percentage.'%" valign="top">
                               <div class="ip_randomagent_thumb" style="position: relative; width: '.$thumb_width.' !important; height: '.$thumb_height.' !important; border: solid 1px '.$params->get( 'border_color', '#fff' ).'; overflow:hidden !important;">
                                    <a href="'.$list[$i]->link.'"><img src="'.$list[$i]->mainimage.'" width="'.$params->get('thumb_width').'" alt="'.$list[$i]->name.'" /></a>
                               </div>
                               <div class="ip_randomagent_overview" style="margin-top: 5px;">';
                                    echo '<p>';
                                    echo '<a href="' . $list[$i]->link . '" class="ip_randomagent_title">' . $list[$i]->name . '</a><br />';
                                    if($list[$i]->company) echo '<a href="' . $list[$i]->clink . '" class="ip_agent_title">' . $list[$i]->company . '</a><br />';
                                    echo '</p>';
                                    if($list[$i]->introtext && $show_bio) echo '<p>' . $list[$i]->introtext . '</p>';
                                    echo '
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
            echo '</tr>';
        endif; ?>
    </table>
</div>
