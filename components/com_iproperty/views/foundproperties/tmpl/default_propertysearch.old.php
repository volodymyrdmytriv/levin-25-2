<?php
defined('_JEXEC') or die('Restricted access');
//require(JPATH_COMPONENT.DS.'views'.DS.'advsearch'.DS.'tmpl'.DS.'default_searchbox.php');

$document = JFactory::getDocument();

// 	check if jQuery is loaded before adding it
if (!JFactory::getApplication()->get('jquery')) {
  	JFactory::getApplication()->set('jquery', true);
	$document->addScript( "https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js" );
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
		// getting property space values
		var space_slider_values = jQuery('#space_slider_values').val();
		var sliderStartValue = 0;
		var sliderEndValue = 50;
		if(space_slider_values.indexOf('_') >= 0)
		{
			var valuesArr = space_slider_values.split('_');
			sliderStartValue = parseInt(valuesArr[0]);
			sliderEndValue = parseInt(valuesArr[1]);
		}
		
		var startAmount = getSliderAmount(sliderStartValue);
		var endAmount = getSliderAmount(sliderEndValue);
		
	    jQuery("#search-space").text(formatAmount(startAmount) + ' - ' + formatAmount(endAmount));
		
		jQuery.ui.slider.prototype.widgetEventPrefix = 'slider';
		jQuery( "#space_range" ).slider({
		      range: true,
		      min: 0,
		      max: 50,
		      values: [ sliderStartValue, sliderEndValue ],
		      slide: function( event, ui ) {
		        	
					var startAmount = getSliderAmount(ui.values[0]);
					var endAmount = getSliderAmount(ui.values[1]);
					
			        jQuery("#search-space").text(formatAmount(startAmount) + ' - ' + formatAmount(endAmount));
			        jQuery("#property_space").val(startAmount + '_' + endAmount);
			        jQuery('#space_slider_values').val(ui.values[0] + '_' + ui.values[1]);
			        
		      },
		      change: function( event, ui ) {
	
					//triggered after finishing sliding
		    	  //doAjaxSearch({});
			      
		      }
		});
	
		// adding ajax support for selectors and doing filtering
	
		jQuery("#property_type").change(function() {
			var type_value = jQuery("#property_type").val();
	
			doAjaxSearch({property_type: type_value, return_states: true, return_cities: true});

		});
	
		jQuery("#property_state").change(function() {
			var type_value = jQuery("#property_type").val();
			var state_value = jQuery("#property_state").val();
	
			doAjaxSearch({property_type: type_value, property_state: state_value, return_cities:true });

		});
	
		jQuery("#property_city").change(function() {
			var type_value = jQuery("#property_type").val();
			var state_value = jQuery("#property_state").val();
			var city_value = jQuery("#property_city").val();
			
			doAjaxSearch({property_type: type_value, property_state: state_value, property_city:city_value });

			//called on ajax result
			//updateGoogleMap();
		});

		jQuery(".propertysearch_mainform .search_reset").click(function() {

			var type_value = jQuery("#property_type").val();
			
			jQuery("#property_type").val("");
			jQuery("#property_state").val("");
			jQuery("#property_city").val("");
			
			doAjaxSearch({return_states: true, return_cities: true});
			
		});
		
	}

	function setSliderAmounts(start, end)
	{
		
		var sliderStartValue = 0;
		var sliderEndValue = 50;
		if(start < end)
		{
			sliderStartValue = getSliderValue(start, true);
			sliderEndValue = getSliderValue(end, false);
		}

		// get corrected space sizes for use in slider
		var start2 = getSliderAmount(sliderStartValue);
		var end2 = getSliderAmount(sliderEndValue);

		jQuery("#space_range" ).slider("values", [sliderStartValue, sliderEndValue]);
		
		jQuery("#search-space").text(formatAmount(start2) + ' - ' + formatAmount(end2));
		jQuery("#property_space").val(start2 + '_' + end2);
		jQuery('#space_slider_values').val(sliderStartValue + '_' + sliderEndValue);
		
	}
	
	function getSliderAmount(value)
	{
		var amount = 0;
		var limit1 = 37;
		var limit1_amount = 10000;
		
		if(value < limit1)
		{
			amount = Math.round((value / limit1) * limit1_amount);
			// rounding to 200
			amount = Math.round(amount / 200) * 200;
		}
		else
		{
			amount = Math.round(((value - limit1) / (50 - limit1)) * (200000 - limit1_amount));
			// rounding to 200
			amount = Math.round(amount / 200) * 200;
			amount += limit1_amount;
		}
		
		return amount;
	}

	function getSliderValue(amount, startvalue)
	{
		var value = 0;
		var limit1 = 37;
		var limit1_amount = 10000;
		
		if(amount <= limit1_amount)
		{
			value = (amount / limit1_amount) * limit1;
		}
		else
		{
			value = limit1 + ((amount - limit1_amount) / (200000 - limit1_amount))*(50 - limit1);
		}
		
		if(startvalue)
		{
			value = Math.floor(value);
		}
		else
		{
			value = Math.ceil(value);
		}
		//value = Math.round(value);
		
		if(value > 50)
		{
			value = 50;
		}
		if(value < 0)
		{
			value = 0;
		}
		
		return value;	
	}

	function formatAmount(amount)
	{
		var result = amount.toString();
		if(amount >= 1000)
		{
			result = result.substr(0, result.length - 3) + ',' + result.substr(result.length - 3);
		}
		
		return result;
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
		propertyWidget1.options.search.property_space = '';

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

			jQuery("#property_state option:[value!='']").remove();

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

			jQuery("#property_city option:[value!='']").remove();
			
			for(i=0; i<cities.length; i++)
			{
				var city_data = cities[i];
				
				jQuery("#property_city").append('<option value="' + city_data.city + '" >' + city_data.city.toUpperCase() + '</option>');
				
			}
			
		}

		if(jsonData['space_available'] !== undefined)
		{
			
			setSliderAmounts(parseInt(jsonData['space_available']['min']), parseInt(jsonData['space_available']['max']));
			
		}
		
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
	<input id="property_space" type="hidden" name="property_space" value="<?php echo $this->property_space; ?>" >
	<input id="space_slider_values" type="hidden" name="space_slider_values" value="<?php echo $this->space_slider_values; ?>" >
	
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
	<div id="search-space-available-text" >SPACE AVAILABLE:<div style="float: right; color: #4967a2; "><span id="search-space">0 - 200,000</span> sf</div>
	</div>
	<div id="space_range" style="height: 19px;"></div>
	<div class="spacer" style="height: 18px;"></div>
	<input type="reset" value="Reset" class="search_reset" style="float: left">
	<input type="submit" value="LIST RESULTS" id="search-submit" style="float: right">
	
</form>
</div>
</div>
