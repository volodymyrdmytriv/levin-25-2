<?php
defined('_JEXEC') or die('Restricted access');
//require(JPATH_COMPONENT.DS.'views'.DS.'advsearch'.DS.'tmpl'.DS.'default_searchbox.php');

$document = JFactory::getDocument();

// 	check if jQuery is loaded before adding it
if (!JFactory::getApplication()->get('jquery')) {
  	JFactory::getApplication()->set('jquery', true);
	//$document->addScript( "https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js" );
	$document->addScript( "http://code.jquery.com/jquery-1.9.1.min.js" );
}

$document->addStyleSheet( JURI::root(true).'/jQueryAssets/jquery-ui-1.10.4/themes/smoothness/jquery-ui.css ');
$document->addScript( JURI::root(true).'/jQueryAssets/jquery-ui-1.10.4/jquery-ui.js');

$jquery_js = '
jQuery(document).ready(function($) {
	onDOMReady();
});
';

$document->addScriptDeclaration( $jquery_js );

?>

<script>

	function onDOMReady()
	{
	
		// adding ajax support for selectors and doing filtering
	
		jQuery("#property_type").change(function() {
			var type_value = jQuery("#property_type").val();

			resetPropertySpace();
			
			doAjaxSearch({property_type: type_value, return_states: true, return_cities: true});

		});
	
		jQuery("#property_state").change(function() {
			var type_value = jQuery("#property_type").val();
			var state_value = jQuery("#property_state").val();

			resetPropertySpace();
			
			doAjaxSearch({property_type: type_value, property_state: state_value, return_cities:true });

		});
	
		jQuery("#property_city").change(function() {
			
			resetPropertySpace();
			
			updateGoogleMap();
		});

		jQuery("#property_space").change(function() {

			updateGoogleMap();

		});

		jQuery(".propertysearch_mainform .search_reset").click(function() {

			var type_value = jQuery("#property_type").val();
			
			resetPropertyType();
			jQuery("#property_state").val("");
			jQuery("#property_city").val("");
			resetPropertySpace();
			
			doAjaxSearch({return_states: true, return_cities: true});
			
		});
		
	}

	function resetPropertyType()
	{
		jQuery("#property_type option").removeAttr("selected");
		jQuery("#property_type").val("");
	}
	
	function resetPropertySpace()
	{
		jQuery("#property_space option").removeAttr("selected");
		jQuery("#property_space").val("");
	}
	
	function printObject(o) {
		  var out = '';
		  for (var p in o) {
		    out += p + ': ' + o[p] + '\n';
		  }
		  alert(out);
	}

	function updateGoogleMap() {
		
		propertyWidget1.options.search.property_type = jQuery("#property_type").val();
		propertyWidget1.options.search.property_state = jQuery("#property_state").val();
		propertyWidget1.options.search.property_city = jQuery("#property_city").val();
		propertyWidget1.options.search.property_space = jQuery("#property_space").val();

		propertyWidget1.search();
		
	}
	
	function doAjaxSearch(dataObj)
	{
		
		if(dataObj.return_states)
		{
			jQuery("#property_state").attr( "disabled", "disabled" );
		}
		if(dataObj.return_cities)
		{
			jQuery("#property_city").attr( "disabled", "disabled" );
		}

		jQuery("#property_space").attr( "disabled", "disabled" );
		
		var sliderValue1 = jQuery( "#space_range" ).slider( "values", 0 );
		var sliderValue2 = jQuery( "#space_range" ).slider( "values", 1 );

		//dataObj.property_minareasize = getSliderAmount(sliderValue1);
		//dataObj.property_maxareasize = getSliderAmount(sliderValue2);
		dataObj['<?php echo JUtility::getToken(); ?>'] = '1';
		dataObj.format = 'raw';
		
		var checkurl = '<?php echo JURI::base('true'); ?>/index.php?option=com_iproperty&task=ajax.ajaxSearch2';
		
		jQuery.ajax({
	      url: checkurl,
	      type: "POST",
	      data: dataObj,
		  dataType: 'json',
		  success: function(data){

				//alert(data.abc);
	           onAjaxResult(data);
	      },
	      error:function(){
		      
	      }   
		});
	}

	function onAjaxResult(jsonData)
	{
		
		var i;
		
		if(jsonData['states'] !== undefined)
		{
			jQuery("#property_state").removeAttr('disabled');
			
			var states = jsonData['states'];

			jQuery("#property_state option[value!='']").remove();

			for(i=0; i<states.length; i++)
			{
				var state_data = states[i];
				
				jQuery("#property_state").append('<option value="' + state_data.mc_name + '" >' + state_data.title.toUpperCase() + '</option>');
				
			}
			
		}

		if(jsonData['cities'] !== undefined)
		{
			jQuery("#property_city").removeAttr('disabled');
			
			var cities = jsonData['cities'];

			jQuery("#property_city option[value!='']").remove();
			
			for(i=0; i<cities.length; i++)
			{
				var city_data = cities[i];
				
				jQuery("#property_city").append('<option value="' + city_data.city + '" >' + city_data.city.toUpperCase() + '</option>');
				
			}
			
		}

		jQuery("#property_space").removeAttr('disabled');
		
		updateGoogleMap();
		
	}

	
