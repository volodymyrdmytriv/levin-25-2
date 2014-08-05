<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

// auto populate form fields if user is logged in
$form_username = ($this->session->get('ip_sender_name')) ? $this->session->get('ip_sender_name') : (($this->user) ? $this->user->username : '');
$form_useremail = ($this->session->get('ip_sender_email')) ? $this->session->get('ip_sender_email') : (($this->user) ? $this->user->email : '');
$this->session->set('ip_sender_name', $form_username);
$this->session->set('ip_sender_email', $form_useremail);

$agents                 = ipropertyHTML::getAvailableAgents($this->p->id);
$openhouses             = ipropertyHTML::getOpenHouses($this->p->id);
$cats                   = ipropertyHTML::getAvailableCats($this->p->id);
$property_full_address  = ipropertyHTML::getFullAddress($this->p->street_address, $this->p->city, $this->p->locstate, $this->p->province, $this->p->postcode, $this->p->country);
$gallery_tab_link       = (count($this->images) > 0 ) ? JText::_( 'COM_IPROPERTY_IMAGES' ).' <a href="'.$this->gallery_link.'"'.$this->gallery_attributes.'>('.count($this->images).')</a>' : JText::_( 'COM_IPROPERTY_IMAGES' ).' (0)';

// get listing info IF we don't have listing_info set in property
if($this->p->listing_info){
    $show_list_ag 	= false;
    $show_list_co 	= false;
    $show_created 	= false;
    $show_modified 	= false;
    $show_stype 	= false;

    $listing_info = ipropertyHTML::getListingInfo($this->p->listing_office, $agents[0]->id, $this->p->created, $this->p->modified, $this->p->stype, $show_list_ag, $show_list_co, $show_created, $show_modified, $show_stype, $this->p->listing_info);
}

//set side column if any conditions apply
$sidecol = '
        <td width="30%" valign="top" class="summary_sidecol">';
            if($this->p->available) $sidecol .= '<div class="avail_sidebar"><b>'.JText::_('COM_IPROPERTY_AVAILABLE').':</b><br /><span>'.JFactory::getDate($this->p->available)->format(JText::_('COM_IPROPERTY_DATE_FORMAT_AVAILABLE')).'</span></div>';
            if($this->p->vtour) $sidecol .= '<div class="vtour_sidebar"><a href="'.$this->p->vtour.'" target="_blank" class="vtour_link">'.JText::_( 'COM_IPROPERTY_VTOUR' ).'</a></div>';
