<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

$munits     = (!$this->settings->measurement_units) ? JText::_( 'COM_IPROPERTY_SQFT' ) : JText::_( 'COM_IPROPERTY_SQM' );
$border     = ($this->p->featured) ? ' style="border: solid 1px ' . $this->settings->featured_accent . ';"' : '';
$span_style = ($this->p->featured) ? ' style="color: ' . $this->settings->featured_accent . ';"' : '';

// get listing info
$show_list_ag 	= $this->params->get('show_list_ag', false);
$show_list_co 	= $this->params->get('show_list_co', false);
$show_created 	= $this->params->get('show_created', false);
$show_modified 	= $this->params->get('show_modified', false);
$show_stype 	= $this->params->get('show_stype', false);

if($show_list_ag){
	$agents = ipropertyHTML::getAvailableAgents($this->p->id);
} else {
	$agents = false;
}

$listing_info = ipropertyHTML::getListingInfo($this->p->listing_office, $agents[0]->id, $this->p->created, $this->p->modified, $this->p->stype, $show_list_ag, $show_list_co, $show_created, $show_modified, $show_stype, $this->p->listing_info);

?>

<tr class="prop_overview_container iprow<?php echo $this->k; ?>">
	<td class="prop_overview_img">
		<div class="property_thumb_holder"<?php echo $border; ?>>
            <?php echo ipropertyHTML::getThumbnail($this->p->id, $this->p->proplink, $this->p->street_address, /*$this->thumb_width*/117, 'class="ip_overview_thumb"'); ?>
        </div>
        <!-- <div class="prop_overview_price" align="right">
        	<?php echo $this->p->formattedprice; ?>
        </div>-->
	</td> 
	<td style="vertical-align: middle">
		<div style="vertical-align: middle" >
		<div><a href="<?php echo $this->p->proplink; ?>"<?php echo $span_style; ?> class="property_header_accent"><?php echo $this->p->title; ?></a></div>
		<div class="iproperty_table_address">
			<div><?php echo $this->p->street_address2; ?></div>
			<div>
	        	<?php
				    
		            if( $this->p->city ) echo ' - '.$this->p->city;
		            if( $this->p->locstate ) echo ', '.ipropertyHTML::getStateCode($this->p->locstate);
	            	
				?>
			</div>
		</div>
		</div>
	</td>
	<td>
		<div>
	        	<?php
				    
		            if( $this->p->city ) echo $this->p->city;
		            if( $this->p->locstate ) echo ', '.ipropertyHTML::getStateCode($this->p->locstate);
	            	
				?>
		</div>
	</td>
	<td>
		<div>
			<?php if( $this->p->sqft ) echo $this->p->formattedsqft; ?>
		</div>
	</td>
	<td>
		<div>
			<?php 
				
				if($this->p->count_spaces == 0)
				{
					echo 'Spaces Not Defined';
				}
				else if($this->p->avail_spaces > 0)
				{
					echo '<b>Space Available!</b>';
					//echo '<b>Space Available!</b>'.$this->p->avail_spaces;
				}
				else if($this->p->avail_spaces == 0)
				{
					echo '<b>100% Leased</b>';
				}
				
			?>
		</div>
	</td>
	<td>
		<div>
			<?php

				$charlimit = 100;
				$tenants_str = '';
				
				foreach($this->p->tenants as $tenantrow)
				{
					if($tenantrow->available == 1)
					{
						if(strlen($tenants_str) > $charlimit)
						{
							break;
						}
						
						if(strlen($tenants_str) > 0)
						{
							$tenants_str .= ', ';
						}
						
						$tenants_str .= $tenantrow->tenant;
					}
				}
				
				echo $tenants_str;
			?>
		</div>
	</td>
	
</tr>