</script>

<div class="propertysearch" >
<div class="searchmap" >
	<div id="mapCanvas" ></div>
</div>
<div class="searchform" >
<form class="propertysearch_mainform" action="<?php echo JURI::root(true) . '/index.php'; ?>"  method="get"  name="ip_propertysearch">
	<input type="hidden" name="option" value="com_iproperty" >
	
	<div class="dropdown-wrapper">
	<select id="property_type" name="property_type" >
		<option value="">TYPE</option>
		<?php foreach($this->types as $typerow) { ?>
			<option <?php if($this->property_type == $typerow->nameid) echo 'selected'; ?> value="<?php echo $typerow->nameid; ?>"><?php echo $typerow->name; ?></option>
		<?php } ?>
	</select>
	</div>
	<div class="spacer" style="height: 18px;"></div>
	<select id="property_state" name="property_state" >
		<option value="">STATE</option>
		<?php foreach($this->avail_states as $staterow) { ?>
			<option <?php if($this->property_state == $staterow->mc_name) echo 'selected'; ?> value="<?php echo $staterow->mc_name; ?>"><?php echo strtoupper($staterow->title); ?></option>
		<?php } ?>
	</select>
	<div class="spacer" style="height: 18px;"></div>
	<select id="property_city" name="property_city" >
		<option value="">CITY</option>
		<?php foreach($this->avail_cities as $cityrow) { ?>
			<option <?php if(trim($this->property_city) == trim($cityrow->city)) echo 'selected'; ?>  value="<?php echo $cityrow->city; ?>"><?php echo strtoupper($cityrow->city); ?></option>
		<?php } ?>
	</select>
	<div class="spacer" style="height: 18px;"></div>
	<select id="property_space" name="property_space">
		<option value="">CURRENTLY AVAILABLE</option>
		<?php 
			$spaces_info['0_2500'] = '2,500 SQ FT or Less';
			$spaces_info['2500_5000'] = '2,500 - 5,000 SQ FT';
			$spaces_info['5000_10000'] = '5,000 - 10,000 SQ FT';
			$spaces_info['10000_200000'] = '10,000 SQ FT or More';
			//$spaces_info['0_500000'] = 'All Available';
			
			foreach($spaces_info as $space_value=>$space_title) :
			
		?>
			<option <?php if($space_value == $this->property_space) echo 'selected'; ?> value="<?php echo $space_value; ?>" ><?php echo $space_title; ?></option>
		<?php endforeach; ?>
	</select>
	
	<div class="spacer" style="height: 18px;"></div>
	<input type="reset" value="Reset" class="search_reset" style="float: left">
	<input type="submit" value="LIST RESULTS" id="search-submit" style="float: right">
	<div style="clear: both; "></div>
	<?php
			
			if(count($this->portfolio_avail_report) > 0)
			{
				$pdf_file = $this->portfolio_avail_report[0];
				$pdf_href = $this->companies_folder . $pdf_file->fname. $pdf_file->type;
                
				echo '<div class="spacer" style="height: 18px;"></div>';
				echo '<div class="header-search-pdf-section">';
				echo '<a href="'.$pdf_href.'" target="_blank" >Portfolio Availability Report</a>';
				echo '</div>';
			}
			
	?>
</form>
</div>
</div>