$sidecol .= '
            <div class="ip_sidecol_address">
            <div class="ip_sidecol_mainaddress">'.$property_full_address.'</div>';
            if($this->p->county) $sidecol .= '<div class="ip_sidecol_subaddress"><span>'.JText::_( 'COM_IPROPERTY_COUNTY' ).'</span>: '. $this->p->county.'</div>';
            if($this->p->region) $sidecol .= '<div class="ip_sidecol_subaddress"><span>'.JText::_( 'COM_IPROPERTY_REGION' ).'</span>: '. $this->p->region.'</div>';
            if($this->p->stype) $sidecol .= '<div class="ip_sidecol_subaddress"><span>'.JText::_( 'COM_IPROPERTY_SALE_TYPE' ).'</span>: '. ipropertyHTML::get_stype($this->p->stype).'</div>';
            if($this->p->mls_id) $sidecol .= '<div class="ip_sidecol_subaddress"><span>'.JText::_( 'COM_IPROPERTY_REF' ).'</span>: '. $this->p->mls_id.'</div>';
            if($this->p->last_updated && $this->p->updated) $sidecol .= '<div class="ip_sidecol_subaddress"><span>'.JText::_( 'COM_IPROPERTY_LAST_MODIFIED' ).'</span>: '. $this->p->last_updated.'</div>';
            if($cats){
                $sidecol .= '<div class="ip_sidecol_categories"><span>'.JText::_( 'COM_IPROPERTY_CATEGORY' ).':</span> ';
                $catcount = 0;
                foreach( $cats as $c ){
                    $sidecol .= ipropertyHTML::getCatIcon($c, 20, false, true);
                    $catcount++;
                    if($catcount < count($cats)) $sidecol .= ', ';
                }
                $sidecol .= '</div>';
            }
            $sidecol .= '</div>';
            if($agents && $this->settings->show_agent && !$this->p->listing_info) :
                $agent_header = (count($agents) > 1) ? JText::_( 'COM_IPROPERTY_AGENTS' ) : JText::_( 'COM_IPROPERTY_AGENTS' );
                $sidecol .= '<div class="ip_sidecol_header">' . $agent_header . '</div>';
                foreach( $agents as $a ):
                    $sidecol    .= '<div class="ip_sidecol_address">';
                    $alink      = JRoute::_(ipropertyHelperRoute::getAgentPropertyRoute($a->id.':'.$a->alias));
                    $colink     = JRoute::_(ipropertyHelperRoute::getCompanyPropertyRoute($a->company.':'.$a->co_alias));
                    $agentcontactlink = JRoute::_(ipropertyHelperRoute::getContactRoute('agent',$a->id.':'.$a->alias));
                    if($a->icon && $this->settings->agent_show_image){
                        $icon = ipropertyHTML::getIconpath($a->icon, 'agent');
                        $sidecol .= '<div><div class="side_agent_photo"><a href="' . $alink . '"><img src="'.$icon . '" width="'.$this->agent_photo_width.'" border="0" alt="" /></a></div></div>';
                    }
                    $sidecol .= '<div class="side_agent_details"><a href="' . $alink . '"><b>' . ipropertyHTML::getAgentName($a->id) . '</b></a><br />';
                    $sidecol .= '<a href="' . $colink . '">' . ipropertyHTML::getCompanyName($a->companyid) . '</a><br />';
                    if($a->email && $this->settings->agent_show_email) $sidecol .= '<div class="ip_sidecol_email">' . JHTML::_('email.cloak', $a->email.'?subject='.JText::_('Re').': '.urlencode($this->p->street_address), true, $a->email) . '</div>';
                    if($a->phone && $this->settings->agent_show_phone) $sidecol .= '<div class="ip_sidecol_phone"><span class="ip_phone_container">' . $a->phone . '</span></div>';
                    if($a->mobile && $this->settings->agent_show_mobile) $sidecol .= '<div class="ip_sidecol_cell"><span class="ip_phone_container">' . $a->mobile . '</span></div>';
                    if($a->msn && $this->settings->agent_show_social) $sidecol .= '<div class="ip_sidecol_msn">' . $a->msn . '</div>';
                    if($a->skype && $this->settings->agent_show_social) $sidecol .= '<div class="ip_sidecol_skype">' . $a->skype . '</div>';
                    if($a->gtalk && $this->settings->agent_show_social) $sidecol .= '<div class="ip_sidecol_gtalk">' . $a->gtalk . '</div>';
                    if($a->linkedin && $this->settings->agent_show_social) $sidecol .= '<div class="ip_sidecol_linkedin">' . $a->linkedin . '</div>';
                    if($a->twitter && $this->settings->agent_show_social) $sidecol .= '<div class="ip_sidecol_twitter">' . $a->twitter . '</div>';
                    if($a->facebook && $this->settings->agent_show_social) $sidecol .= '<div class="ip_sidecol_facebook">' . $a->facebook . '</div>';
                    if($a->social1 && $this->settings->agent_show_social) $sidecol .= '<div class="ip_sidecol_social1">' . $a->social1 . '</div>';
                    if($a->alicense && $this->settings->agent_show_license) $sidecol .= '<div class="ip_sidecol_license">' . $a->alicense .'</div>';
                    if($a->email && $this->settings->agent_show_contact) $sidecol .= '<div class="ip_contact"><a href="' . $agentcontactlink . '">'.JText::_( 'COM_IPROPERTY_CONTACT_AGENT' ).'</a></div>';
                    $sidecol    .= '</div>';
                    $sidecol    .= '</div>';
                endforeach;
            endif;
            if($openhouses) :
                $oh_header = (count($openhouses) > 1) ? JText::_( 'COM_IPROPERTY_OPENHOUSES' ) : JText::_( 'COM_IPROPERTY_OPENHOUSES' );
                $sidecol .= '<div class="ip_sidecol_header">' . $oh_header . '</div>';
                foreach( $openhouses as $o ):
                    $tipstart   = ($o->comments) ? '<span class="hasTip" title="'.JText::_( 'COM_IPROPERTY_OPENHOUSE' ).'::'.htmlentities($o->comments).'">' : '';
                    $tipend     = ($o->comments) ? '</span>' : '';
                    //$sidecol    .= $tipstart;
                    $sidecol    .= '<div class="ip_sidecol_address">';
                    $sidecol    .= ($o->name) ? '<div class="side_oh_header">'.$tipstart.$o->name.$tipend.'</div>' : '<div class="side_oh_header">'.$tipstart.JText::_('COM_IPROPERTY_OPENHOUSE').$tipend.'</div>';
                    $sidecol    .= '<div class="side_oh_details">';
                    $sidecol    .= '<div class="ip_oh_date">'.JFactory::getDate($o->startdate)->format(JText::_('COM_IPROPERTY_DATE_FORMAT_IPOH')).'</div>';
                    $sidecol    .= '<div class="ip_oh_divider">'.JText::_( 'COM_IPROPERTY_THROUGH' ).'</div>';
                    $sidecol    .= '<div class="ip_oh_date">'.JFactory::getDate($o->enddate)->format(JText::_('COM_IPROPERTY_DATE_FORMAT_IPOH')).'</div>';
                    $sidecol    .= '</div>';
                    $sidecol    .= '</div>';
                    //$sidecol    .= $tipend;
                endforeach;
            endif;
        // add the listing agent for pro sites
        if($this->p->listing_info) $sidecol .= '<div class="side_agent_details"><span class="ipsmall">'.$listing_info.'</span></div>';
        /* TODO: Add plugin position for sidebar (under agent profile info)
         * $this->dispatcher->trigger( 'onAfterRenderSidebar', array( &$this->p, &$this->settings ) );
         */
