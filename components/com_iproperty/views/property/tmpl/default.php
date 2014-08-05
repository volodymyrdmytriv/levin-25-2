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
<div class="ip_mainheader" style="position: relative">
    <div>
    	<?php
    		
    		$html .= '<div id="ip_toolbar" style="float: right">';
    		$html .= '<a href="javascript:history.back();">'.JText::_( 'COM_IPROPERTY_BACK' ).'</a>';
    		$html .= '<a href="'.JRoute::_(ipropertyHelperRoute::getAdvsearchRoute()).'">'.JText::_( 'COM_IPROPERTY_SEARCH' ).'</a>';
    		$html .= '</div>';
    		
    		echo $html;
    		
    	?>
    	<h1><?php echo $this->p->title; ?></h1>
    	<div style="clear: both;" ></div>
    </div>
    <div class="iproperty_details_address" style="float: left; width: 452px;" >
	    <div style="width: 80%;"><?php echo $this->p->street_address2; ?></div>
		<div>
	       	<?php
			    
		      if( $this->p->city ) echo $this->p->city.',';
		      if( $this->p->locstate ) echo ' '.ipropertyHTML::getStateCode($this->p->locstate);
		      if( $this->p->postcode ) echo ' '.$this->p->postcode;
	           
			?>
		</div>
		<div>
			<?php
				
				$geoadd = '';
	            if($this->p->street_num) $geoadd .= $this->p->street_num;
	            if($this->p->street)     $geoadd .= ' '.$this->p->street;
	            if($this->p->street2)    $geoadd .= ' '.$this->p->street2;
	            if($this->p->city)       $geoadd .= ', '.$this->p->city;
	            if($this->p->locstate)   $geoadd .= ', '.ipropertyHTML::getStateCode($this->p->locstate);
	            if($this->p->province)   $geoadd .= ', '.$this->p->province;
	            if($this->p->postcode)   $geoadd .= ', '.$this->p->postcode;
	            if($this->p->country)    $geoadd .= ', '.ipropertyHTML::getCountryName($this->p->country);
	
	            $mapaddress = urlencode($geoadd);
		      	
		      	if(!empty($mapaddress))
		      	{
		      		$dir_href = 'https://maps.google.com/maps?f=d&amp;hl=en&amp;daddr='.$mapaddress;
		      		
		      		echo '<a href="'.$dir_href.'" class="property-details-directions-button" target="_blank" title="Get Directions">GET DIRECTIONS</a>';
		      	}
		      	
			?>
		</div>
	</div>
	<?php if(count($this->agents) > 0): ?>
	<div class="iproperty_details_agents" style="float: left; text-align: left; width: 452px; ">
		<?php 
			foreach($this->agents as $agentdata)
			{
				
				echo '<div><b>'.$agentdata->agent_name . '</b> ('.$agentdata->title.')</div>';
				echo '<div>';
				if(!empty($agentdata->phone))
				{
					echo '<span>'. $agentdata->phone . ', </span>';
				}
				if(!empty($agentdata->email))
				{
					echo '<a href="mailto:' . $agentdata->email . '" title="Email" >'.$agentdata->email.'</a>';
				}
				echo '</div>';
				echo '<div style="height: 8px;"></div>';
				
			}
		?>
	</div>
	<?php endif; ?>
	<div style="clear: both;"></div>
</div>

