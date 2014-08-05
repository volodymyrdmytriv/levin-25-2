<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// default button definitions
$tick_icon 		= JHTML::_('image.site', 'tick.png','/components/com_iproperty/assets/images/','','');
$tick_icon_dis 	= JHTML::_('image.site', 'tick_disabled.png','/components/com_iproperty/assets/images/','','');
$pub_x_icon		= JHTML::_('image.site', 'publish_x.png','/components/com_iproperty/assets/images/','','');
$pub_x_icon_dis	= JHTML::_('image.site', 'publish_x_disabled.png','/components/com_iproperty/assets/images/','','');
?>
<div id="system-message-container"></div>

<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<h1>
	<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
<?php endif; ?>
<div class="ip_mainheader">
    <h2><?php echo $this->iptitle; ?></h2>
</div>
<?php
	// main agent display
	if( $this->agent ):
		$this->k = 1;        
		$this->agents_folder = $this->ipbaseurl.'/media/com_iproperty/agents/';
		$this->agent_photo_width = $this->settings->agent_photo_width ? $this->settings->agent_photo_width : 90;
		// build agent display
		echo '<table class="ptable">';
        echo $this->loadTemplate('agent');
        echo '</table>'; // end hero unit container
	elseif( !$this->ipauth->getAdmin() ):
		// redirect to home page if not admin or agent
		$this->app->redirect(JURI::root);
	endif;
	
	// start tabs pane
	echo JHtml::_('tabs.start', 'managePane', array('useCookie' => true));
    
    // build the properties display	
    echo JHtml::_('tabs.panel', JText::_('COM_IPROPERTY_PROPERTIES'), 'propspanel');
    if( $this->ipauth->canAddProp() ) echo '<div align="right">'.JHtml::_('icon.create', 'property').'</a></div>';
    echo '<div class="ip_prop_container">
            <h3>'.JText::_('COM_IPROPERTY_PROPERTIES').'</h3>
            <table class="ptable bordered-table zebra-striped" width="100%">
                <thead>
                    <tr>
                        <th width="5%">'.JText::_('JGRID_HEADING_ID').'</th>
                        <th width="40%">'.JText::_('COM_IPROPERTY_ADDRESS').'</th>
                        <th width="20%">'.JText::_('COM_IPROPERTY_AGENT').'</th>
                        <th width="10%">'.JText::_('COM_IPROPERTY_APPROVED').'</th>
                        <th width="10%">'.JText::_('COM_IPROPERTY_FEATURE').'</th>
                        <th width="10%">'.JText::_('COM_IPROPERTY_PUBLISH').'</th>
                        <th width="10%">'.JText::_('COM_IPROPERTY_DELETE').'</th>
                    </tr>
                </thead>
                <tbody>';
                    if( $this->properties ):                           
                        $k = 0;
                        foreach( $this->properties as $p ){
                            // build buttons
                            $approved_icon 		= $p->approved ? $tick_icon : $pub_x_icon;
                            $approved_icon_dis 	= $p->approved ? $tick_icon_dis : $pub_x_icon_dis;
                            $feat_icon          = $p->featured ? $tick_icon : $pub_x_icon;
                            $feat_icon_dis      = $p->featured ? $tick_icon_dis : $pub_x_icon_dis;                            
                            $publ_icon          = $p->state ? $tick_icon : $pub_x_icon;                            
                            $publ_icon_dis      = $p->state ? $tick_icon_dis : $pub_x_icon_dis;

                            $approved 		= $p->approved ? 'tick' : '';
                            $featured 		= $p->featured ? 'tick' : '';
                            $published 		= $p->state ? 'tick' : '';                            

                            // build agent
                            $p_agents = null;
                            foreach (ipropertyHTML::getAvailableAgents($p->id) as $p_a){
                                $p_agents .= $p_a->agent_name . '<br />';
                            }

                            $prop_address = $p->street_address;
                            if($p->city) $prop_address .= ', '.$p->city;
                            if($p->locstate) $prop_address .= ' - '.ipropertyHTML::getStateName($p->locstate);

                            // check permissions per listing just in case and create buttons
                            $edit 		= $this->ipauth->canEditProp($p->id) ? JHtml::_('icon.edit', $p, 'property', true, false).' &nbsp;|&nbsp;' : '';
                            $approve 	= $this->ipauth->canApproveProp($p->id, ($p->approved) ? 0 : 1, false) ? '<a class="alter approve property '.$approved.'" href="javascript:void(0);">'.$approved_icon.'</a>' : $approved_icon_dis;
                            $feature 	= $this->ipauth->canFeatureProp($p->id, ($p->featured) ? 0 : 1, false) ? '<a class="alter feature property '.$featured.'" href="javascript:void(0);">'.$feat_icon.'</a>' : $feat_icon_dis;
                            $delete		= $this->ipauth->canDeleteProp($p->id) ? '<a class="delete property" href="javascript:void(0);">'.$pub_x_icon.'</a>' : $pub_x_icon_dis;
                            $publish 	= $this->ipauth->canEditProp($p->id, ($p->state) ? 0 : 1, false) ? '<a class="alter publish property '.$published.'" href="javascript:void(0);">'.$publ_icon.'</a>' : $publ_icon_dis;
                            $prop_title = ($p->title) ? '<br /><small>'.$p->title.'</small>' : '';
                            $mls_id     = ($p->mls_id) ? '<br /><b>'.JText::_('COM_IPROPERTY_MLS_ID').':</b> '.$p->mls_id : '';
                            $thumb      = ($p->thumb) ? '&nbsp;|&nbsp;<span class="hasTip" title="'.htmlentities($p->thumb).'">'.JHTML::_('image.site', 'icon-thumb.png','/components/com_iproperty/assets/images/','','','').'</span>' : '';

                            echo '<tr class="iprow'.$k.'" id="property'.$p->id.'">
                                    <td class="center">'.$p->id.'</td>
                                    <td>'.$edit.$prop_address.$prop_title.$mls_id.$thumb.'</td>
                                    <td>'.$p_agents.'</td>
                                    <td class="center">'.$approve.'</td>
                                    <td class="center">'.$feature.'</td>
                                    <td class="center">'.$publish.'</td>
                                    <td class="center">'.$delete.'</td>
                                  </tr>';

                            $k = 1 - $k;
                        }
                    else:
                        echo '<td colspan="7">'.JText::_('COM_IPROPERTY_NO_RESULTS').'</td>';
                    endif;
    echo '
                </tbody>
            </table>
        </div>';
	
	// if super agent, admin or ipACL is set to none, build agents display	
    if($this->ipauth->getSuper() || $this->ipauth->getAdmin() || $this->ipauth->getAuthLevel() == 3){
        echo JHtml::_('tabs.panel', JText::_('COM_IPROPERTY_AGENTS'), 'agentspanel');
        if( $this->ipauth->canAddAgent() ) echo '<div align="right"><a href="#">'.JHtml::_('icon.create', 'agent').'</a></div>';
        // build company agents display
        echo '<div class="ip_agent_container">
                <h3>'.JText::_('COM_IPROPERTY_AGENTS').'</h3>                
                <table class="ptable bordered-table zebra-striped" width="100%">
                    <thead>
                        <tr>
                            <th width="5%">'.JText::_('JGRID_HEADING_ID').'</th>
                            <th width="50%">'.JText::_('COM_IPROPERTY_AGENT_NAME').'</th>
                            <th width="15%">'.JText::_('COM_IPROPERTY_FEATURE').'</th>
                            <th width="15%">'.JText::_('COM_IPROPERTY_PUBLISH').'</th>
                            <th width="15%">'.JText::_('COM_IPROPERTY_DELETE').'</th>
                        </tr>
                    </thead>
                    <tbody>';
                        if( $this->agents ):
                            $k = 0;
                            foreach( $this->agents as $a ){
                                // build buttons
                                $feat_icon 		= $a->featured ? $tick_icon : $pub_x_icon;
                                $publ_icon 		= $a->state ? $tick_icon : $pub_x_icon;
                                $feat_icon_dis 	= $a->featured ? $tick_icon_dis : $pub_x_icon_dis;
                                $publ_icon_dis 	= $a->state ? $tick_icon_dis : $pub_x_icon_dis;

                                $published 		= $a->state ? 'tick' : '';
                                $featured 		= $a->featured ? 'tick' : '';

                                // check permissions per agent just in case and create buttons
                                $edit 		= $this->ipauth->canEditAgent($a->id) ? JHtml::_('icon.edit', $a, 'agent', true, false).' &nbsp;|&nbsp;' : '';
                                $feature 	= $this->ipauth->canFeatureAgent($a->id, ($a->featured) ? 0 : 1, false) ? '<a class="alter feature agent '.$featured.'" href="javascript:void(0);">'.$feat_icon.'</a>' : $feat_icon_dis;
                                $delete		= $this->ipauth->canDeleteAgent($a->id) ? '<a class="delete agent" href="javascript:void(0);">'.$pub_x_icon.'</a>' : $pub_x_icon_dis;
                                $publish 	= $this->ipauth->canPublishAgent($a->id, ($a->state) ? 0 : 1, false) ? '<a class="alter publish agent '.$published.'" href="javascript:void(0);">'.$publ_icon.'</a>' : $publ_icon_dis;

                                if($a->icon && $a->icon != 'nopic.png' && JFile::exists('media'.DS.'com_iproperty'.DS.'agents'.DS.$a->icon)){
                                    $a->icon    = '<img src="'.JURI::root().'media/com_iproperty/agents/'.$a->icon . '" alt="'.$a->name.'" class="ip_manage_agent_img" />';
                                    $thumb      = '&nbsp;|&nbsp;<span class="hasTip" title="'.htmlentities($a->icon).'">'.JHTML::_('image.site', 'icon-thumb.png','/components/com_iproperty/assets/images/','','','').'</span>';
                                }else{
                                    $thumb = '';
                                }                           

                                echo '<tr class="iprow'.$k.'" id="agent'.$a->id.'">
                                        <td class="center">'.$a->id.'</td>
                                        <td>'.$edit.$a->name.$thumb.'</td>
                                        <td class="center">'.$feature.'</td>
                                        <td class="center">'.$publish.'</td>
                                        <td class="center">'.$delete.'</td>
                                     </tr>';

                                $k = 1 - $k;
                            }
                    else:
                        echo '<td colspan="5">'.JText::_('COM_IPROPERTY_NO_RESULTS').'</td>';
                    endif;
        echo '
                    </tbody>
                </table>
            </div>'; 
    }//end agent if
        
    
    // if super agent, admin or ipACL is set to none, build agents display	
    if($this->ipauth->getSuper() || $this->ipauth->getAdmin() || $this->ipauth->getAuthLevel() == 3){
		echo JHtml::_('tabs.panel', JText::_('COM_IPROPERTY_COMPANIES'), 'companiespanel');
        if( $this->ipauth->canAddCompany() ) echo '<div align="right">'.JHtml::_('icon.create', 'company').'</a></div>';
        // build company agents display
		echo '<div class="ip_company_container">
                <h3>'.JText::_('COM_IPROPERTY_COMPANIES').'</h3>                
                <table class="ptable bordered-table zebra-striped" width="100%">
                    <thead>
                        <tr>
                            <th width="5%">'.JText::_('JGRID_HEADING_ID').'</th>
                            <th width="50%">'.JText::_('COM_IPROPERTY_COMPANY').'</th>
                            <th width="15%">'.JText::_('COM_IPROPERTY_FEATURE').'</th>
                            <th width="15%">'.JText::_('COM_IPROPERTY_PUBLISH').'</th>
                            <th width="15%">'.JText::_('COM_IPROPERTY_DELETE').'</th>
                        </tr>
                    </thead>
                    <tbody>';
                        if( $this->companies ):
                            $k = 0;
                            foreach( $this->companies as $c ){
                                // build buttons
                                $feat_icon 		= $c->featured ? $tick_icon : $pub_x_icon;
                                $publ_icon 		= $c->state ? $tick_icon : $pub_x_icon;
                                $feat_icon_dis 	= $c->featured ? $tick_icon_dis : $pub_x_icon_dis;
                                $publ_icon_dis 	= $c->state ? $tick_icon_dis : $pub_x_icon_dis;

                                $published 		= $c->state ? 'tick' : '';
                                $featured 		= $c->featured ? 'tick' : '';

                                // check permissions per agent just in case and create buttons
                                $edit 		= $this->ipauth->canEditCompany($c->id) ? JHtml::_('icon.edit', $c, 'company', true, false).' &nbsp;|&nbsp;' : '';
                                $feature 	= $this->ipauth->canFeatureCompany($c->id) ? '<a class="alter feature company '.$featured.'" href="javascript:void(0);">'.$feat_icon.'</a>' : $feat_icon_dis;
                                $delete		= $this->ipauth->canDeleteCompany($c->id) ? '<a class="delete company" href="javascript:void(0);">'.$pub_x_icon.'</a>' : $pub_x_icon_dis;
                                $publish 	= $this->ipauth->canPublishCompany($c->id) ? '<a class="alter publish company '.$published.'" href="javascript:void(0);">'.$publ_icon.'</a>' : $publ_icon_dis;

                                if($c->icon && $c->icon != 'nopic.png' && JFile::exists('media'.DS.'com_iproperty'.DS.'companies'.DS.$c->icon)){
                                    $c->icon    = '<img src="'.JURI::root().'media/com_iproperty/companies/'.$c->icon . '" alt="'.$c->name.'" class="ip_manage_company_img" />';
                                    $thumb      = '&nbsp;|&nbsp;<span class="hasTip" title="'.htmlentities($c->icon).'">'.JHTML::_('image.site', 'icon-thumb.png','/components/com_iproperty/assets/images/','','','').'</span>';
                                }else{
                                    $thumb = '';
                                }

                                echo '<tr class="iprow'.$k.'" id="company'.$c->id.'">
                                        <td class="center">'.$c->id.'</td>
                                        <td>'.$edit.$c->name.$thumb.'</td>
                                        <td class="center">'.$feature.'</td>
                                        <td class="center">'.$publish.'</td>
                                        <td class="center">'.$delete.'</td>
                                     </tr>';

                                $k = 1 - $k;
                            }
                        else:
                            echo '<td colspan="5">'.JText::_('COM_IPROPERTY_NO_RESULTS').'</td>';
                        endif;                            
        echo '
                    </tbody>
                </table>
            </div>';
    }
    echo JHTML::_('tabs.end');
?>
<?php
    echo JHTML::_('behavior.keepalive');
    if( $this->settings->footer == 1):
        echo ipropertyHTML::buildThinkeryFooter();
    endif;
?>