$sidecol .= '</td>';
?>

<?php if(!JRequest::getVar('print')): ?>
    <?php if($this->settings->show_saveproperty): ?>
    <div id="save-panel">
        <?php echo $this->loadTemplate('usersave'); ?>
    </div>
    <?php endif; ?>
    <?php if($this->settings->show_mtgcalc): ?>
    <div id="calculate-panel">
        <?php echo $this->loadTemplate('calculator'); ?>
    </div>
    <?php endif; ?>
<?php endif; ?>
<div class="ip_mainheader">
    <h1>
        <?php echo $this->iptitle; ?> <span class="pe_price"><?php echo $this->p->formattedprice; ?></span>
    </h1>
</div>

<table class="ptable">
    <tr>
        <td valign="top" class="ip_mapleft">
        <?php
        echo JHtml::_('tabs.start', 'mapPane', array('useCookie' => false));
        echo JHtml::_('tabs.panel', $gallery_tab_link, 'images');
        
        // we only want the div for the mobile plugin
        if(ipropertyHTML::isMobileRequest()){
            echo '
                <div class="ip_imagetab">
                    '. ipropertyHTML::displayBanners($this->p->stype, $this->p->new, $this->ipbaseurl, $this->settings, $this->p->updated)
                    . ipropertyHTML::getThumbnail($this->p->id, $this->gallery_link, $this->p->street_address, $this->settings->tab_width, 'class="ip_imagetab_thumb"', ($this->gallery_attributes2) ? $this->gallery_attributes2 : $this->gallery_attributes, false ).'
                </div>';
        }else{
            switch($this->settings->gallerytype)
            {
                case 1:
                case 2:
                case 3:
                    echo '
                        <div class="ip_imagetab">
                            '. ipropertyHTML::displayBanners($this->p->stype, $this->p->new, $this->ipbaseurl, $this->settings, $this->p->updated)
                            . ipropertyHTML::getThumbnail($this->p->id, $this->gallery_link, $this->p->street_address, $this->settings->tab_width, 'class="ip_imagetab_thumb"', ($this->gallery_attributes2) ? $this->gallery_attributes2 : $this->gallery_attributes, false ).'
                        </div>';
                break;
                case 4:
                    echo '
                    <div id="ip_imagetab" class="slideshow">';
                        for($i = 1; $i < count($this->images); $i++){
                            $path = ($this->images[$i]->remote == 1) ? $this->images[$i]->path : $this->folder;
                            echo '<a href="'.$path.$this->images[$i]->fname.$this->images[$i]->type.'" class="modal"></a>'."\n";
                        }
                        echo '  
                        <div class="slideshow-images">
                            <div class="slideshow-loader"></div>
                        </div>
                        <div class="slideshow-captions"></div>
                        <div class="slideshow-controller"></div>
                    </div>';
                break;
            }
        }
        if($this->docs):
            echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_DOCS' ), 'docs_panel');
            ?>
                <div class="ip_doctab">
                    <?php
                    foreach( $this->docs as $d ){
                        $doc_title = ($d->title) ? $d->title : $d->fname;
                        echo '<div class="ip_sidecol_item"><a href="'.$this->folder.$d->fname.$d->type.'" target="_blank">' . $doc_title . ' - <b>[</b>'.substr($d->type,1).'<b>]</b></a></div>';
                    }
                    ?>
                </div>
            <?php
        endif;
        if($this->gmap_OK == 1):
            echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_MAP' ), 'map_panel');
            ?>
                <div id="map_canvas"></div>
            <?php
        endif;
        $this->dispatcher->trigger( 'onAfterRenderMap', array( &$this->p, &$this->settings ) );
        echo JHtml::_('tabs.end');
        ?>
        </td>
        <td width="90%" class="ip_mapright">
            <?php
              foreach( $this->extras_array as $key=>$value ):
                //fix for requests to not show details if none exist - v1.5.3
                if( $this->p->$key && $this->p->$key != '0.0' ){
                    if( (($key == 'sqft' || $key == 'lotsize' ) && is_numeric($this->p->$key)) || ($key == 'baths' && substr($this->p->$key, -3, 3) == '.00') ){
                        echo '
                        <div class="ip_' . $key . '">
                            <span class="ip_title">' . $value . '</span> ' . number_format($this->p->$key) . '
                        </div>';
                    }else{
                        echo '
                        <div class="ip_' . $key . '">
                            <span class="ip_title">' . $value . '</span> ' . $this->p->$key . '
                        </div>';
                    }
                }
              endforeach;
            ?>
        </td>
    </tr>
