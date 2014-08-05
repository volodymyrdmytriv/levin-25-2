<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Iproperty
 * @copyright (C) 2013 the Thinkery
 * @license see LICENSE.php
 */

defined('_JEXEC') or die('Restricted access');


?>

<div style="margin: 18px;">
<form class="qs_propertysearch_mainform" action="<?php echo JURI::root(true) . '/index.php'; ?>"  method="get"  name="ip_quicksearch">
	<input type="hidden" name="option" value="com_iproperty" >
<div style="float: left;  ">
	<div class="dropdown-wrapper">
	<select id="qs_property_type" name="property_type" >
		<option value="">TYPE</option>
		<?php foreach($types as $typerow) { ?>
			<option value="<?php echo $typerow->nameid; ?>"><?php echo $typerow->name; ?></option>
		<?php } ?>
	</select>
	</div>
	<div class="spacer" style="height: 18px;"></div>
	<select id="qs_property_state" name="property_state" >
		<option value="">STATE</option>
		<?php foreach($states as $staterow) { ?>
			<option value="<?php echo $staterow->mc_name; ?>"><?php echo strtoupper($staterow->title); ?></option>
		<?php } ?>
	</select>
	<div class="spacer" style="height: 18px;"></div>
	<select id="qs_property_city" name="property_city" >
		<option value="">CITY</option>
		<?php foreach($cities as $cityrow) { ?>
			<option value="<?php echo $cityrow->city; ?>"><?php echo strtoupper($cityrow->city); ?></option>
		<?php } ?>
	</select>
</div>
<div style="float: left;  margin-left: 18px; ">
	<select id="qs_property_space" name="property_space">
		<option value="">CURRENTLY AVAILABLE</option>
		<?php 
			$spaces_info['0_2500'] = '2,500 SQ FT or Less';
			$spaces_info['2500_5000'] = '2,500 - 5,000 SQ FT';
			$spaces_info['5000_10000'] = '5,000 - 10,000 SQ FT';
			$spaces_info['10000_200000'] = '10,000 SQ FT or More';
			//$spaces_info['0_500000'] = 'All Available';
			
			foreach($spaces_info as $space_value=>$space_title) :
			
		?>
			<option value="<?php echo $space_value; ?>" ><?php echo $space_title; ?></option>
		<?php endforeach; ?>
	</select>
	
	<div class="spacer" style="height: 18px;"></div>
	<input type="reset" value="Reset" class="search_reset" style="float: left">
	<input type="submit" value="SEARCH" id="qs_search-submit" style="float: right">
</div>
<div style="clear: both;" ></div>
</form>
</div>

<div id="header-property-search-bottom" >
	<div class="header-search-pdf-section">
		<?php
			
			if(count($portfolio_avail_report) > 0)
			{
				$pdf_file = $portfolio_avail_report[0];
				$pdf_href = $companies_folder . $pdf_file->fname. $pdf_file->type;
                
				echo '<a href="'.$pdf_href.'" target="_blank" >Portfolio Availability Report</a>';
			}
			else
			{
				echo '<span>Portfolio Availability Report</span>';
			}
		?>
		
	</div>
</div>

