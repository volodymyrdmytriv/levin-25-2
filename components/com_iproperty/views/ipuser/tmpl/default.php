<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
JHTML::_('behavior.tooltip');

$pspan = ($this->settings->show_propupdate) ? 6 : 5;
$sspan = ($this->settings->show_searchupdate) ? 4 : 3;
?>

<?php if ($this->params->get('show_page_heading', 1)) : ?>
    <h1>
    <?php echo $this->escape($this->params->get('page_heading')); ?>
    </h1>
<?php endif; ?>
<?php if ($this->params->get('show_ip_title') && $this->iptitle) : ?>
<div class="ip_mainheader">
    <h2><?php echo $this->iptitle; ?></h2>
</div>
<?php endif; ?>

<div id="system-message-container"></div>

<form name="adminForm" id="adminForm" action="<?php echo JRoute::_(ipropertyHelperRoute::getIpuserRoute()); ?>" method="post">
    <table class="ptable">
        <?php
        /*// display saved properties //*/
        if($this->settings->show_saveproperty):
            echo
            '<tr>
              <td colspan="2">
                <div class="property_header">
                ' . JText::_( 'COM_IPROPERTY_MY_SAVED_PROPERTIES' ) . '
                </div>
              </td>
            </tr>
            <tr>
               <td colspan="2">
                  <table width="100%" cellpadding="5" cellspacing="0" class="ip_favorites">
                    <tr>
                        <th width="35%">'.JText::_( 'COM_IPROPERTY_TITLE' ).'</strong></th>
                        <th width="20%">'.JText::_( 'COM_IPROPERTY_CITY' ).'</th>
                        <th width="20%">'.JText::_( 'COM_IPROPERTY_PRICE' ).'</th>
                        <th width="15%">'.JText::_( 'COM_IPROPERTY_SAVED' ).'</th>';
                        if($this->settings->show_propupdate){
                            echo '<th width="5%"><span class="hasTip" title="'.JText::_( 'COM_IPROPERTY_EMAIL_UPDATES' ).' :: '.JText::_( 'COM_IPROPERTY_EMAIL_UPDATES_TIP' ).'">'.JText::_( 'COM_IPROPERTY_UPDATES' ).'</span></th>';
                        }
            echo '
                        <th width="5%"><span class="hasTip" title="'.JText::_( 'COM_IPROPERTY_HELP' ).' :: '.JText::_( 'COM_IPROPERTY_HELP_TIP' ).'">'.JText::_('??').'</span></th>
                    </tr>';
                    if( $this->properties ):
                        $k = 0;
                        for($i = 0; $i < count($this->properties); $i++) :
                            $p = $this->properties[$i];
                            $thumbnail      = ($p->thumb) ? htmlentities($p->thumb.'<br />') : '';
                            $property_notes = ($p->notes || $thumbnail) ? ' class="hasTip" title="'.JText::_( 'COM_IPROPERTY_USER_NOTES' ).' :: '.$thumbnail.$p->notes.'"' : '';                            
                            $email_update   = $p->email_update ? '<input class="ip_eupdate" type="checkbox" value="1" checked onClick="listItemTask('.$p->id.',\'ipuser.unsubscribeUpdate\');" />' : '<input class="ip_eupdate" type="checkbox" value="1" onClick="listItemTask('.$p->id.',\'ipuser.unsubscribeUpdate\');"/>';

                            if( $p->state == 1 && $p->approved ): //property still exists
                                echo '<tr class="iprow'.$k.'" id="'.$p->id.'" >
                                        <td><a href="'.$p->proplink.'"'.$property_notes.'>'.$p->street_address.'</a></td>
                                        <td align="left">' . $p->city . '</td>
                                        <td align="left">' . $p->formattedprice . '</td>
                                        <td align="center">' . $p->created . '</td>';
                                        if($this->settings->show_propupdate){
                                            echo '<td align="center">' . $email_update .'</td>';
                                        }
                                echo '
                                        <td align="center"><a class="delete" href="javascript:void(0);"><img src="'.$this->ipbaseurl.'/components/com_iproperty/assets/images/delete_x.png" alt="'.JText::_( 'COM_IPROPERTY_DELETE' ).'" border="0" /></a></td>
                                     </tr>';
                            else: //property no longer available
                                echo '<tr class="iprow' . $k  . '" id="'.$p->id.'" >
                                        <td><span'.$property_notes.'>'.$p->street_address.'</span></td>
                                        <td colspan="'.($pspan - 2).'" align="center"><span class="ipblink">'.JText::_( 'COM_IPROPERTY_PROPERTY_NOT_AVAILABLE' ).'</span></td>
                                        <td id="'.$p->id.'" align="center"><a class="delete" href="javascript:void(0);"><img src="'.$this->ipbaseurl.'/components/com_iproperty/assets/images/delete_x.png" alt="'.JText::_( 'COM_IPROPERTY_DELETE' ).'" border="0" /></a></td>
                                     </tr>';
                            endif;
                            $k = 1 - $k;
                        endfor;
                   else:
                        echo '<tr class="iprow0">
                                <td colspan="'.$pspan.'" align="center">'.JText::_( 'COM_IPROPERTY_NO_RESULTS' ).'</td>
                              </tr>';
                   endif;

             echo '<tr><td colspan="'.$pspan.'"></td></tr>
                 </table>
               </td>
            </tr>';
        endif;

        /*// display saved searches //*/
        echo
        '<tr>
          <td colspan="2">
            <div class="property_header">
            '.JText::_( 'COM_IPROPERTY_MY_SAVED_SEARCHES' ).'
            </div>
          </td>
        </tr>
        <tr>
           <td colspan="2">
              <table width="100%" cellpadding="5" cellspacing="0" class="ip_favorites">
                <tr>
                    <th width="65%">' . JText::_( 'COM_IPROPERTY_TITLE' ) . '</th>
                    <th width="30%">' . JText::_( 'COM_IPROPERTY_SAVED' ) . '</th>';
                    if($this->settings->show_searchupdate){
                        echo '<th width="5%"><span class="hasTip" title="'.JText::_( 'COM_IPROPERTY_EMAIL_UPDATES' ).' :: '.JText::_( 'COM_IPROPERTY_EMAIL_UPDATES_TIP' ).'">'.JText::_( 'COM_IPROPERTY_UPDATES' ).'</span></th>';
                    }
        echo '
                    <th width="5%"><span class="hasTip" title="'.JText::_( 'COM_IPROPERTY_HELP' ).' :: '.JText::_( 'COM_IPROPERTY_HELP_TIP' ).'">'.JText::_('??').'</span></th>
                </tr>';
                if( $this->searches ):
                    $k = 0;
                    for($i = 0; $i < count($this->searches); $i++) :
                        $s = $this->searches[$i];
                        $save_notes = ($s->notes) ? ' class="hasTip" title="' . JText::_( 'COM_IPROPERTY_USER_NOTES' ) . ' :: ' . $s->notes . '"' : '';
                        $email_update = $s->email_update ? '<input class="ip_eupdate" type="checkbox" value="1" checked onClick="listItemTask('.$s->id.',\'ipuser.unsubscribeUpdate\');" />' : '<input class="ip_eupdate" type="checkbox" value="1" onClick="listItemTask('.$s->id.',\'ipuser.unsubscribeUpdate\');"/>';
                        echo '<tr class="iprow'.$k.'" id="'.$s->id.'" >
                                <td><a id="ipsavedsearchlink" href="javascript:setCookieRedirect('.$s->id.')"'.$save_notes.'>'.$s->title.'</a></td>
                                <td align="center">'.$s->created.'</td>';
                                if($this->settings->show_searchupdate){
                                    echo '<td align="center">' . $email_update .'</td>';
                                }
                        echo '
                                <td id="'.$s->id.'" align="center"><a class="delete" href="javascript:void(0);"><img src="'.$this->ipbaseurl.'/components/com_iproperty/assets/images/delete_x.png" alt="'.JText::_( 'COM_IPROPERTY_DELETE' ).'" border="0" /></a></td>
                             </tr>';
                        $k = 1 - $k;
                    endfor;
               else:
                    echo '<tr class="iprow0">
                            <td colspan="'.$sspan.'" align="center">'.JText::_( 'COM_IPROPERTY_NO_RESULTS' ).'</td>
                          </tr>';
               endif;
         echo '<tr><td colspan="'.$sspan.'"></td></tr>
             </table>';
             $this->dispatcher->trigger( 'onAfterRenderFavorites', array( &$this->user, &$this->settings ) );
         echo '
           </td>
        </tr>';
        ?>
    </table>
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="editid" value="" />
    <?php echo JHTML::_( 'form.token' ); ?>
</form>
<?php
    echo JHTML::_('behavior.keepalive');
    if( $this->settings->footer == 1):
        echo ipropertyHTML::buildThinkeryFooter();
    endif;
?>