</table>

<table class="ptable">
    <tr>
        <td valign="top" colspan="2">
            <?php
            echo JHtml::_('tabs.start', 'detailsPane', array('useCookie' => false));
            $this->dispatcher->trigger( 'onBeforeRenderForms', array( &$this->p, &$this->settings, $sidecol ) );
            echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_DESCRIPTION' ), 'description'); ?>
                    <div class="ip_spacer"></div>
                    <table class="summary_table" width="100%">
                      <tr>
                          <td valign="top" class="summary_left">
                            <?php
                                echo JHTML::_('content.prepare', $this->p->description );
                                if($this->amenities){
                                    $amenities = array(
                                        'general' => array(),
                                        'interior' => array(),
                                        'exterior' => array()
                                    );
                                    foreach ($this->amenities as $amen){
                                        switch ($amen->cat){
                                            case 0:
                                                $amenities['general'][] = $amen;
                                                break;
                                            case 1:
                                                $amenities['interior'][] = $amen;
                                                break;
                                            case 2:
                                                $amenities['exterior'][] = $amen;
                                                break;
                                            default:
                                                $amenities['general'][] = $amen;
                                                break;
                                        }
                                    }

                                    foreach($amenities as $k => $a){
                                        $amen_n     = (count($a));
                                        if($amen_n > 0) {
                                            switch($k){
                                                case 'general':
                                                    $amen_label = JText::_( 'COM_IPROPERTY_GENERAL_AMENITIES' );
                                                    break;
                                                case 'interior':
                                                    $amen_label = JText::_( 'COM_IPROPERTY_INTERIOR_AMENITIES' );
                                                    break;
                                                case 'exterior':
                                                    $amen_label = JText::_( 'COM_IPROPERTY_EXTERIOR_AMENITIES' );
                                                    break;

                                            }
                                            $amen_left  = '';
                                            $amen_right = '';

                                            for ($i = 0; $i < $amen_n; $i++):
                                                if ($i < ($amen_n/2)):
                                                    $amen_left  = $amen_left.'<li class="ip_checklist">'.$a[$i]->title.'</li>';
                                                elseif ($i >= ($amen_n/2)):
                                                    $amen_right = $amen_right.'<li class="ip_checklist">'.$a[$i]->title.'</li>';
                                                endif;
                                            endfor;


                                            echo '
                                                <div class="ip_amenities">
                                                    <b>'.$amen_label.'</b>
                                                    <table class="ipamen_table" width="100%">
                                                        <tr>
                                                            <td width="50%" valign="top">
                                                                <ul class="amen_left">'.$amen_left.'</ul>
                                                            </td>
                                                            <td width="50%" valign="top">
                                                                <ul class="amen_right">'.$amen_right.'</ul>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>';
                                        }
                                    }
                                }
                                if($this->p->terms) echo '<div class="ipterms">'.$this->p->terms.'</div>';
                            ?>
                          </td>
                          <?php echo $sidecol; ?>
                      </tr>
                    </table>
                <?php
                echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_DETAILS' ), 'details_panel');
                ?>
                    <div class="ip_spacer"></div>
                    <table class="summary_table" width="100%">
                      <tr>
                          <td valign="top" class="summary_left">
                            <table class="ip_details_table_container" width="100%">
                                <tr>
                                    <td valign="top" width="50%">
                                        <table class="ip_details_table" cellspacing="2">
                                            <?php if($this->p->beds): ?>
                                            <tr>
                                                <td width="40%" class="key"><?php echo JText::_( 'COM_IPROPERTY_BEDS' ); ?>:</td>
                                                <td width="60%"><?php echo $this->p->beds; ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if($this->p->baths && $this->p->baths != '0.00'): ?>
                                            <tr>
                                                <td class="key"><?php echo JText::_( 'COM_IPROPERTY_BATHS' ); ?>:</td>
                                                <td><?php echo $this->p->baths; ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if($this->p->sqft): ?>
                                            <tr>
                                                <td class="key"><?php echo (!$this->settings->measurement_units) ? JText::_( 'COM_IPROPERTY_SQFT' ) : JText::_( 'COM_IPROPERTY_SQM' ); ?>:</td>
                                                <td><?php echo is_numeric($this->p->sqft) ? number_format($this->p->sqft) : $this->p->sqft; ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if($this->p->lotsize): ?>
                                            <tr>
                                                <td class="key"><?php echo JText::_( 'COM_IPROPERTY_LOT_SIZE' ); ?>:</td>
                                                <td><?php echo is_numeric($this->p->lotsize) ? number_format($this->p->lotsize) : $this->p->lotsize; ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if($this->p->lot_acres): ?>
                                            <tr>
                                                <td class="key"><?php echo JText::_( 'COM_IPROPERTY_LOT_ACRES' ); ?>:</td>
                                                <td><?php echo $this->p->lot_acres; ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if($this->p->lot_type): ?>
                                            <tr>
                                                <td class="key"><?php echo JText::_( 'COM_IPROPERTY_LOT_TYPE' ); ?>:</td>
                                                <td><?php echo $this->p->lot_type; ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if($this->p->heat): ?>
                                            <tr>
                                                <td class="key"><?php echo JText::_( 'COM_IPROPERTY_HEAT' ); ?>:</td>
                                                <td><?php echo $this->p->heat; ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if($this->p->cool): ?>
                                            <tr>
                                                <td class="key"><?php echo JText::_( 'COM_IPROPERTY_COOL' ); ?>:</td>
                                                <td><?php echo $this->p->cool; ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if($this->p->fuel): ?>
                                            <tr>
                                                <td class="key"><?php echo JText::_( 'COM_IPROPERTY_FUEL' ); ?>:</td>
                                                <td><?php echo $this->p->fuel; ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if($this->p->siding): ?>
                                            <tr>
                                                <td class="key"><?php echo JText::_( 'COM_IPROPERTY_SIDING' ); ?>:</td>
                                                <td><?php echo $this->p->siding; ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if($this->p->roof): ?>
                                            <tr>
                                                <td class="key"><?php echo JText::_( 'COM_IPROPERTY_ROOF' ); ?>:</td>
                                                <td><?php echo $this->p->roof; ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if($this->p->reception): ?>
                                            <tr>
                                                <td class="key"><?php echo JText::_( 'COM_IPROPERTY_RECEPTION' ); ?>:</td>
                                                <td><?php echo $this->p->reception; ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if($this->p->tax): ?>
                                            <tr>
                                                <td class="key"><?php echo JText::_( 'COM_IPROPERTY_TAX' ); ?>:</td>
                                                <td><?php echo $this->p->tax; ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if($this->p->income): ?>
                                            <tr>
                                                <td class="key"><?php echo JText::_( 'COM_IPROPERTY_INCOME' ); ?>:</td>
                                                <td><?php echo $this->p->income; ?></td>
                                            </tr>
                                            <?php endif; ?>
                                        </table>
                                     </td>
                                     <td valign="top" width="50%">
                                        <table class="ip_details_table" cellspacing="2">
                                            <?php if($this->p->yearbuilt): ?>
                                            <tr>
                                                <td class="key" width="40%"><?php echo JText::_( 'COM_IPROPERTY_YEAR_BUILT' ); ?>:</td>
                                                <td width="60%"><?php echo $this->p->yearbuilt; ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if($this->p->zoning): ?>
                                            <tr>
                                                <td class="key"><?php echo JText::_( 'COM_IPROPERTY_ZONING' ); ?>:</td>
                                                <td><?php echo $this->p->zoning; ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if($this->p->propview): ?>
                                            <tr>
                                                <td class="key"><?php echo JText::_( 'COM_IPROPERTY_PROPVIEW' ); ?>:</td>
                                                <td><?php echo $this->p->propview; ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if($this->p->school_district): ?>
                                            <tr>
                                                <td class="key"><?php echo JText::_( 'COM_IPROPERTY_SCHOOL_DISTRICT' ); ?>:</td>
                                                <td><?php echo $this->p->school_district; ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if($this->p->style): ?>
                                            <tr>
                                                <td class="key"><?php echo JText::_( 'COM_IPROPERTY_STYLE' ); ?>:</td>
                                                <td><?php echo $this->p->style; ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if($this->p->garage_type): ?>
                                            <tr>
                                                <td class="key"><?php echo JText::_( 'COM_IPROPERTY_GARAGE_TYPE' ); ?>:</td>
                                                <td><?php echo $this->p->garage_type; ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if($this->p->garage_size): ?>
                                            <tr>
                                                <td class="key"><?php echo JText::_( 'COM_IPROPERTY_GARAGE_SIZE' ); ?>:</td>
                                                <td><?php echo $this->p->garage_size; ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if($this->settings->adv_show_wf && $this->p->frontage): ?>
                                            <tr>
                                                <td class="key"><?php echo JText::_( 'COM_IPROPERTY_FRONTAGE' ); ?>:</td>
                                                <td><?php echo JText::_( 'COM_IPROPERTY_YES' ); ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if($this->settings->adv_show_hoa && $this->p->reo): ?>
                                            <tr>
                                                <td class="key"><?php echo JText::_( 'COM_IPROPERTY_REO' ); ?>:</td>
                                                <td><?php echo JText::_( 'COM_IPROPERTY_YES' ); ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if($this->settings->adv_show_hoa && $this->p->hoa): ?>
                                            <tr>
                                                <td class="key"><?php echo JText::_( 'COM_IPROPERTY_HOA' ); ?>:</td>
                                                <td><?php echo JText::_( 'COM_IPROPERTY_YES' ); ?></td>
                                            </tr>
                                            <?php endif; ?>
                                        </table>
                                     </td>
                                  </tr>
                               </table>
                          </td>
                          <?php echo $sidecol; ?>
                      </tr>
                    </table>
                <?php
                if( $this->p->video ):
                    echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_VIDEO' ), 'video_panel');
                ?>
                        <div class="ip_spacer"></div>
                        <table class="summary_table" width="100%">
                          <tr>
                              <td valign="top" align="center">
                                <?php echo JHTML::_('content.prepare', $this->p->video ); ?>
                              </td>
                          </tr>
                        </table>
                <?php
                endif;
                echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_REQUEST_SHOWING' ), 'req_panel');
                ?>
                    <div class="ip_spacer"></div>
                    <table class="summary_table" width="100%">
                      <tr>
                          <td valign="top" class="summary_left">
                            <?php
                                echo '<p>'.JText::_( 'COM_IPROPERTY_REQUEST_SHOWING_TEXT' ).'</p>';
                                echo $this->loadTemplate('requestshow');
                            ?>
                          </td>
                          <?php echo $sidecol; ?>
                      </tr>
                    </table>
                <?php
                if( $this->settings->show_sendtofriend == 1 ):
                    echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_SEND_TO_FRIEND' ), 'stf_panel');
                ?>
                    <div class="ip_spacer"></div>
                    <table class="summary_table" width="100%">
                      <tr>
                          <td valign="top" class="summary_left">
                            <?php
                                echo '<p>'.JText::_( 'COM_IPROPERTY_SEND_TO_FRIEND_TEXT' ).'</p>';
                                echo $this->loadTemplate('sendtofriend');
                            ?>
                          </td>
                          <?php echo $sidecol; ?>
                      </tr>
                    </table>
                <?php
                endif;
                $this->dispatcher->trigger( 'onAfterRenderForms', array( &$this->p, &$this->settings, $sidecol ) );
             echo JHtml::_('tabs.end');
             ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php $this->dispatcher->trigger( 'onAfterRenderProperty', array( &$this->p, &$this->settings ) ); ?>
        </td>
    </tr>
