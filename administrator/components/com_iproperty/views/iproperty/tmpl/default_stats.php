<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<div class="ip_spacer"></div>
<h1 class="ip_cpanel_header"><?php echo JText::_( 'COM_IPROPERTY_STATISTICS' ); ?></h1>
<div class="tnews_content">
    <table class="adminlist" cellspacing="1">
        <thead>
            <tr>
                <th width="100%"><?php echo JText::_( 'COM_IPROPERTY_STATISTICS' ); ?></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="6">
                    &nbsp;
                </td>
            </tr>
        </tfoot>
        <tbody>
            <tr class="row0">
                <td valign="top">
                    <?php
                    echo JHtml::_('sliders.start', 'stat-pane');
                        echo JHtml::_('sliders.panel', JText::_( 'COM_IPROPERTY_TOP_PROPERTIES' ), 'stats_popular'); ?>
                        <table class="adminlist" cellspacing="1">
                            <thead>
                                <tr>
                                    <th width="1%"><?php echo JText::_( 'COM_IPROPERTY_ID' ); ?></th>
                                    <th width="40%"><?php echo JText::_( 'COM_IPROPERTY_TITLE' ); ?></th>
                                    <th width="30%"><?php echo JText::_( 'COM_IPROPERTY_COMPANY' ); ?></th>
                                    <th width="10%"><?php echo JText::_( 'COM_IPROPERTY_HITS' ); ?></th>
                                    <th width="10%"><?php echo JText::_( 'COM_IPROPERTY_SAVED' ); ?></th>
                                    <th width="10%"><?php echo JText::_( 'COM_IPROPERTY_EDIT' ); ?></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <td colspan="6">
                                        &nbsp;
                                    </td>
                                </tr>
                            </tfoot>
                            <tbody>
                            <?php
                            $k = 0;
                            if($this->tproperties){
                                foreach($this->tproperties as $t){
                                    $tlink = JRoute::_('index.php?option=com_iproperty&task=property.edit&id='.$t->id);
                                    $tlisting_office = ipropertyHTML::getCompanyName($t->listing_office);
                                    if(!$this->settings->street_num_pos){ //street number before street
                                        $ttitle = '<a href="' . $tlink . '">'.$t->street_num.' '.$t->street.' '.$t->street2.'</a>';
                                        if($t->title) $ttitle .= '<br />'.$t->title;
                                    }else{ //street number after street
                                        $ttitle = '<a href="' . $tlink . '">'.$t->street.' '.$t->street2.' '.$t->street_num.'</a>';
                                        if($t->title) $ttitle .= '<br />'.$t->title;
                                    }
                                    echo '
                                    <tr class="row'.$k.'">
                                        <td align="center">'.$t->id.'</td>
                                        <td>'.$ttitle.'</td>
                                        <td>'.(($tlisting_office) ? $tlisting_office : '--').'</td>
                                        <td align="center">'.(($t->hits) ? $t->hits : '--').'</td>
                                        <td align="center">'.(($t->saved) ? $t->saved : '--').'</td>
                                        <td align="center"><a href="' . $tlink . '"><img src="components/com_iproperty/assets/images/edit.gif" alt="edit" border="0" /></a></td>
                                    </tr>';
                                    $k = 1 - $k;
                                }
                            }else{
                                echo '
                                <tr class="row'.$k.'">
                                    <td colspan="6" align="center">'.JText::_( 'COM_IPROPERTY_NO_RESULTS' ).'</td>
                                </tr>';
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php echo JHtml::_('sliders.panel', JText::_( 'COM_IPROPERTY_FEATURED_PROPERTIES' ), 'stats_featured'); ?>
                        <table class="adminlist" cellspacing="1">
                            <thead>
                                <tr>
                                    <th width="1%"><?php echo JText::_( 'COM_IPROPERTY_ID' ); ?></th>
                                    <th width="40%"><?php echo JText::_( 'COM_IPROPERTY_TITLE' ); ?></th>
                                    <th width="30%"><?php echo JText::_( 'COM_IPROPERTY_COMPANY' ); ?></th>
                                    <th width="10%"><?php echo JText::_( 'COM_IPROPERTY_HITS' ); ?></th>
                                    <th width="10%"><?php echo JText::_( 'COM_IPROPERTY_SAVED' ); ?></th>
                                    <th width="10%"><?php echo JText::_( 'COM_IPROPERTY_EDIT' ); ?></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <td colspan="6">
                                        &nbsp;
                                    </td>
                                </tr>
                            </tfoot>
                            <tbody>
                            <?php
                            $k = 0;
                            if($this->fproperties){
                                foreach($this->fproperties as $f){
                                    $flink = JRoute::_('index.php?option=com_iproperty&task=property.edit&id='.$f->id);
                                    $flisting_office = ipropertyHTML::getCompanyName($f->listing_office);
                                    if(!$this->settings->street_num_pos){ //street number before street
                                        $ftitle = '<a href="' . $flink . '">'.$f->street_num.' '.$f->street.' '.$f->street2.'</a>';
                                        if($f->title) $ftitle .= '<br />'.$f->title;
                                    }else{ //street number after street
                                        $ftitle = '<a href="' . $flink . '">'.$f->street.' '.$f->street2.' '.$f->street_num.'</a>';
                                        if($f->title) $ftitle .= '<br />'.$f->title;
                                    }
                                    echo '
                                    <tr class="row'.$k.'">
                                        <td align="center">'.$f->id.'</td>
                                        <td>'.$ftitle.'</td>
                                        <td>'.(($flisting_office) ? $flisting_office : '--').'</td>
                                        <td align="center">'.(($f->hits) ? $f->hits : '--').'</td>
                                        <td align="center">'.(($f->saved) ? $f->saved : '--').'</td>
                                        <td align="center"><a href="' . $flink . '"><img src="components/com_iproperty/assets/images/edit.gif" alt="edit" border="0" /></a></td>
                                    </tr>';
                                    $k = 1 - $k;
                                }
                            }else{
                                echo '
                                <tr class="row'.$k.'">
                                    <td colspan="6" align="center">'.JText::_( 'COM_IPROPERTY_NO_RESULTS' ).'</td>
                                </tr>';
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php echo JHtml::_('sliders.panel', JText::_( 'COM_IPROPERTY_MOST_ACTIVE_USERS' ), 'stats_activeusers'); ?>
                        <table class="adminlist" cellspacing="1">
                            <thead>
                                <tr>
                                    <th width="1%"><?php echo JText::_( 'COM_IPROPERTY_ID' ); ?></th>
                                    <th width="20%"><?php echo JText::_( 'COM_IPROPERTY_NAME' ); ?></th>
                                    <th width="20%"><?php echo JText::_( 'COM_IPROPERTY_USERNAME' ); ?></th>
                                    <th width="20%"><?php echo JText::_( 'COM_IPROPERTY_EMAIL' ); ?></th>
                                    <th width="20%"><?php echo JText::_( 'COM_IPROPERTY_REGISTERED' ); ?></th>
                                    <th width="10%"><?php echo JText::_( 'COM_IPROPERTY_ACTIVE' ); ?></th>
                                    <th width="10%"><?php echo JText::_( 'COM_IPROPERTY_INACTIVE' ); ?></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <td colspan="7">
                                        &nbsp;
                                    </td>
                                </tr>
                            </tfoot>
                            <tbody>
                            <?php
                            $k = 0;
                            if($this->ausers){
                                foreach($this->ausers as $a){
                                    $alink = JRoute::_('index.php?option=com_users&task=user.edit&id='.$a->id);
                                    echo '
                                    <tr class="row'.$k.'">
                                        <td align="center">'.$a->id.'</td>
                                        <td><a href="' . $alink . '">'.$a->name.'</a></td>
                                        <td>'.$a->username.'</td>
                                        <td align="center">'.$a->email.'</td>
                                        <td align="center">'.$a->registerDate.'</td>
                                        <td align="center">'.(($a->active_saves) ? $a->active_saves : '--').'</td>
                                        <td align="center">'.(($a->inactive_saves) ? $a->inactive_saves : '--').'</td>
                                    </tr>';
                                    $k = 1 - $k;
                                }
                            }else{
                                echo '
                                <tr class="row'.$k.'" style="text-align: center !important;">
                                    <td colspan="7" align="center">'.JText::_( 'COM_IPROPERTY_NO_RESULTS' ).'</td>
                                </tr>';
                            }
                            ?>
                            </tbody>
                        </table>
                    <?php echo JHtml::_('sliders.end'); ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>