<table class="ptable" style="position: relative;">
    <tr>
        <td valign="top" colspan="2">
        	
        	<div style="margin: 0px; position: absolute; top: -3px; right: 23px; ">
				<?php
			
					if(count($this->aerial_pdf) > 0)
					{
						$pdf_file = $this->aerial_pdf[0];
						
						$path = ($pdf_file->remote == 1) ? $pdf_file->path : $this->folder;
						$href_origin = $path . $pdf_file->fname . $pdf_file->type;
			        	
						echo '<a target="_blank" href="'.$href_origin.'" class="property-tab-button" title="Aerial" ><span class="pdf-icon"></span>Aerial</a>';
					}
				
					if(count($this->leasing_plan_pdf) > 0)
					{
						$pdf_file = $this->leasing_plan_pdf[0];
						
						$path = ($pdf_file->remote == 1) ? $pdf_file->path : $this->folder;
						$href_origin = $path . $pdf_file->fname . $pdf_file->type;
			        	
						echo '<a target="_blank" href="'.$href_origin.'" class="property-tab-button" title="Leasing Plan" ><span class="pdf-icon"></span>Leasing Plan</a>';
					}
				
					if(count($this->marketing_flyer_pdf) > 0)
					{
						$pdf_file = $this->marketing_flyer_pdf[0];
						
						$path = ($pdf_file->remote == 1) ? $pdf_file->path : $this->folder;
						$href_origin = $path . $pdf_file->fname . $pdf_file->type;
			        	
						echo '<a target="_blank" href="'.$href_origin.'" class="property-tab-button" title="Marketing Flyer" ><span class="pdf-icon"></span>Marketing Flyer</a>';
					}
				?>
			</div>
        	
            <?php
            echo JHtml::_('tabs.start', 'detailsPane', array('useCookie' => false));
            $this->dispatcher->trigger( 'onBeforeRenderForms', array( &$this->p, &$this->settings, $sidecol ) );
            echo JHtml::_('tabs.panel', 'Property Details'); ?>
            	<div class="property-tab-details-content">
            	<div style="float: left; width: 400px; ">
	            	
            		<script>
            		
            			function createSlideshow() {

              	          if(jQuery('#property_slideshow').length > 0)
              	          {
	            	          jQuery('#property_slideshow').bjqs({
	            	            animtype      : 'slide',
	            	            animduration: 250,
	            	            width         : 400,
	            	            height        : 238,
	            	            responsive    : true,
	            	            randomstart   : false,
	            	            automatic: false
	            	          });
	
	            	          jQuery('.property_image_popup').fancybox();
              	          }

              	          if(jQuery('.trade_image_popup').length > 0)
              	          {
              	        	jQuery('.trade_image_popup').fancybox();
              	          }

              	          if(jQuery('.leasing_image_popup').length > 0)
            	          {
            	        	jQuery('.leasing_image_popup').fancybox();
            	          }
              	          
            	          
            	        };
            		</script>
            		
            		<?php if(count($this->images) > 0): ?>
            		<div id="property_slideshow">
            				<!-- start Basic Jquery Slider -->
					        <ul class="bjqs">
					        <?php 
						        for($i = 0; $i < count($this->images); $i++){
	                            	$path = ($this->images[$i]->remote == 1) ? $this->images[$i]->path : $this->folder;
	                            	
	                            	$href_normal = $path . $this->images[$i]->fname . '_normal' . $this->images[$i]->type;
	                            	$href_origin = $path . $this->images[$i]->fname . $this->images[$i]->type;
	                            	
	                            	$desc = $this->images[$i]->description;
	                            	echo '<li><a class="property_image_popup"  data-fancybox-group="gallery" href="'.$href_origin.'" ><img style="width: 100%" src="'.$href_normal.'" title="' . $desc . '" ></a></li>';
	                        	}
                        	?>
					        </ul>
					        <!-- end Basic jQuery Slider -->
            		</div>
            		<div class="ip_spacer"></div>
            		<div class="ip_spacer"></div>
            		<div class="ip_spacer"></div>
            		
            		<?php else: 
            			
            			echo '<img src="'.$this->folder . '/nopic.png"></img>';
            			
            		 endif; ?>
            		
            		<div class="ip_spacer"></div>
            		
            		<div id="property-stats-wrapper" >
							<div class="property-stat" id="property-stat-1" style="float: left; width: 157px; ">
								<div class="label">Gross Leasable Area</div>
								<div class="value"><?php echo $this->p->formattedsqft; ?></div>
							</div>
							<div class="property-stat" id="property-stat-2" style="float: left; width: 112px; ">
								<div class="label"></div>
								<div class="value"></div>
							</div>
							<div class="property-stat" id="property-stat-3" style="float: left; width: 152px ;">
								<div class="label"></div>
								<div class="value"></div>
							</div>
					</div>
            		
                    <div class="ip_spacer"></div>
                    
                    <?php
                    
                    	if(count($this->demographics) > 1):
                    
                    ?>
                    <table cellpadding="0" cellspacing="0" style="width: 100%;" >
							<tbody>
							<tr class="demographics-header">
								<td style="width: 40%" class="demographics-title" ><span class="property-details-title">Demographics</span></td>
								<td style="width: 20%" ><?php echo intval($this->demographics[0]->miles1_value) ?> MILES</td>
								<td style="width: 20%" ><?php echo intval($this->demographics[0]->miles2_value) ?> MILES</td>
								<td style="width: 20%" ><?php echo intval($this->demographics[0]->miles3_value) ?> MILES</td>
							</tr>
							<?php
								
								$d_count = count($this->demographics);
								for($i=1; $i<$d_count; $i++)
								{
									$demographics_data = $this->demographics[$i];
									
									$prefix = '';
									$suffix = '';
									$decimals = 0;
									
									if($demographics_data->stat_value_type == 'currency')
									{
                    $prefix = '$';
									}
									else if($demographics_data->stat_value_type == 'percent')
									{
                    $suffix = '%';
                    $decimals = 2;
									}
									
									$miles1_value = number_format( $demographics_data->miles1_value, $decimals );
									$miles2_value = number_format( $demographics_data->miles2_value, $decimals );
									$miles3_value = number_format( $demographics_data->miles3_value, $decimals );
									
									$miles1_value = $prefix.$miles1_value.$suffix;
									$miles2_value = $prefix.$miles2_value.$suffix;
									$miles3_value = $prefix.$miles3_value.$suffix;
									
									echo '<tr>';
									echo '<td class="dem-label">'.$demographics_data->stat_name.'</td>';
									echo '<td class="dem-col-1">'.$miles1_value.'</td>';
									echo '<td class="dem-col-2">'.$miles2_value.'</td>';
									echo '<td class="dem-col-3">'.$miles3_value.'</td>';
									echo '</tr>';
									
								}
								
							?>
						</tbody>
						</table>
                    <?php endif; ?>
                </div>
                <div style="float: left; width: 555px; padding-left: 30px;">
                	
                	<?php
						
                		if(count($this->images_trade) > 0)
                		{
                			$trade_image = $this->images_trade[0];
                			
                			$path = ($trade_image->remote == 1) ? $trade_image->path : $this->folder;
	                           
	                        $href_normal = $path . $trade_image->fname . '_normal' . $trade_image->type;
	                        $href_origin = $path . $trade_image->fname . $trade_image->type;
	                        
	                        echo '<div style="position: relative">';
                			echo '<a class="trade_image_popup"  data-fancybox-group="gallery2" href="'.$href_origin.'" ><img style="width: 100%" src="'. $href_normal .'" ></img></a>';
                			echo '<div style="position: absolute; top: 0px; padding: 7px; background-color: black;  color: white; font-weight: bold;">TRADE AREA</div>';
	                        echo '</div>';
	                        echo '<div class="ip_spacer"></div>';
                		}
                	
                	?>
                	
                	<div class="property-details-title" >Details</div>
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
                	
                </div>
                <div style="clear: both; ">
                </div>
                <?php
                echo JHtml::_('tabs.panel', 'Leasing Plan');
                ?>
                    
                    <div >
	                    <!-- info area -->
	                    <div style="float: left; width: 310px;">
	                    <div class="property-details-title" style="width: 100%; border-bottom: solid 1px #CCCCCC; margin-bottom: 8px;" >Space Available</div>
	                    <?php
							
	                    	if(count($this->spaces_available) > 0)
	                    	{
	                    		$column1_count = intval(ceil( count($this->spaces_available) / 2 ) );
	                    		
	                    		echo '<div class="space-available">';
	                    		echo '<div style="float: left; width: 150px;">';
	                    		for($i=0; $i<$column1_count; $i++)
	                    		{
	                    			echo '<a class="disabled-space-link" href="javascript: void(0)" style="display: block">';
	                    			echo '<span class="bullet">'.$this->spaces_available[$i]->space_id2.'</span>';
	                    			echo '<span class="lp-space-title">'.$this->spaces_available[$i]->formatted_space_sqft.'</span>';
	                    			echo '</a>';
	                    		}
	                    		echo '</div>';
	                    		
	                    		$i = $column1_count;
	                    		echo '<div style="float: left; width: 150px;">';
	                    		for(; $i<count($this->spaces_available); $i++)
	                    		{
	                    			echo '<a class="disabled-space-link" href="javascript: void(0)" style="display: block">';
	                    			echo '<span class="bullet">'.$this->spaces_available[$i]->space_id2.'</span>';
	                    			echo '<span class="lp-space-title">'.$this->spaces_available[$i]->formatted_space_sqft.'</span>';
	                    			echo '</a>';
	                    		}
	                    		echo '</div>';
	                    		echo '<div style="clear: both; "></div>';
	                    		echo '</div>';
	                    	}
	                    	else
	                    	{
	                    		echo '<div>No Spaces Available.</div>';
	                    	}
	                    
	                    ?>
	                    <div class="ip_spacer"></div>
	                    <div class="property-details-title" style="width: 100%; border-bottom: solid 1px #CCCCCC; margin-bottom: 8px;"  >Current Tenants</div>
	                    <?php
							
	                    	if(count($this->tenants) > 0)
	                    	{
	                    		$column1_count = intval(ceil( count($this->tenants) / 2 ));
	                    		
	                    		echo '<div class="current-tenants">';
	                    		echo '<div style="float: left; width: 150px;">';
	                    		for($i=0; $i<$column1_count; $i++)
	                    		{
	                    			echo '<div class="tenant-item">';
	                    			echo '<span class="tenant-number">'.$this->tenants[$i]->space_id2.'</span>';
	                    			echo '<span class="tenant-name">'.$this->tenants[$i]->tenant.'</span>';
	                    			echo '</div>';
	                    		}
	                    		echo '</div>';
	                    		
	                    		$i = $column1_count;
	                    		echo '<div style="float: left; width: 150px;">';
	                    		for(; $i<count($this->tenants); $i++)
	                    		{
	                    			echo '<div class="tenant-item">';
	                    			echo '<span class="tenant-number">'.$this->tenants[$i]->space_id2.'</span>';
	                    			echo '<span class="tenant-name">'.$this->tenants[$i]->tenant.'</span>';
	                    			echo '</div>';
	                    		}
	                    		echo '</div>';
	                    		echo '<div style="clear: both; "></div>';
	                    		echo '</div>';
	                    		
	                    	}
	                    	else
	                    	{
	                    		echo '<div>No Tenants Available</div>';
	                    	}
	                    
	                    ?>
	                       <div class="ip_spacer"></div>
	                    </div>
	                    <!-- image area area -->
	                    <div style="float: left; width: 640px; padding-left: 30px;">
	                    	<?php 
	                    	if(count($this->images_leasing) > 0)
	                    	{
	                    		// display only first image
	                    		$i = 0;
	                    		
            			        $path = ($this->images_leasing[$i]->remote == 1) ? $this->images[$i]->path : $this->folder;
	                            
	                            $href_normal = $path . $this->images_leasing[$i]->fname . '_normal' . $this->images_leasing[$i]->type;
	                            $href_origin = $path . $this->images_leasing[$i]->fname . $this->images_leasing[$i]->type;
	                            
	                            $desc = $this->images_leasing[$i]->description;
	                            echo '<a class="leasing_image_popup"  data-fancybox-group="gallery" href="'.$href_origin.'" ><img style="width: 100%" src="'.$href_normal.'" title="' . $desc . '" ></a>';
	                            
			                }
		                    else
		                    { 
		            			
		            			echo '<img src="'.$this->folder . '/nopic.png" style="display: block; margin-left: auto; margin-right: auto; " ></img>';
		            			
		                    } 
		                    ?>
		                   <div class="ip_spacer"></div>
	                    </div>
	                    
	                	<div style="clear: both;" >
                	</div>
                	
                <?php
                
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