<?php
    //DISPLAY DISCLAIMER SET IN SETTINGS
    if( $this->settings->disclaimer ):
        echo '<tr><td colspan="2"><div id="ip_disclaimer">'. $this->settings->disclaimer .'</div></td></tr>';
    endif;
    if($this->settings->gallerytype == 3)
    {
        echo '<tr>
                <td colspan="2">
                    <div class="ip_hidden">';
                        for($i = 1; $i < count($this->images); $i++){
                            $path = ($this->images[$i]->remote == 1) ? $this->images[$i]->path : $this->folder;
                            $ip_imgtitle    = ($this->images[$i]->title) ? $this->images[$i]->title : $this->p->street_address;
                            $ip_imgdesc     = ($this->images[$i]->description) ? $this->images[$i]->description : $this->p->city.' '.ipropertyHTML::getStateName($this->p->locstate).$this->p->province;
                            echo '<a href="'.$path.$this->images[$i]->fname.$this->images[$i]->type.'" rel="lightbox-ipgallery" title="'.$ip_imgtitle.': '.$ip_imgdesc.'"></a>'."\n";

                            // Work around for same image loaded twice
                            // TODO: find cleaner solution
                            echo '<a href="'.$path.$this->images[$i]->fname.$this->images[$i]->type.'" rel="lightbox-ipgallery2" title="'.$ip_imgtitle.': '.$ip_imgdesc.'"></a>'."\n";
                        }
              echo '</div>
                </td>
             </tr>';
    }
?>
</table>
<?php
    //DISPLAY FOOTER IF ALLOWED IN ADMIN SETTINGS
    if( $this->settings->footer == 1):
        echo ipropertyHTML::buildThinkeryFooter();
    endif;
?>
